import mysql.connector
import sub_capteur

# Script used to send real and estimated positions for sound based on amplitude valuess

# Connexion to database
connexion = mysql.connector.connect(
    host='192.168.1.78',
    port='3306',
    database='bd_micros',
    user='brulix',
    password='brul1goat'
)

# Creating a cursor for executing SQL queries
cursor = connexion.cursor()

# Executing an SQL query to insert data in coord_point_reel
for element in sub_capteur.resultat_reel:
    x, y = element
    cursor.execute("INSERT INTO coord_points_reel (x, y) VALUES (%s, %s)", (x, y))

# Extracting the ID used in coord_points_reel to insert in ID_mesure for coord_point
cursor.execute("SELECT MAX(ID) FROM coord_points_reel")
result = cursor.fetchone() #To retrieve the first line of the result
ID_mesure = result[0]

# Executing an SQL query to insert data in coord_point_reel
for element in sub_capteur.resultat_estimation:
    x, y = element
    cursor.execute("INSERT INTO coord_points (ID_mesure, x, y) VALUES (%s, %s, %s)", (ID_mesure, x, y))

# Validate the transaction
connexion.commit()

# Closing the connection
connexion.close()