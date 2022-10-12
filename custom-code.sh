#!/bin/bash

read -p "Dies wird alles aus dem Conatiner Löschen! Ausgenommen settings.json und accsess.php. Möchtest du forfahren? (y/n) " yn

case $yn in 
	y ) echo ok, we will proceed;;
	n ) echo exiting...;
		exit;;
	* ) echo invalid response;
		exit 1;;
esac

read -p "füge den link zu deiner .git repository ein" repo

mkdir ../temp/
cp php/src/settings.json ../temp/
cp php/src/accsess.php ../temp/

rm -r ESP-Dashboard/

cd ../

git clone $repo ESP-Dashboard/
rm php/src/settings.json
rm php/src/accsess.php
cp ../temp/settings.json php/src/
cp ../temp/accsess.php php/src/

echo "Fertig"