import random

def degradation_bit(valeur):
  id_micro, data = valeur[0:2], valeur[2:]
  liste_bit = list(data)
  
  index1, index2 = random.sample(range(64), 2) #random index generation

  liste_bit[index1] = '1' if liste_bit[index1] == '0' else '0' #simulation of degradation
  liste_bit[index2] = '1' if liste_bit[index2] == '0' else '0' #ternary condition
  
  data_modif = ''.join(liste_bit)
  return id_micro + data_modif
  
  
#print(degradation_bit('010011110101000101100010000110011111101011111100001000010011100110'))
