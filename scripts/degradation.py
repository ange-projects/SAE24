import random
from math import sqrt
import def_fct 

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
    
def estimation_case(tableau_errone):
  liste_case_min, liste_case_min2 = [], []
  dico_amplitude_errone, dico_distance = {}, {}
  
  for index, element in enumerate(tableau_errone):
    id_micro,data_errone = element[0:2], element[2:]
    
    amplitude_errone = def_fct.binaire_a_amplitude(data_errone)
    valeur_distance = sqrt(def_fct.coef_permittivite/amplitude_errone)

    dico_amplitude_errone['am_errone_mic' + str(index+1)] = amplitude_errone
    dico_distance["distance_mic" + str(index+1)] = valeur_distance

    ecart_min, case_min, ecart_min_2, case_min_2 = 10000, 0, 10000, 0
    
    for case, distances in def_fct.distance_case.items():
      a_comparer = def_fct.distance_case[case]['micro'+str(index+1)]
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
    
  return liste_case_min + liste_case_min2  

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
     
def compter_occurrences(liste):
    dico_occurence = {}
    for element in liste:
        if element in dico_occurence:
            dico_occurence[element] += 1
        else:
            dico_occurence[element] = 1
    return dico_occurence

#-------------------------------Fonction principale-------------------------------

# tab = ['010011110101001000111010010001100011011001101110111110010100001010', '100011110110011111001001101011111111000001000110001010100110101100', '110011110101001101010001011111110101100010001101111110101111100011']

# def principal(tab, choix_micro, choix_bit, pourcentage):
#   tableau_valeur_errone = []
#   tableau_valeur_errone = choix_amplitude(tab, choix_micro, choix_bit, pourcentage)
#   tableau_final = estimation_case(tableau_valeur_errone)
#   dico_occurences = compter_occurrences(tableau_final)
#   print(dico_occurences)

# principal(tab, [1,3], 1, 0.1)
  
