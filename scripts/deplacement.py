#PARTIE DEPLACEMENT ALEATOIRE POINT
# Initialize placement at position 15
placement = 15

#ETABKISSEMENT D'UNE LISTE DES VOISINS DE LA CASE DE LA POSITION ACTUELLE
def get_voisin(pos):
    lig = pos // 16
    col = pos % 16

    voisin = []

    if lig > 0:
        voisin.append(pos - 16)
    if lig > 0 and col < 15:
        voisin.append(pos - 15)
    if col < 15:
        voisin.append(pos + 1)
    if lig < 15 and col < 15:
        voisin.append(pos + 17)
    if lig < 15:
        voisin.append(pos + 16)
    if lig < 15 and col > 0:
        voisin.append(pos + 15)
    if col > 0:
        voisin.append(pos - 1)
    if lig > 0 and col > 0:
        voisin.append(pos - 17)

    return voisin

def update_placement():
    global placement
    print(placement)
    voisin = get_voisin(placement)
    placement = random.choice(voisin) #RANDOM CHOICE BETWEEN PREVIOUSLY DEFINED POSSIBILITIES
    time.sleep(1) #PUBLISHING SPEED


def reset_placement():
    global placement
    placement = 15

while True:
    update_placement()