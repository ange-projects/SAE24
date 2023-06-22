import time
import mysql.connector
import paho.mqtt.client as mqtt
import calcul_distance_cartographie_amplitude
import degradation
import ast

#------------------------------------------------Mosquitto sub------------------------------------------------


#----- Broker information -----
broker = "localhost"
port = 1883
topic = "SAE24/capteur"
stop = True
payload = None

#-------------------------------------------------------------------------------------------------------------

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

#----- Callbacks -----
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


#------------------------------ Extracting form information from table degradation ------------------------------------

# Connexion to database
connexion = mysql.connector.connect(
    host='192.168.1.26',
    port='3306',
    database='bd_micros',
    user='brulix',
    password='brul1goat'
)

cursor = connexion.cursor() # Creating a cursor for executing SQL queries

# Extracting the ID used in degradation reel to get the last quesry from user
cursor.execute("SELECT MAX(ID) FROM degradation")
result = cursor.fetchone()
ID_last = result[0]

cursor.execute("SELECT * FROM degradation WHERE ID = %(id)s", {'id': ID_last})
selection = cursor.fetchone()
print(selection)
methode = selection[1]
print(f"methode : {methode}")
mic_sup = selection[2]
print(f"mic_sup : {mic_sup}")
mic_mod = selection[3]
mic_mod_tab = [int(mic) for mic in mic_mod]
print(mic_mod_tab)
print(f"mic moc : { mic_mod}")
nb_bit_deg = selection[4]
print(f"bit : {nb_bit_deg}")
print(nb_bit_deg)
degre_deg = selection[5]
vitesse = selection[6]

#------------------------------------------------Information processing------------------------------------------------

resultat_reel=[]
resultat_estimation=[]

#Process for recovering the actual and estimated positions (without degradation) of the square 
data = eval(payload)  # Évaluation de la chaîne de caractères représentant le dictionnaire
amplitude_list = data['Amplitude_binaire']

resultat_reel.append(data['x,y'])
print("Position réelle : ",resultat_reel)

# Perfect mode
if methode == 0:
    resultat_estimation = calcul_distance_cartographie_amplitude.trouver_x_y(amplitude_list)

# Realistic degradation mode
if methode == 1:
    print(amplitude_list)
    var = mic_sup - 1
    for i in range (len(amplitude_list)):
        if i == var :
            amplitude_list[i] = '0'
    resultat_estimation = calcul_distance_cartographie_amplitude.trouver_x_y_2(amplitude_list)

# Advanced degradation mode
def principal(amplitude_list, choix_micro, choix_bit, pourcentage):
  tableau_valeur_errone = []
  tableau_valeur_errone = degradation.choix_amplitude(amplitude_list, choix_micro, choix_bit, pourcentage)
  tableau_final = degradation.estimation_case(tableau_valeur_errone)
  dico_occurences = degradation.compter_occurrences(tableau_final)
  return dico_occurences

with open('./dico/dico_coord_sans_para.txt', 'r') as file:
    bible_txt = file.read()

bible = ast.literal_eval(bible_txt)

if degre_deg == 1:
    value_deg = 0.01
if degre_deg == 2:
    value_deg = 2
if degre_deg == 3:
    value_deg = 4
else:
	value_deg = 0.01

print(resultat_estimation)


if methode == 2:
    print(f"resultat_estimation  : {resultat_estimation}")
    resultat_estimation = principal(amplitude_list, mic_mod_tab, nb_bit_deg, value_deg)
    print(f"resultat_estimation  : {resultat_estimation}")
    
	def calcul_deg(dico):
		dico_new = {}
		for case in dico    :
        		x = bible[case]['x']
        		y = bible[case]['y']
        		couple = (x,y)
        		dico_new [couple] = dico[case] 
    		return dico_new

	resultat_estimation = calcul_deg(resultat_estimation)
	print(resultat_estimation)

	def reduire(dico):
   		dico2 = {}
    		while len(dico2) < 3 and dico:  # Continuer jusqu'à ce que dico2 atteigne 3 éléments ou que dico soit vide
        		max_occur = 0
        		max_key = None
        		for element in dico:
            			if dico[element] > max_occur:
                			max_occur = dico[element]
                			max_key = element
        			if max_key is not None:
            				dico2[max_key] = max_occur
            				del dico[max_key]  # Supprimer l'élément du dictionnaire original
    			return dico2


	resultat_estimation = reduire(resultat_estimation)
	print(resultat_estimation)


print("Position estimée : ",resultat_estimation)





#--------------------------------------Data send for clean data (no degradation)--------------------------------------

# Script used to send real and estimated positions for sound based on amplitude values with no degradation

# Executing an SQL query to insert data in coord_point_reel
print(resultat_reel)
for element in resultat_reel:
    x = element[0]
    y = element[1]
    cursor.execute("INSERT INTO coord_points_reel (x, y) VALUES (%s, %s)", (x, y))
    

# Extracting the ID used in coord_points_reel to insert in ID_mesure for coord_point
cursor.execute("SELECT MAX(ID) FROM coord_points_reel")
result = cursor.fetchone() #To retrieve the first line of the result
ID_mesure = result[0]

# Executing an SQL query to insert data in coord_point_deg
print(resultat_estimation)
for element in resultat_estimation:
    x = element[0]
    y = element[1]
    print(f"x : {x}")
    print(f"y : {y}")
    if methode == 0: 
        poids = 6
    if methode == 1: 
        poids = 3
    if methode == 2: 
        poids = resultat_estimation[element]

    cursor.execute("INSERT INTO coord_points (ID_mesure, poids, x, y) VALUES (%s, %s, %s, %s)", (ID_mesure, poids, x, y))

# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()

