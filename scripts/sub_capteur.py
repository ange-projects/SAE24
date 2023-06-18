import time
import paho.mqtt.client as mqtt
import calcul_distance_cartographie_amplitude

#------------------------Mosquitto sub-------------------------

#---Broker information---

broker = "localhost"  
port = 1883  
topic = "SAE24/capteur" 
messages = []
coordonnees_x_y = []
message_count = 0

#------------------------

def connection(client,userdata,flag, rc): #rc for return code
    if rc == 0:
        print("Connexion réussie")
        client.subscribe(topic)  #subscription
    else:
        print(f"Erreur de connexion, code = {rc}")

def message(client,userdata, msg):
    print(f"Topic: {msg.topic}, Message: {msg.payload.decode()}")
    messages.append(msg.payload.decode())
    message_count += 1
    coordonnee = trouver_case(message)
    if coordonnee:
        coordonnees_x_y.append(coordonnee)
    if message_count >= 1:
        client.disconnect()

def deconnection(client,userdata,rc):
    print("Déconnexion du broker")

#----Callbacks----
#A function which is passed as an argument to another function, and which is called at some point in the future

client = mqtt.Client()  #client creation
client.on_connect = connection 
client.on_message = message  
client.on_disconnect = deconnection  

#---Attempt to connect to the broker---

try: 
    client.connect(broker, port) 
except:
    print("Erreur de connexion au broker")

#---Background MQTT loop---

client.loop_start() 

while client.is_connected(): 
    time.sleep(1)

client.loop_stop() #Stopping the MQTT loop 
client.disconnect() #Disconnecting the broker

for message in messages:
  print(message)

for coordonnee in coordonnees:  
  print(coordonnee)
