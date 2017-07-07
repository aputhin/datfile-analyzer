<?php

namespace Core\Model;

/**
 * Customer data
 *
 * @author arthur.puthin
 * @since 04/12/2016
 */
class Customer {

	private $cnpj;
	private $name;
	private $businessArea;

	public function __construct($cnpj, $name, $businessArea) {
		$this->cnpj 		= $cnpj;
		$this->name 		= $name;
		$this->businessArea	= $businessArea;
	}

}