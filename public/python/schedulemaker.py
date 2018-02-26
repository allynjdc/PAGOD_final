#!/usr/bin/python
import csv
import classes


# def createSchedule(coursesToTake, availableClasses):


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
	
	classes.createClassesList("../csv/data.csv")
