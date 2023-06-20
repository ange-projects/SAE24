import math
import struct
import scipy.constants
import random
import paho.mqtt.client as mqtt

room_size = (16, 16)  #Permit to modify the size of the room further in project
micro1 = (0.25, 0.25)   #Position of mic1
micro2 = (0.25, 7.75)   #Position of mic2
micro3 = (7.75, 7.75)   #Position of mic3

#---------------Functions-----------------

#Calculating all box of the room
def room_mapping(room_size):
    positions = []
    for ligne in range(0,16):
        for colonne in range(0,16):
            x = (ligne/2) + 0.25
            y = (colonne/2) + 0.25
            positions.append((x, y))
    return positions



#Display table positions
def display_room_map (positions):
    for i, position in enumerate(positions):
        print(f"Case {i+1} : {position}")

#The creation of a dictionary linking boxes and their positions
def dico_coord(positions):
  dico_pos = {}
  for i, position in enumerate(positions):
    dico_pos[i+1] = position 
  return dico_pos

#Distance calculation function (Pythagoras)
def pythagore (position1, position2):
    x1, y1 = position1
    x2, y2 = position2
    distance = math.sqrt((x2 - x1)**2 + (y2 - y1)**2)
    return distance

#Distance calculation from each box for each mic
def distance (positions):
    distance_case = {}
    for i, position_case in enumerate(positions):
        distance_micro = {}

        distance1 = pythagore(position_case, micro1)
        distance2 = pythagore(position_case, micro2)
        distance3 = pythagore(position_case, micro3)

        distance_micro['micro1'] = distance1
        distance_micro['micro2'] = distance2
        distance_micro['micro3'] = distance3

        distance_case[i+1] = distance_micro

    return distance_case

def display_distance_table(distance_case):
    for case_num, distances in distance_case.items():
        print(f"Case {case_num}:")
        for capteur, distance in distances.items():
            print(f"  {capteur}: {distance}")


#----------------Main program------------------


positions = room_mapping(room_size)
#display_room_map(positions)
dico_coordonnee = dico_coord(positions)
distance_case = distance(positions)
print(distance_case)
#display_distance_table(distance_case)


#--------------Amplitude calculation------------------


amplitude  = {}
micro = ["micro1","micro2","micro3"]
coef_permittivite = scipy.constants.epsilon_0

def dico_amplitude():
  for id_case in range(1,257):
    amplitude_micro = {}
    for id_micro, microphone in enumerate(micro): #enumerate contains the index and the element traversed
      distance = distance_case[id_case][microphone]
      if distance == 0: #can't be divided by 0
        amplitude_micro["am_micro"+str(id_micro+1)] = 0
      else:
        resultat = (coef_permittivite/(distance **2))
        resultat_arrondi = round(resultat,15)
        amplitude_micro["am_micro"+str(id_micro+1)] = resultat_arrondi
    amplitude[id_case] = amplitude_micro
  return amplitude

dico_amplitude = dico_amplitude()
#print(dico_amplitude)


#---------------------Amplitude to binary conversion-------------------


def amplitude_a_binaire(nombre):
  
  packed = struct.pack('!d', nombre) 
  
  #converts the floating-point number into 8 bytes (64 bits) using the network byte order (big-endian)
  #b'=F\x18\x85h\xe7\xbf\x97' This line gives a byte string of this type containing seven bytes, which
  #are represented as ASCII characters or hexadecimal values.
  
  representation_binaire = [] #Initialise an empty list to store the binary representations of each byte

  for octet in packed: #Browse every byte in packed
    valeur_binaire = bin(octet) #Convert the byte into binary, which returns a string of characters starting with '0b'.
    valeur_binaire = valeur_binaire.replace('0b', '') #Remove the '0b' from the beginning of the string 
    valeur_binaire = valeur_binaire.rjust(8, '0') #Ensure that the binary representation is of length 8 (since a byte contains 8 bits)
    representation_binaire.append(valeur_binaire) #Add this binary representation to the list
  nbr_binaire = ''.join(representation_binaire) #Concatenate all binary representations into a single string
    
  return nbr_binaire



#-----------------------Dictionary with binary data-------------------------


amplitude_binaire  = {}
micro_binaire = ["am_micro1","am_micro2","am_micro3"]

def dico_amplitude_binaire():
  for id_case in range(1,257):
    amplitude_micro_binaire = {}
    for id_micro, microphone in enumerate(micro_binaire): 
      valeur = dico_amplitude[id_case][microphone]
      binaire = amplitude_a_binaire(valeur)
      amplitude_micro_binaire["am_micro_binaire"+str(id_micro+1)] = binaire
    amplitude_binaire[id_case] = amplitude_micro_binaire
  return amplitude_binaire

dico_amplitude_binaire = dico_amplitude_binaire()


#----------Dictionary with boxes and microphone identifiers concatenated with amplitude in binary-------------


amplitude_binaire_id  = {}
micro_binaire_id = ["am_micro_binaire1","am_micro_binaire2","am_micro_binaire3"]
combinaison = ["01","10","11"]

def dico_amplitude_binaire_id():
  for id_case in range(1,257):
    liste_valeur = []
    for id_micro, microphone in enumerate(micro_binaire_id): 
      valeur = dico_amplitude_binaire[id_case][microphone]
      valeur = combinaison[id_micro] + str(valeur)
      liste_valeur.append(valeur)
    amplitude_binaire_id[id_case] = liste_valeur
  return amplitude_binaire_id
  
dico_amplitude_binaire_id = dico_amplitude_binaire_id()



def get_random_case_values(dico):
        case_aleatoire = random.choice(list(dico.values())) #récupère aléatoirement la clé qui correspond à une case du dictionnaire de salle
        return case_aleatoire
# print("\n \n")
capteur_aleatoire = get_random_case_values(dico_amplitude_binaire_id)
print(capteur_aleatoire)





# Création d'un client MQTT
client = mqtt.Client()

# Connexion au broker MQTT
client.connect("localhost", 1883, 60)

# Publication du message aléatoire sur le topic
#client.publish("SAE24/capteur", str(capteur_aleatoire))
print("C'est bon")

# Déconnexion du broker MQTT
client.disconnect()
