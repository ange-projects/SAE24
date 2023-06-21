with open('dico/dico_amplitude_binaire.txt', 'r') as file:
    contenu = file.read()
    dico_amplitude_binaire = eval(contenu)

with open('dico/dico_coord_sans_para.txt', 'r') as file: 
    contenu = file.read()
    dico_coord_sans_para = eval(contenu)



#---------------------The way to find (x,y) from binary data----------------------------


def trouver_x_y(liste_valeur):
  micro_plage = {'01': 'am_micro_binaire1', '10': 'am_micro_binaire2','11': 'am_micro_binaire3'}
  liste_case, liste_case_2, liste_final, coord_list = [], [], [], []
  for element in liste_valeur:
    id_micro, data_binaire = element[0:2], element[2:]
    micro = micro_plage.get(id_micro, 'inconnu')
    if not liste_case: #première valeur
      for case, sous_dico in dico_amplitude_binaire.items():
        if sous_dico[micro] == data_binaire:
          liste_case.append(case)
    else:
      if not liste_case_2:
        for case in liste_case: 
          if dico_amplitude_binaire[case][micro] == data_binaire:
            liste_case_2.append(case)
      else:
        for case in liste_case_2:
          if dico_amplitude_binaire[case][micro] == data_binaire:
            liste_final.append(case)
  for case in liste_final:
       coord_list.append([dico_coord_sans_para[case]['x'], dico_coord_sans_para[case]['y']])
  return coord_list

#print(trouver_x_y(['010011110101000100011010000010110011110010000000100000111110000100', '100011110101000011001000111110101010011000110101011100101101110111', '110011110101100011001011001110110001110000101001010011111100100010']))




