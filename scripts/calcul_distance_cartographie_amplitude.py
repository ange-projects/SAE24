import math
import struct
import scipy.constants

room_size = (8, 8)  #Permit to modify the size of the room further in project
micro1 = (0.25, 0.25)   #Position of mic1
micro2 = (0.25, 7.75)   #Position of mic2
micro3 = (7.75, 7.75)   #Position of mic3

    #Functions

#Calculating all box of the room
def room_mapping (room_size):
    positions = []
    for i in range(room_size[0]):
        for j in range(room_size[1]):
            x = i + 0.25
            y = j + 0.25
            positions.append((x, y))
    return positions

#Display table positions
def display_room_map (positions):
    for i, position in enumerate(positions):
        print(f"Case {i+1} : {position}")

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

#------------Main program------------

positions = room_mapping(room_size)
#display_room_map(positions)

distance_case = distance(positions)
#display_distance_table(distance_case)

#-----------------------------------

amplitude  = {}
micro = ["micro1","micro2","micro3"]
coef_permittivite = scipy.constants.epsilon_0

def dico_amplitude():
  for id_case in range(1,65):
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


def amplitude_a_binaire(nombre):

  nbr_binaire = []
  
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


nombre_bin = amplitude_a_binaire(1.5e-13)
print(nombre_bin)



