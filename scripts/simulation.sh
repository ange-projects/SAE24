#!/bin/bash
rm /home/pi/Desktop/SAE24/scripts/log_simulation.txt
while true; do
    # Excute sub_capteur.py en arrire-plan
    python /home/pi/Desktop/SAE24/scripts/sub_capteur.py &
    echo "Script subscribe exécuté à : "$(date +"%d-%m-%Y %H:%M:%S") >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
    sleep 2
    # Excute pub_capteur.py en arrire-plan
    python /home/pi/Desktop/SAE24/scripts/pub_capteur.py &
    echo "Script publication exécuté à : "$(date +"%d-%m-%Y %H:%M:%S") >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
    # Attend 5 secondes avant la prochaine itration
    sleep 2
    echo "Fin de la boucle" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
    echo "-----------------------------------------------------------" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
done
#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