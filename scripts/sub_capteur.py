import time
import mysql.connector
import paho.mqtt.client as mqtt
import calcul_distance_cartographie_amplitude
import degradation
import ast

#------------------------------------------------Mosquitto sub------------------------------------------------

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
    with open('/home/pi/Desktop/SAE24/scripts/connecte.lock', 'w') as file:
        pass
except:
    print("Erreur de connexion au broker")

#---Background MQTT loop---
client.loop_start()

while stop:
    time.sleep(1)

client.loop_stop()  # Stopping the MQTT loop
client.disconnect()  # Disconnecting the broker










#------------------------------------------------Information processing------------------------------------------------

data = eval(payload)  # Évaluation de la chaîne de caractères représentant le dictionnaire

resultat_reel=[]
resultat_estimation_clean = []

resultat_estimation_deg = []
amplitude_list = data['Amplitude_binaire']
resultat_estimation_clean = calcul_distance_cartographie_amplitude.trouver_x_y(amplitude_list)
resultat_reel.append(data['x,y'])
print("estimé : ",resultat_estimation_clean)
print("réel : ",resultat_reel)




def principal(amplitude_list, choix_micro, choix_bit, pourcentage):
  tableau_valeur_errone = []
  tableau_valeur_errone = degradation.choix_amplitude(amplitude_list, choix_micro, choix_bit, pourcentage)
  tableau_final = degradation.estimation_case(tableau_valeur_errone)
  dico_occurences = degradation.compter_occurrences(tableau_final)
  return dico_occurences


with open('./dico/dico_coord_sans_para.txt', 'r') as file:
    bible_txt = file.read()

bible = ast.literal_eval(bible_txt)

dico_occurences = principal(amplitude_list, [1,3], 1, 0.1)
#print(dico_occurences)  # Vérifier la valeur de dico_occurences

def calcul_deg(dico):
    dico_new = {}
    for case in dico    :
        x = bible[case]['x']
        y = bible[case]['y']
        couple = (x,y)
        dico_new [couple] = dico[case] 
    return dico_new

resultat_estimation_deg = calcul_deg(dico_occurences)
print(resultat_estimation_deg)



#--------------------------------------Data send for clean data (no degradation)--------------------------------------

# Script used to send real and estimated positions for sound based on amplitude values with no degradation

# Connexion to database
connexion = mysql.connector.connect(
    host='localhost',
    port='3306',
    database='bd_micros',
    user='root',
    password='root'
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

# Executing an SQL query to insert data in coord_point
for element in resultat_estimation_clean:
    x = element[0]
    y = element[1]
    cursor.execute("INSERT INTO coord_points (ID_mesure, x, y) VALUES (%s, %s, %s)", (ID_mesure, x, y))


# Executing an SQL query to insert data in coord_point_deg
for element in resultat_estimation_deg:
    x = element[0]
    y = element[1]
    poids = resultat_estimation_deg[element]
    cursor.execute("INSERT INTO coord_points_deg (ID_mesure, poids, x, y) VALUES (%s, %s, %s, %s)", (ID_mesure, poids, x, y))





# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()
