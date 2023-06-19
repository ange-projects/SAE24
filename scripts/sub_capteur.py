import time
import paho.mqtt.client as mqtt
import calcul_distance_cartographie_amplitude

#------------------------Mosquitto sub-------------------------

#---Broker information---

broker = "localhost"
port = 1883
topic = "SAE24/capteur"
messages = []
stop = True

#------------------------


def connexion(client, userdata, flags, rc):  #rc for return code
  if rc == 0:
    print("Connexion réussie")
    client.subscribe(topic)  #subscription
  else:
    print(f"Erreur de connexion, code = {rc}")


def message(client, userdata, msg):
  global stop
  print(f"Topic: {msg.topic}, Message: {msg.payload.decode()}")
  messages.append(msg.payload.decode())
  stop = False


def deconnexion(client, userdata, rc):
  print("Déconnexion du broker")


#----Callbacks----
#A function which is passed as an argument to another function, and which is called at some point in the future

client = mqtt.Client()  #client creation
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

client.loop_stop()  #Stopping the MQTT loop
client.disconnect()  #Disconnecting the broker

#--Information processing---

resultat = []

for message in messages:
  liste = message.strip('][').replace("'", "").split(', ')

for element in liste:
    x, y = calcul_distance_cartographie_amplitude.trouver_x_y(element)
    resultat.append((x, y)) 

print(resultat)


