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
			$codesame = $db->pulisciStringa($_POST['esame']);
			$nome = $db->pulisciStringa($_POST['nome']);
			$cognome = $db->pulisciStringa($_POST['cognome']);
			$cf = $db->pulisciStringa($_POST['cf']);
			if(!($db->checkPersona($cf, true))){
				$db->insert("nome, cognome, cf, dataNascita", "'".$nome."', '".$cognome."', '".$cf."' , STR_TO_DATE('".$db->pulisciStringa($_POST['DataNascita'])."', '%d/%m/%Y')", "persona");
				$persona = $db->getPersonaIdFromCf($cf);
				$personaid = $persona['id'];
				$db->insert("cf, personaID, codiceEsame, dataConsegna", "'".$cf."', ".$personaid.", ".$codesame.", STR_TO_DATE(DATE(NOW()), '%Y-%m-%d')", "persona_esame");
				//$db->checkInserimento();
				if($db->calcolaDataEsame($cf, $codesame)){
					echo "<h4>- Inserimento avvenuto con Successo</h4>";
				}else{
					echo "<h4>- Inserimento non avvenuto con Successo, errore nell'inseriemento, contattare un amministratore</h4>";
				}
			}else{
					echo "<h4>- La pagina e' stata aggiornata, nessun inserimento avvenuto</h4>";
			}
		}else{
			echo "<h4>- Inserimento non avvenuto con Successo, riempire tutti i campi</h4>";
		}
	}
	
	$persona = $db->getPersonaIdFromCf($cf);
	$personaid = $persona['id'];
	$esami = $db->getEsamePersonaByID($codesame, $personaid);
	$opzioni = $db->getOpzioni();
	if(intval($esami['semattina'])==1){$orario=$opzioni[0]['orarioMattina'];}
	else{$orario=$opzioni[0]['orarioPomeriggio'];}
	$esami['tedatainizio']=str_replace("-", "/", $esami['tedatainizio']);
	$esami['tpedataconsegna']=str_replace("-", "/", $esami['tpedataconsegna']);
	$esami['tedatainizio']=strtotime($esami['tedatainizio']);
	$esami['tpedataconsegna']=strtotime($esami['tpedataconsegna']);
?>
<html>
    <head>
        <style>
        @page{size: 210mm 297mm; margin: 30mm;}
        </style>
        <link rel="stylesheet" type="text/css" href="print.css" media="print">
    </head>
    <body>
        <table style="width:100%;">
            <tr><td>Loghi</td></tr>
            <tr><td>Protocollo <?php echo $esami['protocollo']; ?></td></tr>
            <tr><td>Cognome <?php echo strtoupper($cognome); ?></td><td>Nome <?php echo strtoupper($nome); ?></td></tr>
            <tr><td>Data di nascita <?php echo $db->pulisciStringa($_POST['DataNascita']); ?></td><td>C.F.: <?php echo strtoupper($cf); ?></td></tr>
            <tr><td>Sede di <?php echo $esami['tsnome']." [".$esami['tscodice']."]"; ?></td></tr>
            <tr><td>Progetto <?php echo $esami['tpnome']." [".$esami['tpcodice']."]"; ?></td></tr>
            <tr><td>Data consegna: <?php echo date("d/m/Y",$esami['tpedataconsegna']); ?></td><td>Data presentazione esame orale: <?php echo date("d/m/Y",$esami['tedatainizio']); ?> ore <?php echo $orario; ?></td></tr>
        </table>
        <a class=".invisibile" href="index.php">Torna all'inserimento</a>
    </body>
</html>