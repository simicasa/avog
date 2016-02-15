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
    <style type="text/css">
        table {
            width:100%;
        }
        td {
            padding:1px;
        }
        select {
            width:100%;
            padding:2px;
        }
    </style>
</head>
<body>
<?php
	$progetti = $db->getProgetti();
	$nprogetti = count($progetti);
?>
    <div id="wrapper">
        <?php @require('../sidebar.php');?>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle" style="margin-bottom:20px;">Nascondi Menu</a>
                        <h1>Gestione Stampe</h1>
                        
						<form class="form col-md-12 center-block" action="visualizza.php" method="post">
							<div class="form-group">
                                <h3>Selezione Data</h3>
                                <table><tr>
                                    <td>
                                        <select name="giorno">
                                            <?php
                                                for($i=1;$i<=31;$i++){
                                                    $giorno = strlen($i)==1?'0'.$i:$i;
                                                    echo "<option value='{$giorno}'";
                                                    if(date('d')==$i){echo " selected";}
                                                    echo ">{$giorno}</option>";
                                                }
                                            ?>
                                        </select>
                                    </td><td>
                                        <select name="mese">
                                            <?php
                                                for($i=1;$i<=12;$i++){
                                                    $mese = strlen($i)==1?'0'.$i:$i;
                                                    echo "<option value='{$mese}'";
                                                    if(date('m')==$i){echo " selected";}
                                                    echo ">{$mese}</option>";
                                                }
                                            ?>
                                        </select>
                                    </td><td>
                                        <select name="anno">
                                            <?php
                                                for($i=date('Y');$i>(date('Y')-10);$i--){
                                                    echo "<option value='{$i}'>{$i}</option>";
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr></table>
							</div>
							<div class="form-group">
                                <h3>Selezione Progetto</h3>
                                <select name="progetto" type="text" class="form-control input-lg">
                                    <?php
                                        for($i=0;$i<$nprogetti;$i++){
                                            echo "<option value='{$progetti[$i]['codice']}'>[{$progetti[$i]['codice']}] {$progetti[$i]['nome']}</option>";
                                        }
                                    ?>
                                </select>
							</div>
                            <button class="btn btn-primary btn-lg btn-block" style="margin-top:20px;">Visualizza</button>
						</form>
                    </div>
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