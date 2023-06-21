import random
from math import sqrt



#-----------------------Bit degradation----------------------


def degradation_bit(valeur,bit, pourcentage):
  id_micro, data = valeur[0:2], valeur[2:]
  liste_bit = list(data) #for example ['1', '0', '1', '0', '1', etc]
  data_origine = data
  data_origine = int(data, 2) #convert the original data into integers to calculate the difference later 
  pourcentage /= 100
  maximum = pourcentage * data_origine #5% of original value

  #the binary that is altered needs to be in range (1, 52) to exclude the mantisa and the sign number. However, to have a small mistake generated, we only want to modify the number by a magnitude that is high enough to generate some parasite. That is why we start the range later on.

  if bit == 2:
    while True:
      index1, index2 = random.sample(range(14, 28), 2) 
      liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0' #simulation of degradation
      liste_bit[index2] = '1' if liste_bit[index2] == '0' else '0' #ternary condition
      data_modif = ''.join(liste_bit) #for example '101010110011' as a string
      data_modif_int = int(data_modif, 2) #conversion to decimal base
      ecart = abs(data_modif_int - data_origine) #calculate absolute change
      if ecart <= maximum: # if the change is within the desired range, we stop
        break
      else: # otherwise, we flip the bits back and try again
        liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0'
        liste_bit[index2] = '1' if liste_bit[index2] == '0' else '0'
  if bit == 1:
    while True: 
      index1 = random.choice(range(14,28)) 
      liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0' 
      data_modif = ''.join(liste_bit)
      data_modif_int = int(data_modif, 2) 
      ecart = abs(data_modif_int - data_origine) 
      if ecart <= maximum:
        break
      else: 
        liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0'
  
  data_modif = ''.join(liste_bit)
  return id_micro + data_modif
    
#print(degradation_bit('111111111111111111111111111111111111111111111111111111111111111111',2,2))

def degradation(tableau, choix, pourcentage):
  dico_amplitude_errone, dico_distance = {}, {}
  
  for index, element in enumerate(tableau):
    valeur_errone = degradation_bit(element, choix,pourcentage)
    id_micro,data_errone = valeur_errone[0:2], valeur_errone[2:]
    
    amplitude_errone = binaire_a_amplitude(data_errone)
    valeur_distance = sqrt(coef_permittivite/amplitude_errone)

    dico_amplitude_errone['am_errone_mic' + str(index+1)] = amplitude_errone
    dico_distance["distance_mic" + str(index+1)] = valeur_distance

    ecart_min, case_min = 10000, 0
    
    for case, distances in distance_case.items():
      a_comparer = distance_case[case]['micro'+str(index+1)]
      distance_mic = dico_distance['distance_mic'+str(index+1)]
      ecart = abs(a_comparer - distance_mic)
      if ecart < ecart_min:
        ecart_min = ecart
        case_min = case
    print(ecart_min, case)
      
    

  print(dico_amplitude_errone)
  print(dico_distance)

print(degradation(['010011110101010100100111100011100000000000110111101100010110000111', '100011110110000011011110010111110000011011000010001001011001010000', '110011110101000100101100000011101110110000011111011010110011011101'],1,0.01))

