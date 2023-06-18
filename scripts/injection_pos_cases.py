import mysql.connector
import calcul_distance_cartographie_amplitude

# Connexion to database
connexion = mysql.connector.connect(
    host='192.168.1.78',
    port='3306',
    database='bd_micros',
    user='brulix',
    password='brul1goat'
)

# Création d'un curseur pour exécuter des requêtes SQL
cursor = connexion.cursor()

# Exécution d'une requête SQL pour insérer des données
for tabrecup in calcul_distance_cartographie_amplitude.tableau_de_pierre:
    num_case, x, y, amp1, amp2, amp3 = tabrecup
    cursor.execute("INSERT INTO coord_cases (num_case, x, y, MIC1, MIC2, MIC3) VALUES (%s, %s, %s, %s, %s, %s)", (num_case, x, y, amp1, amp2, amp3))

# Valider la transaction
connexion.commit()

# Fermeture de la connexion
connexion.close()
