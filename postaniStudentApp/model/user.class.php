<?php

class User
{
	public $user_id, $name,$hashPass,$email ,$score, $creation_date, $description,$phone ,$points;

    function __construct(  $user_id, $name,$email,$hashPass, $score, $creation_date, $description,$phone ,$points )
	{
		$this->user_id = $user_id;
		$this->name = $name;
		$this->email = $email;
		$this->hashPass = $hashPass;
		$this->score = $score;
		$this->creation_date = $creation_date;
		$this->description = $description;
		$this->phone = $phone;
        $this->points = $points;

	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>

