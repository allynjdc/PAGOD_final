#!/usr/bin/python
import csv
import classes
import numpy as np

def slotList():
	return list(np.arange(7, 19.25, .25, dtype="double"))
# def createSchedule(coursesToTake, availableClasses):

def findSections(courseName, classOfferingList):
	return [classoffering for classoffering in classOfferingList if courseName == classoffering.courseName]

def findDayIndices(slotList, start, end, day):
	index1 = slotList.index(start)
	index2 = slotList.index(end)
	day_value = dayValue(day)
	slotLength = len(slotList)
	index1 = (day_value * slotLength) + index1
	index2 = (day_value * slotLength) + index2
	return list(np.arange(index1, index2))

def dayValue(day):
	if day == "M":
		return 0
	elif day == "T":
		return 1
	elif day == "W":
		return 2
	elif day == "Th":
		return 3
	elif day == "F":
		return 4
	elif day == "S":
		return 5
	return 6

if __name__ == "__main__":
	coursesToTake = [
		classes.Subject("4", "2", "che123", "core", "3", "lec"),
		classes.Subject("4", "2", "che135", "core", "2", "lab"),
		classes.Subject("4", "2", "che140", "core", "3", "lec"),
		classes.Subject("4", "2", "ee6", "core", "4", "lec"),
		classes.Subject("4", "2", "es13", "core", "3", "lec")
	]
	
	# for course in coursesToTake:
	# 	course.displaySubject()
	
	classOfferingList = classes.createClassesList("../csv/data.csv")
	sections = findSections("math54", classOfferingList)

	for section in sections:
		sessions = section.sessions
		print("Section ",section.section)
		for index in range(len(sessions)):
			days = sessions[index].days.split(" ")
			print("\tSession "+str(index))
			for day in days:
				dayIndices = findDayIndices(slotList(), sessions[index].start, sessions[index].end, day)
				print("\t\t",day, dayIndices)
			# print(dayIndices)
	# print(slotList())
