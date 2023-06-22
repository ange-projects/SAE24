#!/bin/bash

rm /home/pi/Desktop/SAE24/scripts/log_simulation.txt

while true; do
    start_time=$(date +%s.%N)

    # Exécuter sub_capteur.py en arrière-plan
    python /home/pi/Desktop/SAE24/scripts/sub_capteur.py &
    echo "Script subscribe exécuté à : $(date +"%d-%m-%Y %H:%M:%S")" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt

    # Attendre que le fichier de verrouillage soit créé par sub_capteur.py
    while [ ! -f /home/pi/Desktop/SAE24/scripts/connecte.lock ]; do
        sleep 1
    done

    # Exécuter pub_capteur.py en arrière-plan avec la vitesse de publication ajustée
    python /home/pi/Desktop/SAE24/scripts/pub_capteur.py &
    echo "Script publication exécuté à : $(date +"%d-%m-%Y %H:%M:%S")" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt

    # Attendre que pub_capteur.py soit terminé
    wait
    end_time=$(date +%s.%N)

    # Calculer le temps d'exécution
    execution_time=$(echo "$end_time - $start_time" | bc)

    echo "Fin de la boucle a : $(date +"%d-%m-%Y %H:%M:%S")" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
    echo "Temps d'exécution : $execution_time secondes" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
    echo "-----------------------------------------------------------" >> /home/pi/Desktop/SAE24/scripts/log_simulation.txt
    echo "-----------------------------------------------------------"

    # Supprimer le fichier de verrouillage pour la prochaine itération
    rm /home/pi/Desktop/SAE24/scripts/connecte.lock
done
