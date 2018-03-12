#!/usr/bin/python
import csv
import classes
import numpy as np


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
	coursenamesToTake = [course.courseName for course in coursesToTake]
	problem = classes.Problem(coursenamesToTake, classOfferingList)
	# sections = findSections("math54", classOfferingList)
	# backtracking([], coursesToTake)
	# for section in sections:
	# 	sessions = section.sessions
	# 	print("Section ",section.section)
	# 	for index in range(len(sessions)):
	# 		days = sessions[index].days.split(" ")
	# 		print("\tSession "+str(index+1))
	# 		for day in days:
	# 			dayIndices = findDayIndices(slotList(), sessions[index].start, sessions[index].end, day)
	# 			print("\t\t",day, dayIndices, sessions[index].start, sessions[index].end)