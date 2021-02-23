<?php
	/*C  : azione 1 per registrarsi, 0 per accedere
	* ACCOUNT : il nome utente
	* INDEX   : indice nel caso di ACTION==r
	* MESSAGGIO : il messaggio da inviare
	*/ 
	
	$connectionJS = "connessione.js";
		
	$db 	= null;
	$password = "alpqmzonksxwruhfbvowsxknvgt";
	
	
	$db  = fopen("account.txt", "a");
	fclose($db);
	
	if(isset($_POST["U"]) && isset($_POST["A"])){
		if($_POST["C"]==1){
			$db  = fopen("account.txt", "r");
			while(!feof($db)) {
				$tempT = fgets($db);
				$msg = str_replace("\n","",$tempT);
				$msg = explode(":", $msg);
				if(strcmp($msg[0],$_POST["U"])==0){
					echo json_encode(array("ok","-1",""));
					fclose($db);
					return 0;
				}
			}
			fclose($db);
			$db  = fopen("account.txt", "a");
			$msg = $_POST["U"].":".$_POST["A"]."\n";
			
			fwrite($db, $msg);
			echo json_encode(array("ok","1",$password,$connectionJS));
			
		}else{
			$db  = fopen("account.txt", "r");
			while(!feof($db)) {
				$tempT = fgets($db);
				$msg = str_replace("\n","",$tempT);
				$msg = explode(":", $msg);
				if(strcmp($msg[0],$_POST["U"])==0 && strcmp($msg[1],$_POST["A"])==0){
					echo json_encode(array("ok","1",$password,$connectionJS));
					fclose($db);
					return 0;
				}
			}
			echo json_encode(array("ok","-1"));
		}
		fclose($db);
	}else{
		
		echo "['ERROR']";
	}
	
	
?>

