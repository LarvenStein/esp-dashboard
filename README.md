## Instalation via Docker

1. `git clone https://git.gartenbauzentrale.de/GartenbauzentraleEG/ESP-Dashboard.git`
2. `cd esp-dashboard/`
3. `nano php/src/accsess.php` und dort Zuganngsdaten bearbeiten
4. `docker-compose up (-d)`

--

Bei problemen bei erstellen von geräten, `chmod 777 php/src/settings.json` ausführen.

Standardport: *8000*


## Instalation ohne Docker

1. `sudo apt install php -y` *php Installieren*
2. `sudo apt instal php8.1-cli php8.1-common php8.1-mysql php8.1-zip php8.1-gd php8.1-mbstring php8.1-curl php8.1-xml php8.1-bcmath -y` *php Erweiterungen Installieren*
3. `sudo apt install apache2 -y` *Den Apache Webserver Installieren*
4. `rm -r /var/www/html/*` *Demo Dateien des Webserver löschen*
5. `cd /var/www/html/` *In das Webserver verzeichniss wechseln*
6. Die `esp-dashboard.zip` datei des neusten SOURCE release runterladen
7. `unzip esp-dashboard.zip` *Das Dashboard entpacken*