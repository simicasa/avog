<?php
class database{
	/* PARAMETRI DATABASE */
	private $dbHost;
	private $dbUser;
	private $dbPwd;
	private $dbConn;
	private $dbConnAttiva = false;
	private $dbNome;
	
	/* TABELLE DATABASE */
	public $tb_sede = "sede";
	public $tb_progetto = "progetto";
	public $tb_sedeprogetto = "sede_progetto";
	public $tb_esame = "esame";
	public $tb_persona = "persona";
	public $tb_personaesame = "persona_esame";
	public $tb_opzioni = "opzioni";
	public $tb_login = "login";
	
	/* VARIABILI INTERNE */
	private $localhost = array('127.0.0.1','::1');
	
	private $lastQuery = "";
	private $lastResult;
	private $lastRow;
	
	/* COSTRUTTORE E DISTRUTTORE */
	public function __construct(){
		/*
		$this->dbHost = "62.149.150.178";
		$this->dbUser = "Sql935096";
		$this->dbPwd = "eneaz3t7nm";
		$this->dbNome = "Sql935096_1";
		*/
		$this->dbHost = "localhost";
		$this->dbUser = "angelotm";
		$this->dbPwd = "olegnatm";
		$this->dbNome = "lavoro1";
		if(!($this->connetti())){ // NON CONNESSO
			echo "<script type=\"text/javascript\">alert(\"Errore nella connessione al database, contattare un amministratore.\");</script>";
		}
	}
	public function __destruct(){
		$this->disconnetti();
	}
	
	/* CONNESSIONE E DISCONNESSIONE */
	public function connetti(){
		if(!($this->isConnesso())){
			$this->dbConn = @mysql_connect($this->dbHost,$this->dbUser,$this->dbPwd);
			if($this->dbConn){
				$this->dbConnAttiva = true;
				if(mysql_select_db($this->dbNome)){return true;}
			}
		}
		return false;
	}
	public function isConnesso(){return $this->dbConnAttiva;}
	public function disconnetti(){
		if($this->isConnesso()){
			if(mysql_close()){
				$this->dbConnAttiva = false;
				return true;
			}
		return false;
		}
	}
	
	/* QUERY */
	public function executeQuery($query){return ($this->lastResult = mysql_query($query));}
	public function executeQueryStored(){return ($this->lastResult = mysql_query($this->lastQuery));}
	
	public function update($cosa, $come, $dove, $quando){
		$this->executeQuery("UPDATE ".$dove." SET ".$cosa."=".$come." WHERE ".$quando);
		//echo "UPDATE ".$dove." SET ".$cosa."=".$come." WHERE ".$quando;
	}
	public function insert($dove, $valori, $tabella){
		$this->executeQuery("INSERT INTO ".$tabella." (".$dove.") VALUES (".$valori.")");
		//echo "INSERT INTO ".$tabella." (".$dove.") VALUES (".$valori.")";
	}
	public function delete($tabella, $quando){
		$this->executeQuery("DELETE FROM ".$tabella." WHERE (".$quando.")");
		//echo "DELETE FROM ".$tabella." WHERE (".$quando.")";
	}
	
	/* FETCH */
	public function fetchRow($result){return ($this->lastRow = mysql_fetch_row($result));}
	public function fetchRowStored(){return ($this->lastRow = mysql_fetch_row($this->lastResult));}
	public function fetchAssoc($result){return ($this->lastRow = mysql_fetch_assoc($result));}
	public function fetchAssocStored(){return ($this->lastRow = mysql_fetch_assoc($this->lastResult));}
	
	/* CONTEGGIO NUMERO RIGHE */
	public function getNumRows($result){return (mysql_num_rows($result));}
	public function getNumRowsStored(){return (mysql_num_rows($this->lastResult));}
	public function getNumFields($result){return (mysql_num_fields($result));}
	public function getNumFieldsStored(){return (mysql_num_fields($this->lastResult));}
	
	/* GET FROM DATABASE */
	private $orderby = "ORDER BY nome ASC, codice ASC";
	public function getGeneric($query){
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			for($i=0;$i<$rows;$i++){
				$persone[$i] = $this->fetchAssocStored();
			}
			if(!empty($persone)){
				return ($persone);
			}
		}
		return $persone=array();
	}
	public function getProject($residential, $collaboration, $competition){
		return $this->getGeneric("SELECT * FROM {$this->tb_project} WHERE residential={$residential} AND collaboration={$collaboration} AND competition={$competition} ".$this->orderby);
	}
	public function getSedi(){
		return $this->getGeneric("SELECT * FROM {$this->tb_sede} ".$this->orderby);
	}
	public function getProgetti(){
		return $this->getGeneric("SELECT * FROM {$this->tb_progetto} ".$this->orderby);
	}
	public function getSediProgetti(){
		return $this->getGeneric("SELECT * FROM {$this->tb_sedeprogetto}");
	}
	public function getEsami(){
		return $this->getGeneric("SELECT te.codice AS codice, te.codiceSede AS codiceSede, te.codiceProgetto AS codiceProgetto, te.dataInizio AS dataInizio, te.limitePartecipanti AS limitePartecipanti, ts.nome AS sedeNome, tp.nome AS progettoNome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice ORDER BY tp.codice ASC");
	}
	public function getEsame($id){
		$query = "SELECT te.dataInizio AS tedatainizio, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice WHERE te.codice={$id}";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getEsamePersona($id, $cf){
		$query = "SELECT tpe.seMattina AS semattina, tpe.dataConsegna AS tpedataconsegna, te.dataInizio AS tedatainizio, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe ON te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice AND tpe.cf='{$cf}' AND tpe.codiceEsame={$id} WHERE te.codice={$id}";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getEsamePersonaByID($id, $idPersona){
		$query = "SELECT tpe.protocollo AS protocollo, tpe.seMattina AS semattina, tpe.dataConsegna AS tpedataconsegna, te.dataInizio AS tedatainizio, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome, tpe.dataEsame AS dataEsame FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe JOIN {$this->tb_persona} tpp ON tpe.cf=tpp.cf AND te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice AND tpe.codiceEsame={$id} WHERE te.codice={$id} AND tpp.id={$idPersona}";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getPersonaIdFromCf($cf){
		$query = "SELECT * FROM {$this->tb_persona} WHERE cf='{$cf}'";
		$this->executeQuery($query);
		return $this->fetchAssocStored();
	}
	public function getPersone(){
		return $this->getGeneric("SELECT * FROM {$this->tb_persona}");
	}
	public function getPersoneEsami(){
		return $this->getGeneric("SELECT * FROM {$this->tb_personaesame}");
	}
	public function getOpzioni(){
		return $this->getGeneric("SELECT * FROM {$this->tb_opzioni}");
	}
	public function getPrenotazioni(){
		$query = "SELECT tpp.cf AS cf, tpp.nome AS nome, tpp.cognome AS cognome, tpe.seMattina AS semattina, tpe.dataConsegna AS tpedataconsegna, tpe.dataEsame AS dataEsame, tp.codice AS tpcodice, tp.nome AS tpnome, ts.codice AS tscodice, ts.nome AS tsnome FROM {$this->tb_esame} te JOIN {$this->tb_sede} ts JOIN {$this->tb_progetto} tp JOIN {$this->tb_personaesame} tpe JOIN {$this->tb_persona} tpp ON tpe.codiceEsame=te.codice AND tpe.personaID=tpp.id AND tpe.cf=tpp.cf AND te.codiceSede=ts.codice AND te.codiceProgetto=tp.codice";
		return $this->getGeneric($query);
	}
	
	public function checkInserimento($tabella, $quando){
		$this->executeQuery("SELECT * FROM ".$tabella." WHERE ".$quando);
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return (true);
		}
		return (false);
	}
	
	public function calcolaDataEsame($cf, $codiceEsame){
		/*
		$query = "
			SELECT COUNT(*) AS quanti, dataEsame
			FROM {$this->tb_personaesame}
			WHERE
				dataEsame IS NOT NULL
				AND dataEsame > (SELECT dataInizio FROM {$this->tb_esame} WHERE codice={$codiceEsame})
				AND dataEsame > NOW()
			GROUP BY tpe.dataEsame
			ORDER BY tpe.dataEsame DESC
			LIMIT 1
		";
		*/
		$quantiGiornalieri = $this->quantiEsaminandiGiornalieri();
		$query = "SELECT DATE_FORMAT(GREATEST((SELECT dataInizio FROM {$this->tb_esame} WHERE codice={$codiceEsame}), NOW()), '%Y-%m-%d') AS dataEsame";
		/*$query = "
			SELECT
				dataInizio
				GREATEST(
					dataInizio,
					IFNULL((SELECT GREATEST(dataEsame) FROM {$this->tb_personaesame} WHERE codiceEsame={$codiceEsame}), dataInizio)
				) AS dataPrevista
			FROM {$this->tb_esame}
			WHERE codice={$codiceEsame}
		";*/
		
		
		
		
		//$query = "SELECT GREATEST(dataInizio, IFNULL((SELECT MAX(dataEsame) FROM persona_esame WHERE codiceEsame=7), dataInizio)) AS dataPrevista FROM esame WHERE codice=7";
		$query = "SELECT GREATEST(dataInizio, IFNULL((SELECT MAX(dataEsame) FROM {$this->tb_personaesame} WHERE codiceEsame={$codiceEsame}), dataInizio)) AS dataPrevista FROM {$this->tb_esame} WHERE codice={$codiceEsame}";
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false || $rows==0){
			for($i=0;$i<$rows;$i++){
				$res[$i] = $this->fetchAssocStored();
			}
			$dataEsamePrevista = $res[0]['dataPrevista'];
			//$query = "SELECT dataEsame, COUNT(*) AS conto, CASE WHEN COUNT(*)<2 THEN 1 ELSE 0 END AS libero FROM persona_esame WHERE dataEsame>='2016-02-16' GROUP BY dataEsame ORDER BY dataEsame ASC";
			$query = "SELECT dataEsame, COUNT(*) AS conto, CASE WHEN COUNT(*)<{$quantiGiornalieri} THEN 1 ELSE 0 END AS libero FROM persona_esame WHERE dataEsame>={$dataEsamePrevista} GROUP BY dataEsame ORDER BY dataEsame ASC";
			
			$this->executeQuery($query);
			$rows = $this->getNumRowsStored();
			if($rows!=false || $rows==0){
				for($i=0;$i<$rows;$i++){
					$res[$i] = $this->fetchAssocStored();
				}
				if($rows==0){
					if($this->isWeekend(date("Y-m-d", strtotime($dataEsamePrevista . " +1 days"))))
				}else{
					$dataEsamePrevista = $res[0]['dataEsame'];
				}
			}
		}
		/*
		DATE_ADD(
			(SELECT GREATEST(dataInizio, IFNULL((SELECT MAX(dataEsame) FROM persona_esame WHERE codiceEsame=7), dataInizio)) AS dataPrevista FROM esame WHERE codice=7)
		, INTERVAL 1 DAY)
		*/
		
		
		
		
		
		
		$query = "SELECT COUNT(*) AS quanti, dataEsame FROM {$this->tb_personaesame} WHERE dataEsame IS NOT NULL AND dataEsame > (SELECT dataInizio FROM {$this->tb_esame} WHERE codice={$codiceEsame}) AND dataEsame > NOW() GROUP BY dataEsame ORDER BY dataEsame DESC LIMIT 1";
		echo $query;
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false || $rows==0){
			for($i=0;$i<$rows;$i++){
				$res[$i] = $this->fetchAssocStored();
			}
			if($rows==0){
				$query = "SELECT DATE_FORMAT(GREATEST((SELECT dataInizio FROM {$this->tb_esame} WHERE codice={$codiceEsame}), NOW()), '%Y-%m-%d') AS dataEsame";
				$this->executeQuery($query);
				$rows = $this->getNumRowsStored();
				$res[0] = $this->fetchAssocStored();
				$quanti=0;
			}else{
				$quanti = $res[0]['quanti'];
			}
			$dataEsamePrevista = $res[0]['dataEsame'];
			/*
			$arr = array(
				"quanti " => $quanti,
				"dataEsamePrevista " => $dataEsamePrevista,
				"quantiGiornalieri " => $quantiGiornalieri
			);
			print_r($arr);
			*/
			if($quanti<$quantiGiornalieri){
				//echo "dataEsame = {$dataEsamePrevista}";
				//$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL 0 DAY)";
				$intervalDays = 0;
			}else{
				if($this->isWeekend(date("Y-m-d", strtotime($dataEsamePrevista . " +1 days")))){
					//echo "dataEsame = ".date("Y-m-d", strtotime($dataEsamePrevista . " +3 days"));
					//$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL 3 DAY)";
					$intervalDays = 3;
				}else{
					//echo "dataEsame = ".date("Y-m-d", strtotime($dataEsamePrevista . " +1 days"));
					//$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL 1 DAY)";
					$intervalDays = 1;
				}
			}
			$queryCome="DATE_ADD('{$dataEsamePrevista}', INTERVAL {$intervalDays} DAY)";
			$this->update("dataEsame", $queryCome, $this->tb_personaesame, "cf='".$cf."' AND codiceEsame=".$codiceEsame);
			if($quanti<$this->quantiEsaminandiMattina()){
				$this->update("seMattina","1",$this->tb_personaesame,"cf='".$cf."' AND codiceEsame=".$codiceEsame);
			}else{
				$this->update("seMattina","0",$this->tb_personaesame,"cf='".$cf."' AND codiceEsame=".$codiceEsame);
			}
			return (true);
		}
		return (false);
		/*
		$query = "SELECT te.limitePartecipanti, te.dataInizio, COUNT(*) AS quanti, tpe.dataEsame FROM ".$this->tb_personaesame." tpe JOIN ".$this->tb_esame." te ON tpe.codiceEsame=te.codice WHERE tpe.codiceEsame=".$codiceEsame." AND dataEsame IS NOT NULL GROUP BY tpe.dataEsame ORDER BY tpe.dataEsame ASC";
		$this->executeQuery($query);
		$rows = $this->getNumRowsStored();
		if($rows!=false || $rows==0){
			for($i=0;$i<$rows;$i++){
				$giorni[$i] = $this->fetchAssocStored();
			}
			$i=0;
			$quantiGiornalieri = $this->quantiEsaminandiGiornalieri();
			if($rows==0){
				$query = "SELECT dataInizio FROM ".$this->tb_esame." WHERE codice=".$codiceEsame;
				$this->executeQuery($query);
				$esame = $this->fetchAssocStored();
				$queryCome="DATE_ADD('".$esame['dataInizio']."', INTERVAL 0 DAY)";
				$quanti=0;
			}else{
				//if($this->isWeekend($giorni[$i]['dataInizio'])){date('d/m/Y', strtotime($day . " +7 days"));}
				//if($this->isWeekend($esame['dataInizio'])){$dataInizio = date('d/m/Y', strtotime($esame['dataInizio'] . " +2 days"));}
				//else{ $dataInizio = $esame['dataInizio']; }
				//$dataInizio = date('d/m/Y', strtotime($giorni[$i]['dataInizio'] . " +2 days"));
				
				while(isset($giorni[$i]['quanti']) && $giorni[$i]['quanti']>=$quantiGiornalieri){$i++;}
				if(!isset($giorni[$i]['quanti'])){
					//var_dump(strtotime($giorni[$i]['dataInizio'] . " +{$i} days"));
					
					//strtotime()
					//date( strtotime( "2009-01-31 +1 month" ) );
					//var_dump(strtotime(now() . " +{$i} days"));
					
					//var_dump($i);
					//var_dump($giorni[$i-1]['dataInizio']);
					//var_dump(date("Y-m-d", strtotime($giorni[$i-1]['dataInizio'] . " +{$i} days")));
					//var_dump($this->isWeekend(date("Y-m-d", strtotime($giorni[$i-1]['dataInizio'] . " +{$i} days"))));
					
					if($this->isWeekend(date("Y-m-d", strtotime($giorni[$i-1]['dataInizio'] . " +{$i} days")))){$j=$i+2;}
					else{$j=$i;}
					$i--;
					$j--;
					$queryCome="DATE_ADD('".$giorni[$i]['dataInizio']."', INTERVAL ".($j+1)." DAY)";
					$quanti=0;
				}else{
					$queryCome="DATE_ADD('".$giorni[$i]['dataInizio']."', INTERVAL ".$i." DAY)";
					$quanti=$giorni[$i]['quanti'];
				}
			}
			$this->update("dataEsame", $queryCome, $this->tb_personaesame, "cf='".$cf."' AND codiceEsame=".$codiceEsame);
			//$confronto=$quantiGiornalieri/2;
			//if(($quantiGiornalieri%2)!=0){$confronto--;}
			if($quanti<$this->quantiEsaminandiMattina()){
				$this->update("seMattina","1",$this->tb_personaesame,"cf='".$cf."' AND codiceEsame=".$codiceEsame);
			}else{
				$this->update("seMattina","0",$this->tb_personaesame,"cf='".$cf."' AND codiceEsame=".$codiceEsame);
			}
			return (true);
		}
		return (false);
		*/
	}
	public function isWeekend($date){
		//$weekDay = date('w', strtotime($date));
		$weekDay = date('w', strtotime($date));
		return ($weekDay == 0 || $weekDay == 6);
	}
	public function quantiEsaminandiGiornalieri(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['esaminandiGiornalieri']);
		}
		return (0);
	}
	public function quantiEsaminandiMattina(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['postiMattina']);
		}
		return (0);
	}
	public function quantiEsaminandiPomeriggio(){
		$opzioni = $this->getOpzioni();
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			return ($opzioni[0]['postiPomeriggio']);
		}
		return (0);
	}
	
	/* INJECTION AND KEYS CONTROL */
	public function pulisciStringa($str){
		return ($str = htmlspecialchars($str, ENT_QUOTES, 'UTF-8'));
	}
	public function pulisciCaratteri($str){
		//$str = str_replace(array("&apos;", "'"), array("'", "&apos;"), $str);
		$str = str_replace(array("'","°"), array("&apos;","&#42;"), $str);
		return ($this->pulisciStringa($str));
	}
	
	/* LOGIN */
    public function loginCheckMe($username){
        $sql = "SELECT * FROM ".$this->tb_login." WHERE utente='".$username."' LIMIT 1";
        $this->executeQuery($sql);
        if($this->getNumRowsStored() == 1){return (true);}
        return (false);
    }
	
	public function addEsame($codiceProgetto, $dataInizio, $limitePartecipanti){
		$codiceProgetto = $this->pulisciCaratteri($codiceProgetto);
		$sql = "SELECT codiceSede FROM ".$this->tb_sedeprogetto." WHERE codiceProgetto='".$codiceProgetto."' AND codiceSede NOT IN (SELECT codiceSede FROM ".$this->tb_esame." WHERE codiceProgetto='".$codiceProgetto."')";
		$this->executeQuery($sql);
		$rows = $this->getNumRowsStored();
		if($rows!=false){
			for($i=0;$i<$rows;$i++){
				$esamii[$i] = $this->fetchAssocStored();
			}
			for($i=0;$i<$rows;$i++){
				$this->insert("codiceProgetto, codiceSede, dataInizio, limitePartecipanti", "'".$codiceProgetto."', '".$esamii[$i]['codiceSede']."', STR_TO_DATE('".$this->pulisciStringa($dataInizio)."', '%d/%m/%Y'), ".$this->pulisciStringa($limitePartecipanti), "esame");
			}
		}
	}
    public function checkPersona($dato, $isCFnotID){
		$sql = "SELECT * FROM {$this->tb_persona} WHERE ";
		if($isCFnotID){$sql.="cf='{$dato}'";}
		else{$sql.="id={$dato}";}
        $this->executeQuery($sql);
        if($this->getNumRowsStored() == 1){return (true);}
        return (false);
    }
    public function getEsamiProgettiSedi(){
        echo "SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp ON te.codiceProgetto=tsp.codiceProgetto ORDER BY codice ASC";
        return $this->getGeneric("SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp ON te.codiceProgetto=tsp.codiceProgetto ORDER BY codice ASC");
 }
	public function getSediProgettiNomi(){
		return $this->getGeneric("SELECT tsp.codiceProgetto AS codiceProgetto, tsp.codiceSede AS codiceSede, tp.nome AS nome FROM {$this->tb_sedeprogetto} tsp JOIN {$this->tb_progetto} tp ON tsp.codiceProgetto=tp.codice");
	}
	/*
	public function getEsamiSediProgettiNomi(){
		return $this->getGeneric("SELECT * FROM {$this->tb_esame} te JOIN {$this->tb_sedeprogetto} tsp JOIN {$this->tb_progetto} tp ON te.codiceSede=tsp.codiceSede AND te.codiceProgetto=tsp.codiceProgetto AND tsp.codiceProgetto=tp.codice");
	}
	*/
}
?>