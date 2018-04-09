#!/usr/bin/python
import csv
import classes
import numpy as np

def initbacktracking(coursesToTake, coursesTaken, electiveList):
	coursenamesToTake = []
	for course in coursesToTake:
		if course.courseName != "":
			coursenamesToTake.append(course.courseName+"-"+course.leclab)
		else:
			coursenamesToTake.append(course.courseType+"-"+course.leclab)
	problem = classes.Problem(coursenamesToTake, coursesTaken, electiveList)
	assignment = {}
	ge_ah_cnt = 1
	ge_mst_cnt = 1
	ge_ssp_cnt = 1
	elective_cnt = 1
	pe_cnt = 1
	for key in problem.variable_domain.keys():
		if (key == "ge(ah)"):
			assignment.setdefault(key+str(ge_ah_cnt), None)
			ge_ah_cnt += 1
		elif (key == "ge(mst)"):
			assignment.setdefault(key+str(ge_mst_cnt), None)
			ge_mst_cnt += 1
		elif (key == "ge(ssp)"):
			assignment.setdefault(key+str(ge_ssp_cnt), None)
			ge_ssp_cnt += 1
		elif (key == "elective"):
			assignment.setdefault(key+str(elective_cnt), None)
			elective_cnt += 1
		elif (key == "pe"):
			assignment.setdefault(key+str(pe_cnt), None)
			pe_cnt += 1
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
			session = [classes.Session("N/A", "TBA", None, None)]
			classoffering = classes.ClassOffering("N/A", "N/A", var, "N/A", "N/A", "N/A", "N/A", "N/A")
			classoffering.setSessions(session)
			assignment[var] = classoffering
	return None

if __name__ == "__main__":
	student = classes.Student(3, "2016-2017", 2, "bs cmsc", classes.createSubjectList("../study plans/bs cmsc.csv"), classes.createSubjectList("../csv/3rdYrKomsai.csv"), classes.createElectiveList("../electives/cmsc.csv"))
	coursesToTake = [
		classes.Subject("4", "1", "cmsc137", "core", "3", "lec"),
		classes.Subject("4", "1", "cmsc137", "core", "", "lab"),
		classes.Subject("4", "1", "cmsc142", "core", "3", "lec"),
		classes.Subject("4", "1", "cmsc198.1", "core", "2", "lec"),
		classes.Subject("4", "1", "cmsc192", "core",  "1", "lec"),
		# classes.Subject("4", "1", "", "elective", "3", "lec"),
		# classes.Subject("4", "1", "", "elective", "3", "lec"),
		classes.Subject("1", "1", "", "ge(ah)", "3", "lec")
	]
	assignment = initbacktracking(coursesToTake, student.coursesTaken, student.electiveList)
	try:
		for key in assignment.keys():
			assignment[key].displayClassOffering()
	except Exception as e:
		print("No schedule was made")