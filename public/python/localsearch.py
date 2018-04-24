#!/usr/bin/python
import classes
import json
import sectioning
import sys
from backtracking import variableCourses
from json import JSONEncoder
from constraints import *
from problem import Problem

def initls(coursesToTake, coursesTaken, electiveList):
	variables = variableCourses(coursesToTake)

	domain = {}
	# classOfferingList = classes.createClassesList("csv\\data.csv")
	classOfferingList = classes.createClassesList("../csv/data.csv")
	classOfferingList = [classoffering for classoffering in classOfferingList if (classoffering.year == "2016-2017" and classoffering.semester == "1")]

	for var in variables:
		domain[var] = sectioning.findSections(var, classOfferingList, electiveList, coursesTaken)
	# print(domain)
	constraints = []

	c = NoConflictsConstraint(variables)
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	constraints.append(c)

	problem = Problem(variables, domain, constraints, electiveList)
	problem.name = 'Local Search - Timetabling'

	return
def solution_format(problem, solution):
	contraint = problem.constraints[0]
	is_valid = 'valid' if constraint.test(solution) else 'invalid'

	assigned_subjects = {}
	for var in problem.variables:
		assigned_subjects[var] = solution[var]

if __name__ == "__main__":
	# course = sys.argv[1]
	# csvpath = sys.argv[2]
	course = "bs cmsc"
	csvpath = "../csv/4thYrKomsai3.csv"
	student = classes.Student(3, "2016-2017", 2, course, classes.createSubjectList(csvpath))
	coursesToTake = [
		classes.Subject("4", "1", "cmsc137", "core", "3", "lec"),
		classes.Subject("4", "1", "cmsc137", "core", "", "lab"),
		classes.Subject("4", "1", "cmsc142", "core", "3", "lec"),
		classes.Subject("4", "1", "cmsc198.1", "core", "2", "lec"),
		classes.Subject("4", "1", "cmsc192", "core",  "1", "lec"),
		classes.Subject("4", "1", "", "elective", "3", "lec"),
		classes.Subject("4", "1", "", "elective", "3", "lec"),
		classes.Subject("1", "1", "", "ge(ah)", "3", "lec")
	]
	assignment = initls(coursesToTake, student.coursesTaken, student.electiveList)

	# try:
	# 	for key in assignment.keys():
	# 		assignment[key] = MyEncoder().encode(assignment[key])
	# except Exception as e:
	# 	print("No schedule was made")
	# print(json.dumps(assignment))