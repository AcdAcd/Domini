<?php
	$date_rep = date('Y-m-d');
	$path = './webcam/rep-'.$date_rep.'/'; // dossier list� (pour lister le r�pertoir courant : $path = '.'  --> 
	$Maintenant = date('Y-m-d_H-i-s');
	// L�url du fichier
	$url = "http://root:root@192.168.0.116/axis-cgi/jpg/image.cgi?resolution=640%D7480&camera=1&compression=80";
	// On recup le nom du fichier
	$name = 'sejour_'.$Maintenant.'.jpg';
?>