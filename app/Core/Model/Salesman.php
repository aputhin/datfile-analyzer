<?php

namespace Core\Model;

/**
 * Salesman data
 *
 * @author arthur.puthin
 * @since 04/12/2016
 */
class Salesman {

	private $cpf;
	private $name;
	private $salary;

	public function __construct($cpf, $name, $salary) {
		$this->cpf 		= $cpf;
		$this->name 	= $name;
		$this->salary 	= (float) str_replace(' ', '', $salary);
	}

	public function getCpf() {
		return $this->cpf;
	}

	public function getName() {
		return $this->name;
	}

	public function getSalary() {
		return $this->salary;
	}

}