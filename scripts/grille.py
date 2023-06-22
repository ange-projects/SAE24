def generer_grille(n):
    grille = []
    numero = 1

    for i in range(n-1, -1, -1):
        ligne = []
        for j in range(n):
            case = i + j * n + 1
            ligne.append(case)
        grille.append(ligne)

    return grille

def afficher_grille(grille):
    for ligne in grille:
        for case in ligne:
            print(f"{case:4}", end="")
        print()

#Generate and print the grid
grille = generer_grille(16)
afficher_grille(grille)

def dico_grille(grille, file):
    for ligne in grille:
        for case in ligne:
            file.write(f"{case:4}")
        file.write("\n")

# Open the file in write mode
with open("dico/dico_grille.txt", "w") as file:
    dico_grille(grille, file)
