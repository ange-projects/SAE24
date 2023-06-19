import math
import struct
import scipy.constants

room_size = (16, 16)  #Permit to modify the size of the room further in project
box_size = 0.25
micro1 = (0.25, 0.25)   #Position of mic1
micro2 = (0.25, 7.75)   #Position of mic2
micro3 = (7.75, 7.75)   #Position of mic3

#---------------Functions-----------------

#Calculating all box of the room
def room_mapping(room_size, box_size):
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


positions = room_mapping(room_size, box_size)
display_room_map(positions)
dico_coordonnee = dico_coord(positions)
distance_case = distance(positions)
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


#---------------------Conversion from binary to amplitude-------------------


def binaire_a_amplitude(nbr_binaire):
  
  representation_binaire = []
  octets = []

  for i in range(0, len(nbr_binaire), 8): #a step of 8
    octet = nbr_binaire[i:i+8]
    octets.append(octet) #example of list contents ['01001100', '01100101', '01101100']

  for octet in octets:
    valeur_decimale = int(octet, 2)  
    representation_binaire.append(valeur_decimale) #example of list contents [76, 101, 108] 

  longueur_repre_binaire = len(representation_binaire)
  packed = struct.pack('!{}B'.format(longueur_repre_binaire), *representation_binaire) #we convert the values contained in the list into a packed sequence of bytes
  amplitude = struct.unpack('!d', packed)[0] #This command unpacks the packed byte sequence into a floating point number
    
  return amplitude

#print(binaire_a_amplitude('0011110110100011011110000101101111100000000011101010011111011010'))


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


#--------------------Function to remove brackets and return x and y separately--------------------


def enlever_parenthese(dico):
  dico_distance_sans_para = {}
  for id_case, x_y in enumerate(dico):
    element_a_supp = dico[id_case+1]
    element = [float(element) for element in element_a_supp]
    x,y = element[0], element[1]
    dico_x_y = {'x': x, 'y': y}
    dico_distance_sans_para[id_case+1] = dico_x_y
  return dico_distance_sans_para 

dico_coord_sans_para = enlever_parenthese(dico_coordonnee)


#---------------------The way to find the cell from binary data----------------------------


def trouver_x_y(valeur):
  micro_plage = {'01': 'micro1', '10': 'micro2','11': 'micro3'}
  id_micro = valeur[0:2]
  data = valeur[2:]
  micro = micro_plage.get(id_micro, 'inconnu')
  for case, value in dico_amplitude_binaire_id.items():
      if valeur in str(value):
          return [dico_coord_sans_para[case]['x'], dico_coord_sans_para[case]['y']] #can add : "case micro, binaire_a_amplitude(data)"
  return "La suite de caractères n'est pas trouvée dans le dictionnaire"

#print(trouver_x_y('100011110101000010000000111010111110011110111001110101011000010110'))

#-----------------------Table for pierre-------------------------------------------

def tableau_pierre():
  tableau_pierre = []
  for id_case in range(1,257):
    tableau_info = [id_case, dico_coord_sans_para[id_case]['x'], dico_coord_sans_para[id_case]['y'], dico_amplitude[id_case]['am_micro1'],dico_amplitude[id_case]['am_micro2'],dico_amplitude[id_case]['am_micro3']]
    tableau_pierre.append(tableau_info)
  return tableau_pierre
  
tableau_de_pierre = tableau_pierre()
#print(tableau_de_pierre)


