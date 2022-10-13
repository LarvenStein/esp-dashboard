#!/bin/bash

echo "Dieses Toll hat eine hoche wahrscheinlichkeit, dass es NICHT funktioniert."
read -p "Dies wird alles aus dem Conatiner zurücksetzen! Ausgenommen settings.json und accsess.php. Möchtest du forfahren? (y/n) " yn

case $yn in 
	y ) echo ok, we will proceed;;
	n ) echo exiting...;
		exit;;
	* ) echo invalid response;
		exit 1;;
esac

mkdir ../temp/
cp php/src/settings.json ../temp/
cp php/src/accsess.php ../temp/
cd ../
rm -r ESP-Dashboard/

read -p "Woher möchtest du das Update beziehen? (github/gbz) " ghgbz 

case $ghgbz in 
    github ) git clone https://github.com/LarvenStein/esp-dashboard.git ESP-Dashboard/;;
    gbz ) git clone http://136.64.200.127:3000/GartenbauzentraleEG/ESP-Dashboard.git ESP-Dashboard/;;
    * ) echo "ungültige Antwort"

rm ESP-Dashboard/php/src/settings.json
rm ESP-Dashboard/php/src/accsess.php
cp temp/settings.json ESP-Dashboard/php/src/
cp temp/accsess.php ESP-Dashboard/php/src/

chmod 777 ESP-Dashboard/php/src/settings.json

echo "Fertig"