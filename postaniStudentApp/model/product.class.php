<?php

class Product
{
	public $product_id,$name,$description,$seller_id,$sold,$score,$price;

	function __construct($product_id,$seller_id,$name,$description,$price,$sold=NULL,$score=NULL)
	{
		


		$this->product_id = $product_id;
		$this->name = $name;
		$this->description = $description;
        $this->seller_id = $seller_id;
        $this->sold = $sold;
        $this->score = $score;
        $this->price = $price;

	}

	function getColor()
	{
		
	}
	function setCSS($newClass){
		$this->cssEnums .= $newClass . " ";
	}


	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>