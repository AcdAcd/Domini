#!/bin/bash
#lancement des page PHP qui vont generer les graphs
cd /var/www/domini/php/highstock/

# GRAPHIQUE HIGHSTOCK
# G�n�re le CSV avec les info t�l�info annuelle
wget 0.0.0.0:80/php/highstock/csv_teleinfo_an.php
wget 0.0.0.0:80/php/highstock/csv_pellet_conso.php

#suppression des fichiers temporaire crees
rm /var/www/domini/php/highstock/csv_teleinfo_an.php.*
rm /var/www/domini/php/highstock/csv_pellet_conso.php.*


