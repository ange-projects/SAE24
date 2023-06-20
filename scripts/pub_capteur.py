import time
import mysql.connector
import paho.mqtt.client as mqtt
import calcul_distance_cartographie_amplitude
import random


with open('dico/dico_amplitude_bin_id.txt', 'r') as file:
    contenu = file.read()
    dico_amplitude_binaire_id = eval(contenu)

with open('dico/dico_pos_x_y.txt', 'r') as file: 
    contenu = file.read()
    dico_pos_x_y = eval(contenu)

# Connexion to database
connexion = mysql.connector.connect(
    host='192.168.1.78',
    port='3306',
    database='bd_micros',
    user='brulix',
    password='brul1goat'
)

# Creating a cursor for executing SQL queries
cursor = connexion.cursor()

cursor.execute("SELECT x, y FROM coord_points_reel WHERE ID = (SELECT MAX(ID) FROM coord_points_reel)")
result = cursor.fetchone()
x_coord = result[0]
y_coord = result[1]
print(cursor, x_coord, y_coord)

cursor.execute(f"SELECT num_case FROM coord_cases WHERE x = {x_coord} AND y = {y_coord}")
result = cursor.fetchone()
placement = result[0]
print(placement)



# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()

#ETABKISSEMENT D'UNE LISTE DES VOISINS DE LA CASE DE LA POSITION ACTUELLE
def get_voisin(pos):
    lig = pos // 16
    col = pos % 16

    voisin = []

    if lig > 0:
        voisin.append(pos - 16)
    if lig > 0 and col < 15:
        voisin.append(pos - 15)
    if col < 15:
        voisin.append(pos + 1)
    if lig < 15 and col < 15:
        voisin.append(pos + 17)
    if lig < 15:
        voisin.append(pos + 16)
    if lig < 15 and col > 0:
        voisin.append(pos + 15)
    if col > 0:
        voisin.append(pos - 1)
    if lig > 0 and col > 0:
        voisin.append(pos - 17)

    return voisin



voisin = get_voisin(placement)

case_aleatoire = random.choice(voisin)
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
