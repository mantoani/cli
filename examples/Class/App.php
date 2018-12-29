<?
	
require_once(__DIR__."/../../vendor/autoload.php");

class App{
	
	// use Cli\Cli;	

	function __construct(){

	}

	function cli($argv){
		$Cli = new Cli\Cli(__NAMESPACE__, $argv);
	}

	function olele($a=null, $b=null, $c=null){
		echo "olele \n";
		echo "$a \n";
		echo "$b \n";
		echo "$c \n";
	}

	function olala(){
		echo "olalá \n";
	}
}

?>