<?php 

function isNumber($n){
	return preg_match('/^[0-9]+$/', $n);
}

// Provjeri je li postavljena varijabla rt; kopiraj ju u $route
if( isset( $_GET['rt'] ) )
	$route = $_GET['rt'];
else
	$route = 'index';

// Ako je $route == 'con/act', onda rastavi na $controllerName='con', $action='act'
$parts = explode( '/', $route );





// Controller $controllerName se nalazi poddirektoriju controller
$controllerName = $parts[0] . 'Controller';
$controllerFileName = 'controller/' . $controllerName . '.php';

// Includeaj tu datoteku
if( !file_exists( $controllerFileName ) )
{
	$controllerName = 'startController';
	$controllerFileName = 'controller/' . $controllerName . '.php';
}

require_once $controllerFileName;

// Stvori pripadni kontroler
$con = new $controllerName;


switch(count($parts)){
	case 0:
	case 1:
		$action = 'index';

		$con->$action();
		break;
	case 2:
		$action = $parts[1];

		if( !method_exists( $con, $action ) ){
			$action = 'index';
			$con->$action();
		}

		$con->$action();
		break;
	case 3:
		$action = $parts[1];
		$number = $parts[2];

		if( !method_exists( $con, $action ) ){
			$action = 'index';
			$con->$action();
		}
		else{
			$con->$action((string)$number);
		}
		break;
}


?>
