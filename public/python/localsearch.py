#!/usr/bin/python
import classes
import json
import sectioning
import sys

from backtracking import variableCourses
from json import JSONEncoder
from constraints import *
from problem import Problem

from solver.ls import LocalSearchSolver
from fn.ls import *
from fn.objective import *
from utils import *

def common_config():
	config = Config()
	config.max_restarts = 20
	config.max_iterations = 100
	config.max_flat_iterations = 30
	config.random_seed = 123456789
	return config

def hill_walking_config(config,reverse):
	if reverse: # downhill
		config.legal_neighbor_fn = non_increasing
		config.selection_fn = select_min
	else: # uphill
		config.legal_neighbor_fn = non_decreasing
		config.selection_fn = select_max

def initls(coursesToTake, coursesTaken, electiveList):
	variables = variableCourses(coursesToTake)

	domain = {}
	# classOfferingList = classes.createClassesList("csv\\data.csv")
	classOfferingList = classes.createClassesList("../csv/data.csv")
	classOfferingList = [classoffering for classoffering in classOfferingList if (classoffering.year == "2016-2017" and classoffering.semester == "1")]

	for var in variables:
		domain[var] = sectioning.findSections(var, classOfferingList, electiveList, coursesTaken)	
	constraints = []

	c = NoConflictsConstraint(variables)
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	constraints.append(c)

	problem = Problem(variables, domain, constraints, electiveList)
	problem.name = 'Local Search - Timetabling'
	problem.solution_format = solution_format

	config = common_config()
	config.objective_fn = count_violations
	config.best_fn = min
	config.best_possible_score = 0
	config.initial_solution = 'random'
	config.respawn_solution = 'random'
	config.neighborhood_fn = change_upto_two_values
	reverse = True
	hill_walking_config(config,reverse)
	solver = LocalSearchSolver(problem,config)
	solver.solve()
	display_solutions(problem, solver)

def solution_format(problem, solution):

	assigned_subjects = {}
	for var in problem.variables:
		assigned_subjects[var] = solution[var]

	output = []
	for subject in problem.variables:
		content = "\n"
		content += ",".join([solution[subject].courseName, "Section" + solution[subject].section, solution[subject].instructor, solution[subject].leclab])
		for session in solution[subject].sessions:
			content += "\n\t"+session.room +" "+ session.days+" "+ str(session.start)+"-"+str(session.end)

		output.append(content)
	output.append("\n")
	output.append("\t")

	return "".join(output)

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

	initls(coursesToTake, student.coursesTaken, student.electiveList)

	# try:
	# 	for key in assignment.keys():
	# 		assignment[key] = MyEncoder().encode(assignment[key])
	# except Exception as e:
	# 	print("No schedule was made")
	# print(json.dumps(assignment))