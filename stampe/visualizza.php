<?php session_start();
@require_once("../class.db.php");
$db = new database();
if(!isset($_SESSION['loggedinas']) || empty($_SESSION['loggedinas']) || !$db->loginCheckMe($_SESSION['loggedinas'])){
	header("location: ../logout/");
	exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>lavoro1</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{
            margin:10px;
        }
    </style>
</head>
<body>
<?php
    $giorno = $_POST['giorno'];
    $mese = $_POST['mese'];
    $anno = $_POST['anno'];
    $projectID = $_POST['progetto'];
	$prenotazioni = $db->getPrenotazioniDate($giorno, $mese, $anno, $projectID);
	$nprenotazioni = count($prenotazioni);
    $progetto = $db->getProgetto($projectID);

    $codiceSede = 0;
    $start = 0;
?>
    <h1>Prenotazioni <?php echo "{$giorno}/{$mese}/{$anno}"; ?></h1>
    <h2 style="padding:20px 0px;"><?php echo $progetto[0]['nome'];?></h2>
    
<?php
        for($j=0; $j<$nprenotazioni; $j++) {
            $table = false;
            if($codiceSede!=$prenotazioni[$j]['tscodice']){
                echo "<h3>".$prenotazioni[$j]['tsnome']."</h3>";
                $codiceSede=$prenotazioni[$j]['tscodice'];
                $table = true;
?>
    <table style="width:100%;">
        <tr>
        <td width="10%">Protocollo</td>
        <td width="30%">Codice Fiscale</td>
        <td width="15%">Nome</td>
        <td width="15%">Cognome</td>
        <td width="30%">Firma</td>
        </tr>
<?php
            }
            for($i=$start;$i<$nprenotazioni;$i++){
                if($codiceSede==$prenotazioni[$i]['tscodice']){
                    echo "<tr><td>";
                    echo $prenotazioni[$i]['protocollo'];
                    echo "</td><td>";
                    echo $prenotazioni[$i]['cf'];
                    echo "</td><td>";
                    echo $prenotazioni[$i]['nome'];
                    echo "</td><td>";
                    echo $prenotazioni[$i]['cognome'];
                    echo "</td><td>";
                    echo "&nbsp;";
                    echo "</td></tr>";
                }
                /*else{
                    $start = $i;
                }
                */
            }
            if($table){
?>
    </table>
<?php
            }
        }
?>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>