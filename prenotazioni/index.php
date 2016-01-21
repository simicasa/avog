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
    <link href="../css/simple-sidebar.css" rel="stylesheet">
    <link href="css.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper">
        <?php @require('../sidebar.php');?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
						<a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="margin-bottom:20px;">Nascondi Menu</a>
                        <h1>Gestione Prenotazioni</h1>
<?php
	$prenotazioni = $db->getPrenotazioni();
	$nprenotazioni = count($prenotazioni);
?>
                        <h3>Lista Prenotazioni</h3>
						<table style="width:100%;">
						<tr>
						<td>Codice Fiscale</td>
						<td>Codice Esame</td>
						<td>Data Esame</td>
						</tr>
						<?php
							for($i=0;$i<$nprenotazioni;$i++){
								echo "<tr><td>";
								echo $prenotazioni[$i]['cf'];
								echo "</td><td>";
								echo $prenotazioni[$i]['codiceEsame'];
								echo "</td><td>";
								echo $prenotazioni[$i]['dataEsame'];
								echo "</td></tr>";
							}
						?>
						</table>
					<!--
                        <h3>Aggiungi Progetto</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="insert" type="hidden">
							<div class="form-group">
							  <input name="codice" type="text" class="form-control input-lg" placeholder="Codice">
							</div>
							<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nome">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Aggiungi</button>
							</div>
						</form>
					</div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Modifica Progetto</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="update" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nprenotazioni;$i++){
									echo "<option>[".$prenotazioni[$i]['codice']."] ".$prenotazioni[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <input name="codice" type="text" class="form-control input-lg" placeholder="Nuovo Codice">
							</div>
							<div class="form-group">
							  <input name="nome" type="text" class="form-control input-lg" placeholder="Nuovo Nome">
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Modifica</button>
							</div>
						</form>
                    </div>
                    <div class="col-lg-12">
						<h3 style="margin-top:40px;">Elimina Progetto</h3>
						<form class="form col-md-12 center-block" action="index.php" method="post">
							<input name="delete" type="hidden">
							<div class="form-group">
							  <select name="oldone" type="text" class="form-control input-lg">
							  <?php
								for($i=0;$i<$nprenotazioni;$i++){
									echo "<option>[".$prenotazioni[$i]['codice']."] ".$prenotazioni[$i]['nome']."</option>";
								}
							  ?>
							  </select>
							</div>
							<div class="form-group">
							  <button class="btn btn-primary btn-lg btn-block">Elimina</button>
							</div>
						</form>
                    </div>
					-->
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>