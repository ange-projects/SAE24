import time
import mysql.connector
import paho.mqtt.client as mqtt
import random


with open('dico/dico_amplitude_bin_id.txt', 'r') as file:
    contenu = file.read()
    dico_amplitude_binaire_id = eval(contenu)

with open('dico/dico_pos_x_y.txt', 'r') as file: 
    contenu = file.read()
    dico_pos_x_y = eval(contenu)
    
with open('dico/dico_grille.txt', 'r') as file: 
    contenu = file.read()
    grille = eval(contenu)

# Connexion to database
connexion = mysql.connector.connect(
    host='192.168.102.239',
    port='3306',
    database='bd_micros',
    user='brulix',
    password='brul1goat'
)
# Creating a cursor for executing SQL queries
cursor = connexion.cursor()

# Fetching the "vitesse" value from the "degradation" table
cursor.execute("SELECT vitesse FROM degradation ORDER BY id DESC")
result = cursor.fetchone()
vitesse = result[0]
print(vitesse)

cursor.fetchall()
# Closing the cursor
cursor.close()

# Creating a cursor for executing SQL queries
cursor = connexion.cursor()

cursor.execute("SELECT x, y FROM coord_points_reel WHERE ID = (SELECT MAX(ID) FROM coord_points_reel)")
result = cursor.fetchone()
x_coord = result[0]
y_coord = result[1]
#print(cursor, x_coord, y_coord)

cursor.execute(f"SELECT num_case FROM coord_cases WHERE x = {x_coord} AND y = {y_coord}")
result = cursor.fetchone()
placement = result[0]
#print(placement)

# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()

#ETABLISSEMENT D'UNE LISTE DES VOISINS DE LA CASE DE LA POSITION ACTUELLE
def get_voisin(pos):
    voisin = []
    row_count = len(grille)
    col_count = len(grille[0])
    for i in range(row_count):
        for j in range(col_count):
            if grille[i][j] == pos:
                # Check left neighbor
                if j > 0:
                    voisin.append(grille[i][j - 1])
                # Check right neighbor
                if j < col_count - 1:
                    voisin.append(grille[i][j + 1])
                # Check top neighbor
                if i > 0:
                    voisin.append(grille[i - 1][j])
                # Check bottom neighbor
                if i < row_count - 1:
                    voisin.append(grille[i + 1][j])
                # Check top-left neighbor
                if i > 0 and j > 0:
                    voisin.append(grille[i - 1][j - 1])
                # Check top-right neighbor
                if i > 0 and j < col_count - 1:
                    voisin.append(grille[i - 1][j + 1])
                # Check bottom-left neighbor
                if i < row_count - 1 and j > 0:
                    voisin.append(grille[i + 1][j - 1])
                # Check bottom-right neighbor
                if i < row_count - 1 and j < col_count - 1:
                    voisin.append(grille[i + 1][j + 1])
    print("Voisin exclu :", voisin)
    return voisin

voisin = get_voisin(placement)
print("Voici les cases possibles au voisinage de la précédente : ",voisin)
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

#print (payload)

# Création d'un client MQTT
client = mqtt.Client()

# Connexion au broker MQTT
client.connect("localhost", 1883, 60)

# Calculating the sleep duration based on the vitesse value
if vitesse == 1:
    sleep_duration = 0
elif vitesse == 2:
    sleep_duration = 2
elif vitesse == 3:
    sleep_duration = 10
else:
    sleep_duration = 0

# Sleeping for the calculated duration
time.sleep(sleep_duration)
# Publication du message aléatoire sur le topic
client.publish("SAE24/capteur", str(payload))
#print("C'est bon")

# Déconnexion du broker MQTT
client.disconnect()
