<?php

class Transaction
{
	public $id,$id_product ,$id_user, $rating, $comment;

	function __construct( $id,$id_product ,$id_user, $rating, $comment)
	{
		$this->id = $id;
		$this->id_product = $id_product;
		$this->id_user = $id_user;
		$this->rating = $rating;
		$this->comment = $comment;

	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
