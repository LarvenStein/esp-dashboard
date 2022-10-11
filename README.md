## Instalation via Docker

1. `git clone https://git.gartenbauzentrale.de/GartenbauzentraleEG/ESP-Dashboard.git`
2. `cd esp-dashboard/`
3. `nano php/src/accsess.php` und dort Zuganngsdaten bearbeiten
4. `docker-compose up (-d)`

--

Bei problemen bei erstellen von geräten, `chmod 777 php/src/settings.json` ausführen.

Standardport: *8000*