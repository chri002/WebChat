<?php
	/*ACTION  : in scrittura (w) o in lettura ( un numero per indicare l'indice), rst reset
	* ACCOUNT : il nome utente
	* INDEX   : indice nel caso di ACTION==r
	* MESSAGGIO : il messaggio da inviare
	*/ 

	$db 	= null;
	$data 	= date("Y-M-d")."\n";
	//print_r($_POST);
	
	
	
	$db  = fopen("msg.txt", "r");
	$prova = fgets($db);
	fclose($db);
	
	if(($data!=$prova)){
		$db  = fopen("msg.txt", "w");
		fwrite($db, $data);
		fclose($db);
		
	}
	
	if($_POST["ACTION"] == "w"){
		if(isset($_POST["ACCOUNT"])&&!empty($_POST["ACCOUNT"])&&isset($_POST["MESSAGGIO"])&&!empty($_POST["MESSAGGIO"])){
			$db  = fopen("msg.txt", "a");
			
			$msg = $_POST["ACCOUNT"].":".$_POST["MESSAGGIO"]."\n";
			
			fwrite($db, $msg);
			echo json_encode(array("ok","1"));
		}
	}else if($_POST["ACTION"]=="r"){
		$db  = fopen("msg.txt", "r");
		$msg = "";
		$idM = is_numeric($_POST["INDEX"])? intval($_POST["INDEX"]):1;
		$i   = 0;
		$outMs = "[";
		while(!feof($db)) {
			$tempT = fgets($db);
			if($i>=$idM){
				$msg = explode(":", $tempT);
				$msg = str_replace("\n","",$msg);
				if(isset($msg[1])){
					$outMs .= "[\"".$msg[0]."\",\"".$msg[1]."\"],";
				}
			}else{
				$msg = $tempT;
			}
			$i++;
		}
		$outMs.="[\"ok\",\"".$i."\"]]";
		echo $outMs;
	}else if($_POST["ACTION"]=="rst"){
		$db  = fopen("msg.txt", "w");
		fwrite($db, $data);
		echo json_encode(array("ok","2"));
	}else{		
		echo "['ERROR']";
	}
	
	
	fclose($db);
?>

