<?php

namespace Core\Model;

/**
 * Sale data
 *
 * @author arthur.puthin
 * @since 04/12/2016
 */
class Sale {

	// list of invalid chars commonly found on item parsing
	const INVALID_CHARS = array('[',']',' ');

	private $id;
	private $itemList;
	private $salesman;

	public function __construct($id, $itemString, $salesman) {
		$this->id 		= $id;
		$this->salesman	= $salesman;
		$this->itemList = array();
		$this->parseItens($itemString);
	}

	/**
	 * Calculates and returns the total value of the sale
	 *	by parsing its' itens
	 *
	 * @param $itemString The string with the itens to be parsed
	 * @param $itemSeparator The char that separates each item; default: ','
	 * @param $attrSeparator The char that separates each attribute; default: '-'
	 */
	private function parseItens($itemString, $itemSeparator = ',', $attrSeparator = '-') {
		$parsedList = explode($itemSeparator, str_replace(self::INVALID_CHARS, '', $itemString));

		foreach ($parsedList as $unparsedItem) {
			$attributes 		= explode($attrSeparator, $unparsedItem);
			$parsedItem 		= new Item($attributes[0], $attributes[1], $attributes[2]);
			$this->itemList[] 	= $parsedItem;
		}
	}

	public function getId() {
		return $this->id;
	}

	public function getSalesman() {
		return $this->salesman;
	}

	public function getItemList() {
		return $this->itemList;
	}

	/**
	 * Calculates and returns the total value of the sale
	 *	by parsing its' itens
	 *
	 * @return int Total value of the sale
	 */
	public function getTotalSaleValue() {
		$totalValue = 0;

		foreach ($this->itemList as $item) {
			$totalValue += $item->getPrice() * $item->getQuantity();
		}

		return $totalValue;
	}

}