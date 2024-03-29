<?php // content="text/plain; charset=utf-8"
	include("../../infos/config.inc.php"); // on inclu le fichier de config
	include("../../infos/tarifedf.inc.php"); // on inclu le fichier avec les tarifs edf
	$filename = "../../csv/teleinfo_an.csv";

	//on pr�pare l'entete du fichier CSV
	$fp = fopen($filename, "w");
	$line = "DATE;heure;consoHP;consoHC\n";
	fputs($fp, $line);
	
	// requete MySQL pour obtenir les donn�es de la BDD
	//echo" $host, $login, $passe, $bdd \n";
	
	@mysql_connect($host,$login,$passe) or die("Impossible de se connecter � la base de donn�es");
	@mysql_select_db("$bdd") or die("Impossible de se connecter � la base de donn�es");
	$SQL="SET lc_time_names = 'fr_FR'" ; // Pour afficher date en fran�ais dans MySql. 
	mysql_query($SQL) ;
	//on r�cup�re l'ann�e en cours
	$annee = date('Y');
	$n=0;


	 for($i=2010 ; $i<=$annee ; $i++){
		//echo" annee : $annee, n: $n<br>";
		// requete MySQL pour obtenir les HP et HC du d�but d'ann�e (ou d�but de relev� de l'ann�e)
		$SQL="SELECT DATE_FORMAT(date_time, '%d-%m-%Y') AS DATE,HC,HP
				FROM  `teleinfo`
				WHERE  YEAR(date_time) = $i
				ORDER BY date_time
				LIMIT 0,1";
		// echo "<br>requete SQL : $SQL";
		$RESULT = @mysql_query($SQL);
		// echo "<br>resultat : $RESULT";

		//on ne prend que le premier �lement de la table HC et HP
		if($myrow=@mysql_fetch_array($RESULT)){

			$data_date[$n] = $myrow["DATE"];
			$data_HC_deb[0] = $myrow["HC"] / 1000; // on divise par mille pour avoir des kWh
			$data_HP_deb[0] = $myrow["HP"] / 1000; // on divise par mille pour avoir des kWh
			// echo "<br>data_date : $data_date[0]   <br> data_HC_deb : $data_HC_deb[0]     data_HP_deb : $data_HP_deb[0] <br>";

			// requete MySQL pour obtenir les HP et HC de la fin d'ann�e
			$SQL="SELECT YEAR(date_time) AS Annee,HC,HP
					FROM  `teleinfo`
					WHERE  YEAR(date_time) = $i
					ORDER BY date_time DESC
					LIMIT 0,1";
			// echo "<br>requete SQL : $SQL";
			$RESULT = @mysql_query($SQL);
			// echo "<br>resultat : $RESULT";

			//on lit la seconde ligne avec les HP+HC de fin d'ann�e
			if($myrow=@mysql_fetch_array($RESULT)){
				$data_HC_fin[0] = $myrow["HC"] / 1000; // on divise par mille pour avoir des kWh
				$data_HP_fin[0] = $myrow["HP"] / 1000; // on divise par mille pour avoir des kWh
				// echo "<br>data_HC_fin : $data_HC_fin[0]     data_HP_fin : $data_HP_fin[0] <br>";

				// On calcul la conso mensuelle
				$data_consoanneeHC[$n] = $data_HC_fin[0] - $data_HC_deb[0] ;
				$data_consoanneeHP[$n] = $data_HP_fin[0] - $data_HP_deb[0] ;
				
				//on �crit les donn�es dans le fichier CSV		
				$line = $data_date[$n] .";00:00:01;". $data_consoanneeHP[$n] .";". $data_consoanneeHC[$n]."\n"; 
				fputs($fp, $line);
			}

			$n++;
		}
	 }

	echo"CSV teleinfo_an export�.<br>";
	mysql_free_result($RESULT) ;
	mysql_close();

?>