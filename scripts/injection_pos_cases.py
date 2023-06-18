import mysql.connector
import calcul_distance_cartographie_amplitude

# Connexion to database
connexion = mysql.connector.connect(
    host='192.168.103.189',
    port='3306',
    database='bd_micros',
    user='brulix',
    password='brul1goat'
)

# Création d'un curseur pour exécuter des requêtes SQL
cursor = connexion.cursor()

# Exécution d'une requête SQL pour insérer des données
for position in calcul_distance_cartographie_amplitude.positions:
    x, y = position
    cursor.execute("INSERT INTO coord_cases (x, y) VALUES (%s, %s)", (x, y))

# Valider la transaction
connexion.commit()

# Fermeture de la connexion
connexion.close()
