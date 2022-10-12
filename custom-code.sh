#!/bin/bash

read -p "Dies wird alles aus dem Conatiner Löschen! Ausgenommen settings.json und accsess.php. Möchtest du forfahren? (y/n) " yn

case $yn in 
	yY ) echo ok, we will proceed;;
	nN ) echo exiting...;
		exit;;
	* ) echo invalid response;
		exit 1;;
esac

read -p "füge den link zu deiner .git repository ein" repo

mkdir ../temp/
cp php/src/settings.json ../temp/
cp php/src/accsess.php ../temp/

rm -r *

git clone $repo 
rm php/src/settings.json
rm php/src/accsess.php
cp ../temp/settings.json php/src/
cp ../temp/accsess.php php/src/

echo "Fertig"