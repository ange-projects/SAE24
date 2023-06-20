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
print(payload) # {'Amplitude_binaire': ['010011110101010100011010000010110011110010000000100000111110000100', '100011110110000010010100100111111110111111001111101000101000101110', '110011110101000111100000001100111100100001010100011101001001010000'], 'x,y': (0.75, 5.75)}
data = eval(payload)  # Évaluation de la chaîne de caractères représentant le dictionnaire

amplitude_list = data['Amplitude_binaire']
xy = data['x,y']

for message in amplitude_list:
  liste = message.strip('][').replace("'", "").split(', ')

for element in liste:
    x, y = calcul_distance_cartographie_amplitude.trouver_x_y(element)
    resultat_estimation.append((x, y)) 

print(resultat_estimation,xy)


#-----------------------------Database-------------------------------


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

cursor.execute("SELECT MAX(ID_mesure) FROM coord_points")
result = cursor.fetchone() #To retrieve the first line of the result
id_mesure = result[0]

if id_mesure is None:
  id_mesure = 1
else:
  id_mesure += 1

#resultat = [(3.25,2.25),(2.25,2.75),(2.25,2.75)] : Example of what we get from the script that finds the coordinates from the amplitude of a microphone in binary form

# Executing an SQL query to insert data
for element in resultat:
    x, y = element
    #cursor.execute("INSERT INTO coord_points (ID_mesure, x, y) VALUES (%s, %s, %s)", (id_mesure, x, y))

# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()


