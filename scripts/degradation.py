import random
import calcul_distance_cartographie_amplitude

#-----------------------Bit degradation----------------------


def degradation_bit(valeur,bit):
  id_micro, data = valeur[0:2], valeur[2:]
  liste_bit = list(data)

  #the binary that is altered needs to be in range (1, 52) to exclude the mantisa and the sign number. However, to have a small mistake generated, we only want to modify the number by a magnitude that is high enough to generate some parasite. That is why we start the range later on.

  if bit == 2:
    index1, index2 = random.sample(range(14, 25), 2) 
    liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0' #simulation of degradation
    liste_bit[index2] = '1' if liste_bit[index2] == '0' else '0' #ternary condition
  if bit == 1:
    index1 = random.sample(range(14, 25), 1)[0]
    liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0' #simulation of degradation
  
  data_modif = ''.join(liste_bit)
  return id_micro + data_modif
    
#print(degradation_bit('111111111111111111111111111111111111111111111111111111111111111111',1))

def degradation(tableau, choix):
  for element in tableau:
    valeur_errone = degradation_bit(element, choix)
    id_micro,data_errone = valeur_errone[0:2],valeur_errone[2:]
    amplitude_errone = binaire_a_amplitude(data_errone)
    print(amplitude_errone)
    
print(degradation(['010011110101000101100010000110011111101011111100001000010011100110','010011110101000101100010000110011111101011111100001000010011100110','010011110101000101100010000110011111101011111100001000010011100110'],1))


