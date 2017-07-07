<?php

namespace Core\Model;

/**
 * Default report object
 *
 * @author arthur.puthin
 * @since 04/12/2016
 */
class Report {

	public $salesmen;
	public $customers;
	public $sales;

	private $mostExpensiveSale;

	private $salesBySalesman;
	private $worstSalesmanEver;
	
	private $filename;

	public function __construct($filename) {
		$this->filename 				= $filename;
		$this->mostExpensiveSale 		= null;
		$this->salesBySalesman 			= array();
		$this->worstSalesmanEver		= '';
	}

	/**
	 * The printing function. Triggers the sales' verification
	 *	and does the output parsing to the extent needed.
	 *
	 * @param $mode The output mode to be used to print the report; 
	 *	default: 'file' exports to a .done.dat file.
	 */
	public function print(string $mode = 'file') {
		$this->verifySales();

		$output = array();
		$output[] .= 'Amount of Clients: ' . count($this->customers);
		$output[] .= 'Amount of Salesmen: ' . count($this->salesmen);
		$output[] .= 'ID of most expensive Sale: ' . $this->mostExpensiveSale->getId();
		$output[] .= 'Worst salesman ever: ' . $this->worstSalesmanEver;
		
		if ($mode == 'file') {
			$output = implode("\n", $output);
			file_put_contents($this->filename, $output);
		}

		/* These ones are for testing only */ 
		if ($mode == 'console') {
			print_r($output);
		}
		if ($mode == 'dump') {
			var_dump($output);
		}
	}

	/**
	 * A.K.A. Business magic. Checks the sales for the
	 *	most expensive one. Also validates the salesmen's sales
	 *	aggregate value to determine who's the worst (I'm guessing
	 *	this is the criteria?).  
	 */
	private function verifySales() {
		// initialize the salesmen sales array
		$salesmenSales = array();
		foreach ($this->salesmen as $salesman) {
			$salesmenSales[$salesman->getName()] = 0;
		}

		// for each sale on this report
		foreach ($this->sales as $sale) {
			$saleValue = $sale->getTotalSaleValue();

			// checks if the current sale is the most expensive; if so, it's the new mvs
			if ($this->mostExpensiveSale == null or $saleValue > $this->mostExpensiveSale->getTotalSaleValue()) {
				$this->mostExpensiveSale = $sale;
			}

			// adds the salesman's sale value to 
			$salesmanName = $sale->getSalesman();
			$salesmenSales[$salesmanName] += $saleValue;
		}

		// order in asceding order and resets array pointer
		asort($salesmenSales) and reset($salesmenSales);

		// sets the worst salesman name first record, therefore lowest sales value
		$this->worstSalesmanEver = key($salesmenSales);
	}

}