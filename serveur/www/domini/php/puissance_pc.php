<?php 
// requete MySQL pour obtenir les donn�es de la BDD
//echo" $host, $login, $passe, $bdd \n";
@mysql_connect($host,$login,$passe) or die("Impossible de se connecter � la base de donn�es");
@mysql_select_db("$bdd") or die("Impossible de se connecter � la base de donn�es");

// ------------------- R�cup�re puissance pc actuelle -------------------------------------
//Requete pour d�terminer la valeur moyenne sur les derni�res 20 minutes
$SQL="SELECT date_time, puissance
FROM puissance_pc
WHERE date_time >= SUBTIME( NOW( ) ,  '00:15:00' ) 
LIMIT 0,1						
"; 
// //Envoie de la requete
$RESULT = @mysql_query($SQL);
// lecture du resultat de la requete
$myrow=@mysql_fetch_array($RESULT); 
//on r�cup�re la derni�re temp�rature relev�e
$puissance_pc = $myrow["puissance"];

//on quitte la BDD
mysql_free_result($RESULT);
mysql_close();
?>