Importer la table ephemerides :

	mysql --user=root --password=mysql domotique < 	 /~serveur/bdd/backup_domotique/ephemerides.sql
	
**ATTENTION** Les ephemerides ont �t� calcul�es pour une maison en r�gion toulousaine, si votre situation g�ographique est diff�rente, il faut modifier la table.
*(nota : ajouter lien ou m�thode de calcul)*