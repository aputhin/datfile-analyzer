<?php

namespace Core\Model;

/**
 * Item from a sale
 *
 * @author arthur.puthin
 * @since 04/12/2016
 */
class Item {

	private $id;
	private $quantity;
	private $price;

	public function __construct($id, $quantity, $price) {
		$this->id 		= $id;
		$this->quantity	= (int) str_replace(' ', '', $quantity);
		$this->price 	= (float) str_replace(' ', '', $price);
	}

	public function getId() {
		return $this->id;
	}

	public function getQuantity() {
		return $this->quantity;
	}

	public function getPrice() {
		return $this->price;
	}

}