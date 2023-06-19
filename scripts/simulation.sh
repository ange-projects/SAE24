#!/bin/bash

while true; do
    # Excute sub_capteur.py en arrire-plan
    python /home/pi/Desktop/SAE24/scripts/sub_capteur.py &

    sleep 2
    # Excute pub_capteur.py en arrire-plan
    python /home/pi/Desktop/SAE24/scripts/pub_capteur.py &

    # Attend 5 secondes avant la prochaine itration
    sleep 5

done
