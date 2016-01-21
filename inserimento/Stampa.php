<?php session_start();
@require_once("../class.db.php");
$db = new database();
global $newformat;
if(!isset($_SESSION['loggedinas']) || empty($_SESSION['loggedinas']) || !$db->loginCheckMe($_SESSION['loggedinas'])){
	header("location: ../logout/");
	exit;
}
?>
<?php
	if(isset($_POST['insert'])){
		if(!empty($_POST['nome']) && !empty($_POST['cognome']) && !empty($_POST['cf']) && !empty($_POST['esame'])){
			$codesame = explode("[", $db->pulisciStringa($_POST['esame']));
			$codesame = explode("]", $codesame[1]);
			$nome = $db->pulisciStringa($_POST['nome']);
			$cognome = $db->pulisciStringa($_POST['cognome']);
			$cf = $db->pulisciStringa($_POST['cf']);
            $DataNascita = $_POST['DataNascita'];
            $time = strtotime($DataNascita);

           $newformat  = date('d/m/Y',$time);

			//$db->insert("nome, cognome, cf, DataNascita", "'".$nome."', '".$cognome."', '".$cf."' , '". $DataNascita . "'", "persona");
			//$db->insert("cf, codiceEsame", "'".$cf."', ".$codesame[0], "persona_esame");
			//$db->checkInserimento();
			if($db->calcolaDataEsame($cf, $codesame[0])){
				echo "<h4>- Inserimento avvenuto con Successo</h4>";
			}else{
				echo "<h4>- Inserimento non avvenuto con Successo, errore nell'inseriemento, contattare un amministratore</h4>";
			}
		}else{
			echo "<h4>- Inserimento non avvenuto con Successo, riempire tutti i campi</h4>";
		}
	}
	
	
?>
<html>
    <head>
    </head>
    <body>
        <table>
            <tr><td>Loghi</td></tr>
            <tr><td>Cognome <?php echo strtoupper($cognome); ?></td><td>Nome <?php echo strtoupper($nome); ?></td></tr>
            <tr><td>Data di nascita <?php echo $newformat; ?></td><td>C.F.: <?php echo strtoupper($cf); ?></td></tr>
            <tr><td>Sede di</td></tr>
            <tr><td>Progetto</td></tr>
            <tr><td>Data consegna:</td><td>Data presentazione esame orale</td></tr>
        </table>
        <a href="index.php">Torna all'inserimento</a>
    </body>
</html>