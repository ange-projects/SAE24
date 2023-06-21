import random
from math import sqrt


#-----------------------Bit degradation----------------------


def degradation_bit(valeur,bit, pourcentage):
  id_micro, data = valeur[0:2], valeur[2:]
  liste_bit = list(data) #for example ['1', '0', '1', '0', '1', etc]
  data_origine = data
  data_origine = int(data, 2) #convert the original data into integers to calculate the difference later 
  pourcentage /= 100
  maximum = pourcentage * data_origine #1% of original value

  #the binary that is altered needs to be in range (1, 52) to exclude the mantisa and the sign number. However, to have a small mistake generated, we only want to modify the number by a magnitude that is high enough to generate some parasite. That is why we start the range later on.

  if bit == 2:
    while True:
      index1, index2 = random.sample(range(14, 26), 2) 
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
      index1 = random.choice(range(14,26)) 
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

def estimation_case(tableau_errone):
  liste_case_min, liste_case_min2 = [], []
  dico_amplitude_errone, dico_distance = {}, {}
  
  for index, element in enumerate(tableau_errone):
    id_micro,data_errone = element[0:2], element[2:]
    
    amplitude_errone = binaire_a_amplitude(data_errone)
    valeur_distance = sqrt(coef_permittivite/amplitude_errone)

    dico_amplitude_errone['am_errone_mic' + str(index+1)] = amplitude_errone
    dico_distance["distance_mic" + str(index+1)] = valeur_distance

    ecart_min, case_min, ecart_min_2, case_min_2 = 10000, 0, 10000, 0
    
    for case, distances in distance_case.items():
      a_comparer = distance_case[case]['micro'+str(index+1)]
      distance_mic = dico_distance['distance_mic'+str(index+1)]
      ecart = abs(a_comparer - distance_mic)
      if ecart <= ecart_min:
        ecart_min = ecart
        case_min = case
        if ecart < ecart_min_2:
          ecart_min_2 = ecart
          case_min_2 = case
    liste_case_min.append(case_min)
    liste_case_min2.append(case_min_2)
    
  print(liste_case_min)
  print(liste_case_min2)

  return liste_case_min + liste_case_min2  
    

  #print(dico_amplitude_errone)
  #print(dico_distance)


def choix_amplitude(tableau, choix_micro, choix_bit, pourcentage):

  choix_micro.sort()
  tableau_nouvelles_valeurs = []
  dico_micro = {'01': 1, '10': 2, '11': 3}
  
  for element in tableau:
    id_micro = element[0:2]
    index = dico_micro[id_micro]
    if index in choix_micro:
      tableau_nouvelles_valeurs.append(degradation_bit(tableau[index-1], choix_bit, pourcentage))
    else:
      tableau_nouvelles_valeurs.append(tableau[index-1])  

  return tableau_nouvelles_valeurs
     


def principal(tab, choix_micro, choix_bit, pourcentage):
  tableau_valeur_errone = []
  tableau_valeur_errone = choix_amplitude(tab, choix_micro, choix_bit, pourcentage)
  estimation_case(tableau_valeur_errone)

tab = ['010011110100111011000001011000011101101110010110110000000100100000', '100011110101000101010000000101100100101101011101001110011110001101', '110011110110010001010011100110101010000111101110000101111001000011']

principal(tab, [1,3], 1, 0.1)
  
