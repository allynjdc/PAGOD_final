#!/usr/bin/python
import csv
import classes
import numpy as np

def initbacktracking(coursesToTake, coursesTaken):
	coursenamesToTake = []
	for course in coursesToTake:
		if course.courseName != "":
			coursenamesToTake.append(course.courseName)
		else:
			coursenamesToTake.append(course.courseType)
	problem = classes.Problem(coursenamesToTake, coursesTaken)
	assignment = {}
	for key in problem.variable_domain.keys():
		assignment.setdefault(key, None)
	assignment = backtracking(assignment, problem)
	return assignment

def backtracking(assignment, problem):
	if problem.checkCompleteness(assignment):
		return assignment
	var = problem.selectUnassignedVariable(assignment)
	for value in problem.variable_domain[var]:
		temp = assignment
		temp[var] = value
		if not problem.checkListConflict(temp):
			assignment[var] = value
			result = backtracking(assignment, problem)
			if result != None:
				return result
			assignment[var] = []
	return None

if __name__ == "__main__":
	student = classes.Student(3, 2, "bs chemical engineering", classes.createSubjectList("../study plans/bs chemical engineering.csv"), classes.createSubjectList("../csv/3rdYrChemEng.csv"))
	coursesToTake = [
		classes.Subject("4", "2", "che123", "core", "3", "lec"),
		classes.Subject("4", "2", "che135", "core", "2", "lab"),
		classes.Subject("4", "2", "che140", "core", "3", "lec"),
		classes.Subject("4", "2", "ee6", "core", "4", "lec"),
		classes.Subject("4", "2", "es13", "core", "3", "lec"),
		classes.Subject("4", "2", "", "ge(ah)", "3", "lec"),
		classes.Subject("4", "2", "", "ge(mst)",  "3", "lec")
	]
	assignment = initbacktracking(coursesToTake, student.coursesTaken)
	for key in assignment.keys():
		assignment[key].displayClassOffering()