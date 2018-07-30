<?php

namespace edit\jnbt;

class IntArrayTag extends Tag{

	private $value;

	public function __construct(array $value){
		parent::__construct();
		$this->value = $value;
	}

	public function getValue(){
		return $this->value;
	}

}