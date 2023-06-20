import time
import mysql.connector
import paho.mqtt.client as mqtt
import calcul_distance_cartographie_amplitude

#------------------------Mosquitto sub-------------------------

#---Broker information---

broker = "localhost"
port = 1883
topic = "SAE24/capteur"
stop = True
payload = None
resultat_estimation = []

#------------------------


def connexion(client, userdata, flags, rc):  # rc for return code
    if rc == 0:
        print("Connexion réussie")
        client.subscribe(topic)  # subscription
    else:
        print(f"Erreur de connexion, code = {rc}")


def message(client, userdata, msg):
    global stop, payload
    print(f"Topic: {msg.topic}, Message: {msg.payload.decode()}")
    payload = msg.payload.decode()
    stop = False


def deconnexion(client, userdata, rc):
    print("Déconnexion du broker")


#----Callbacks----
# A function which is passed as an argument to another function, and which is called at some point in the future

client = mqtt.Client()  # client creation
client.on_connect = connexion
client.on_message = message
client.on_disconnect = deconnexion

#---Attempt to connect to the broker---

try:
    client.connect(broker, port)
except:
    print("Erreur de connexion au broker")

#---Background MQTT loop---

client.loop_start()

while stop:
    time.sleep(1)

client.loop_stop()  # Stopping the MQTT loop
client.disconnect()  # Disconnecting the broker

#--Information processing---
print(payload)  # {'Amplitude_binaire': ['010011110101010100011010000010110011110010000000100000111110000100', '100011110110000010010100100111111110111111001111101000101000101110', '110011110101000111100000001100111100100001010100011101001001010000'], 'x,y': [0.75, 5.75]}
data = eval(payload)  # Évaluation de la chaîne de caractères représentant le dictionnaire

resultat_reel=[]
amplitude_list = data['Amplitude_binaire']
resultat_reel.append(data['x,y'])

print("liste : ",amplitude_list)

resultat_estimation = calcul_distance_cartographie_amplitude.trouver_x_y(amplitude_list)

print("estimé : ",resultat_estimation)
print("réel : ",resultat_reel)


# Script used to send real and estimated positions for sound based on amplitude valuess

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

# Executing an SQL query to insert data in coord_point_reel
for element in resultat_reel:
    x = element[0]
    y = element[1]
    cursor.execute("INSERT INTO coord_points_reel (x, y) VALUES (%s, %s)", (x, y))
    

# Extracting the ID used in coord_points_reel to insert in ID_mesure for coord_point
cursor.execute("SELECT MAX(ID) FROM coord_points_reel")
result = cursor.fetchone() #To retrieve the first line of the result
ID_mesure = result[0]

# Executing an SQL query to insert data in coord_point_reel
for element in resultat_estimation:
    x = element[0]
    y = element[1]
    cursor.execute("INSERT INTO coord_points (ID_mesure, x, y) VALUES (%s, %s, %s)", (ID_mesure, x, y))

# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()
