#!/bin/bash

read -p "Dies wird alles aus dem Conatiner Löschen! Ausgenommen settings.json und accsess.php. Möchtest du forfahren? (y/n) " yn

case $yn in 
	y ) echo ok, we will proceed;;
	n ) echo exiting...;
		exit;;
	* ) echo invalid response;
		exit 1;;
esac

read -p "füge den link zu deiner .git repository ein (mit http://): " repo
mkdir ../temp/
cp php/src/settings.json ../temp/
cp php/src/accsess.php ../temp/

cd ../
rm -r ESP-Dashboard/
git clone $repo ESP-Dashboard/
rm ESP-Dashboard/php/src/settings.json
rm ESP-Dashboard/php/src/accsess.php
cp temp/settings.json ESP-Dashboard/php/src/
cp temp/accsess.php ESP-Dashboard/php/src/

chmod 777 ESP-Dashboard/php/src/settings.json

echo "Fertig"