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

def hill_climbing_config(config,reverse):
	if reverse: # downhill
		config.legal_neighbor_fn = strictly_decreasing
		config.selection_fn = select_min
	else: # uphill
		config.legal_neighbor_fn = strictly_increasing
		config.selection_fn = select_max

def softConstraintList(softconstraints, variables):
	constraints = []
	for const in softconstraints:
		penalty = 15
		if const.priority == "M":
			penalty = 10
		elif const.priority == "L":
			penalty = 5
		if const.meeting_time:
			days = const.days.split(" ")
			c = NoClassOnTime(variables,days,const.start, const.end)
			c.name = 'No Class On Time: '+const.days+" "+const.start+" "+const.end
			c.penalty = penalty
			constraints.append(c)
		elif const.no_class:
			days = const.days.split(" ")
			c = NoClassOnDayConstraint(variables, days)
			c.name = 'No Class On: '+const.days
			c.penalty = penalty
			constraints.append(c)
		elif const.musthave:
			c = MustHaveConstraint(variables, const.subject)
			c.name = 'Must Have: '+const.subject
			c.penalty = penalty
			constraints.append(c)
		elif const.mustnothave:
			c = MustNotHaveConstraint(variables, const.subject)
			c.name = 'Must Not Have: '+const.subject
			c.penalty = penalty
			constraints.append(c)

	return constraints


class MyEncoder(JSONEncoder):
	def default(self, o):
		return o.__dict__

def initls(coursesToTake, coursesTaken, electiveList, softconstraints, campus="Miagao"):
	variables = variableCourses(coursesToTake)
	domain = {}
	############################################
	classOfferingList = classes.createClassesList("csv\\data.csv")
	# classOfferingList = classes.createClassesList("../csv/data.csv")
	############################################
	semester = coursesToTake[0].semester
	classOfferingList = [classoffering for classoffering in classOfferingList if (classoffering.semester == semester and classoffering.campus==campus)]

	for var in variables:
		domain[var] = sectioning.findSections(var, classOfferingList, electiveList, coursesTaken, campus)
	constraints = []
	c = NoConflictsConstraint(variables)
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	constraints.append(c)

	constraints = constraints + softConstraintList(softconstraints, variables)
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
	############################################
	config.explain = False
	# config.explain = True
	############################################
	reverse = True
	hill_climbing_config(config,reverse)
	solver = LocalSearchSolver(problem,config)
	solver.solve()
	############################################
	# display_solutions(problem, solver)
	############################################

	return solver.solutions

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
	course = sys.argv[1]
	csvpath = sys.argv[2]
	constraintspath = sys.argv[3]
	preferencesPath = sys.argv[4]
	schedulePath = sys.argv[5]
	############################################
	# course = "bs cmsc"
	# csvpath = "../csv/4thYrKomsai3.csv"
	# constraintspath = "../constraints/1.csv"
	# preferencesPath = "../preferences/1.csv"
	# schedulePath = "../schedule/1.csv"
	############################################
	student = classes.Student(3, "2016-2017", 2, course, classes.createSubjectList(csvpath))
	coursesToTake = classes.createSubjectList(preferencesPath)
	softconstraints = classes.createConstraintsList(constraintspath)
	assignment = initls(coursesToTake, student.coursesTaken, student.electiveList, softconstraints, student.campus)
	# print(MyEncoder().encode(assignment))
	assignment = MyEncoder().encode(assignment)
	# print(json.dumps(assignment, cls=MyEncoder))
	assignment = json.loads(assignment)
	classes.csvWriter(schedulePath, assignment)