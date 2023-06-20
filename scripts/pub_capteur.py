import random
import paho.mqtt.client as mqtt

with open('dico/dico_amplitude_bin_id.txt', 'r') as file:
    contenu = file.read()
    dico_amplitude_binaire_id = eval(contenu)
    
with open('dico/dico_pos_x_y.txt', 'r') as file: 
    contenu = file.read()
    dico_pos_x_y = eval(contenu)
    
case_aleatoire = random.choice(list(dico_amplitude_binaire_id.keys()))
amplitude_aleatoire = dico_amplitude_binaire_id[case_aleatoire]
position_x, position_y = dico_pos_x_y[case_aleatoire]

# Affichage des résultats
#print("Case aléatoire sélectionnée :", case_aleatoire)
#print("Amplitude binaire :", amplitude_aleatoire)
#print("Position réele (x, y) :", [position_x, position_y])

#définition de la payload à envoyer sur le bus MQTT
payload = {
    "Amplitude_binaire": amplitude_aleatoire,
    "x,y": [position_x, position_y]
}

print (payload)

# Création d'un client MQTT
client = mqtt.Client()

# Connexion au broker MQTT
client.connect("localhost", 1883, 60)

# Publication du message aléatoire sur le topic
client.publish("SAE24/capteur", str(payload))
print("C'est bon")

# Déconnexion du broker MQTT
client.disconnect()
