#!/usr/bin/python
import math

room_size = (8, 8)  #Permit to modify the size of the room further in project
micro1 = (0.25, 0.25)   #Position of mic1
micro2 = (0.25, 7.75)   #Position of mic2
micro3 = (7.75, 7.75)   #Position of mic3
    
    #Functions

#Calculating all box of the room
def room_mapping (room_size):
    positions = []
    for i in range(room_size[0]):
        for j in range(room_size[1]):
            x = i + 0.25
            y = j + 0.25
            positions.append((x, y))
    return positions

#Display table positions
def display_room_map (positions):
    for i, position in enumerate(positions):
        print(f"Case {i+1} : {position}")

#Distance calculation function (Pythagoras)
def pythagore (position1, position2):
    x1, y1 = position1
    x2, y2 = position2
    distance = math.sqrt((x2 - x1)**2 + (y2 - y1)**2)
    return distance

#Distance calculation from each box for each mic
def distance (positions):
    distance_case = {}
    for i, position_case in enumerate(positions):
        distance_micro = {}

        distance1 = pythagore(position_case, micro1)
        distance2 = pythagore(position_case, micro2)
        distance3 = pythagore(position_case, micro3)

        distance_micro['capteur1'] = distance1
        distance_micro['capteur2'] = distance2
        distance_micro['capteur3'] = distance3
    
        distance_case[i+1] = distance_micro

    return distance_case

def display_distance_table(distance_case):
    for case_num, distances in distance_case.items():
        print(f"Case {case_num}:")
        for capteur, distance in distances.items():
            print(f"  {capteur}: {distance} mètres")

    #Main program

positions = room_mapping(room_size)
display_room_map(positions)

distance_case = distance(positions)
display_distance_table(distance_case)