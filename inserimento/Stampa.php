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
			if(!($db->checkPersona($cf, true))){
				$db->insert("nome, cognome, cf, dataNascita", "'".$nome."', '".$cognome."', '".$cf."' , STR_TO_DATE('".$db->pulisciStringa($_POST['DataNascita'])."', '%d/%m/%Y')", "persona");
				$persona = $db->getPersonaIdFromCf($cf);
				$personaid = $persona['id'];
				$db->insert("cf, personaID, codiceEsame, dataConsegna", "'".$cf."', ".$personaid.", ".$codesame[0].", DATE(NOW())", "persona_esame");
				//$db->checkInserimento();
				if($db->calcolaDataEsame($cf, $codesame[0])){
					echo "<h4 class='invisibile''>- Inserimento avvenuto con Successo</h4>";
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
	$esami = $db->getEsamePersonaByID($codesame[0], $personaid);
	$opzioni = $db->getOpzioni();
	if(intval($esami['semattina'])==1){$orario=$opzioni[0]['orarioMattina'];}
	else{$orario=$opzioni[0]['orarioPomeriggio'];}
	//$esami['dataInizio']=str_replace("-", "/", $esami['dataInizio']);
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="print.css">
    </head>
    <body>
        <table class="once" width="100%">
              <tr><td><img src='../stemmi/logo_ue1.png'></td>
                <td><img src='../stemmi/politiche%20sociali.jpg'></td>
                <td><img src='../stemmi/ministi%20e%20gioventu.jpg'></td>
            </tr>
            <tr>
                <td><img src='../stemmi/logo%20garanzia%20giovani_2_74x74.jpg'></td>
                <td></td>
                <td><img src='../stemmi/servizio%20civile.jpg'></td>
            </tr>
            <tr>
                <td>Protocollo N&#42;: <?php echo $_POST['protocollo']; ?></td><td></td><td></td>
            </tr>
        </table>
        <table class="tizzio" width="100%">
            <tr><td>Cognome <?php echo strtoupper($cognome); ?></td><td>Nome <?php echo strtoupper($nome); ?></td></tr>
            <tr><td>Data di nascita <?php echo date("d/m/Y",strtotime($db->pulisciStringa($_POST['DataNascita']))); ?></td><td>C.F.: <?php echo strtoupper($cf); ?></td></tr>
        </table>
        <table class="progetto" width="100%">
            <tr><td>Sede di <?php echo $esami['tscodice']. " " . $esami['tsnome']; ?></td></tr>
            <tr><td>Progetto <?php echo $esami['tpnome']; ?></td></tr>
            <tr><td>Data consegna: <?php echo date("d/m/Y",strtotime($esami['tpedataconsegna'])); ?></td><td>Data presentazione esame orale: <?php echo date("d/m/Y",strtotime($esami['tedatainizio'])); ?> <?php echo $orario; ?></td></tr>
        </table>
        <div class='last'>
            <p>Sede d'esame: Via Luigi Guanella N&#42; 20 - Miano - Napoli - tel: 081 2384007</p>
            <p>Tutte le informazioni sul sito www.avog.it<br>E-mail: serviziocivile@avog.it</p>
        </div>
        <a class="invisibile" href="index.php">Torna all'inserimento</a>
    </body>
</html>
