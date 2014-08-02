<?php 
	include("../../infos/config.inc.php"); // on inclu le fichier de config
	include("../../infos/pyrano.inc.php"); // on inclu le fichier pour avoir les variables/constantes du pyranom�tre

	$filename = "../../csv/pyrano_mensuel.csv";

	//on r�cup�re l'ann�e en cours
	$annee = date('Y');
	//on r�cup�re le mois en cours (0-12)
	$mois = date('m');
	$n=0;
	
	$line = "";
	$comma = "";
	$fp = fopen($filename, "w");
	
	@mysql_connect($host,$login,$passe) or die("Impossible de se connecter � la base de donn�es");
	@mysql_select_db("$bdd") or die("Impossible de se connecter � la base de donn�es");
	
	for($i = 2011; $i <= $annee ; $i++){
		//requete pour r�cup�rer l'int�grale du flux solaire par mois et pour chaque ann�e
		$SQL="SELECT sum( `ana1` ) 
				FROM `pyranometre` 
				WHERE year( `date_time` ) = $i
				GROUP BY month( `date_time` ) 
				ORDER BY month( `date_time` ) ASC
				LIMIT 0 , 30"; 
		
		// on execute la requete
		$RESULT = @mysql_query($SQL);	
		$line = "$i;";
		while($row = mysql_fetch_assoc($RESULT)) {
			
			foreach($row as $value) {
				$line .= $comma .  str_replace('"', '""', $value) ;
				$comma = ";";
			}			
		}
		$line .= "\n";
		fputs($fp, $line);
		echo "$line </br>";
		$line = "";
		$comma = "";
	}

	//fermeture du fichier
	fclose($fp);
	// on lib�re la m�moire
	mysql_free_result($RESULT) ;
	// on ferme la connexion � mysql
	mysql_close();	 
	 
echo"CSV pyranom�tre mensuel export�.<br>";

?>