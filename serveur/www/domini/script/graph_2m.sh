#!/bin/bash
cd /var/www/domini/php/
# charge les donn�es temps r�elles dans une table temporaire -> permet d'acc�lerer l'affichage de la page d'accueil de l'interface domotiqut
wget 0.0.0.0:80/php/instant_data.php

#suppression des fichiers temporaire crees
rm -f /var/www/domini/php/instant_data.php.*


