<?php

namespace Core\Controller;

use Core\Model\{Report, Salesman, Customer, Sale, attr};

class SaleControl {

	/* Business constants */
	const ATTR_SEPARATOR 		= 'ç';
	const SALESMAN_FORMAT_ID 	= '001';
	const CUSTOMER_FORMAT_ID 	= '002';
	const SALE_FORMAT_ID 		= '003';
	const SLEEP_TIME			= 5;


	/**
	 * Instantiates the report, parse all .dat files 
	 *	and prints the output. Repeats itself every
	 *	SLEEP_TIME sections, and only generates the report
	 * 	if it doesn't have already been generated for that file.
	 *
	 * @param $mode The output mode to be used to print the report; 
	 *	default: 'file' exports to a .out.dat file.
	 *
	 */
	public function generateReport(string $mode = 'file') {
		while(true) {
			foreach (glob(INPUT_PATH.INPUT_FORMAT) as $filename) {
				$outputFileName = OUTPUT_PATH . basename($filename, '.dat') . OUTPUT_FORMAT;
				if (!file_exists($outputFileName)) {
					$report = new Report($outputFileName);
					$this->parseDat($filename, $report);
					$report->print($mode);
				}
			}

			sleep(self::SLEEP_TIME);
		}
	}

	/**
	 * Parses each .dat file and puts its' contents on
	 *	the reports arrays for each type of data storage
	 *
	 * @param $path Path to the file
	 * @param &$report The report to store the data
	 *
	 */
	private function parseDat($path, &$report) {
		$file = file($path);

		foreach ($file as $line) {
			$attr = explode(self::ATTR_SEPARATOR, trim($line));

			switch ($attr[0]) {
				case self::SALESMAN_FORMAT_ID: 
					$report->salesmen[] = new Salesman($attr[1], $attr[2], $attr[3]);
					break;
				case self::CUSTOMER_FORMAT_ID: 
					$report->customers[] = new Customer($attr[1], $attr[2], $attr[3]);
					break;
				 case self::SALE_FORMAT_ID: 
					$report->sales[] = new Sale($attr[1], $attr[2], $attr[3]);
					break;
				default: break;
			}
		}
	}


}
