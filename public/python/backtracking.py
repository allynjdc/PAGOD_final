#!/usr/bin/python
import classes
import json
from json import JSONEncoder
import sectioning
import sys

def variableCourses(coursesToTake):
	coursenamesToTake = []
	ge_ah_cnt = 1
	ge_mst_cnt = 1
	ge_ssp_cnt = 1
	elective_cnt = 1
	pe_cnt = 1
	for course in coursesToTake:
		if course.courseName != "":
			mult_sections = ["cmsc197", "stat197", "cd168", "econ198", "psych195", "cl195", "econ198"]
			applied_chem = "chem181"
			if course.courseName in mult_sections:
				coursenamesToTake.append(course.courseName+"_"+str(elective_cnt)+"-"+course.leclab)
				elective_cnt += 1
			elif course.courseName == applied_chem:
				coursenamesToTake.append(course.courseName+"-lec")
				coursenamesToTake.append(course.courseName+"-lab")
			else:
				coursenamesToTake.append(course.courseName+"-"+course.leclab)
		else:
			if course.courseType == "ge(ah)":
				coursenamesToTake.append(course.courseType+str(ge_ah_cnt)+"-"+course.leclab)
				ge_ah_cnt += 1
			elif course.courseType == "ge(mst)":
				coursenamesToTake.append(course.courseType+str(ge_mst_cnt)+"-"+course.leclab)
				ge_mst_cnt += 1
			elif course.courseType == "ge(ssp)":
				coursenamesToTake.append(course.courseType+str(ge_ssp_cnt)+"-"+course.leclab)
				ge_ssp_cnt += 1
			elif course.courseType == "elective":
				coursenamesToTake.append(course.courseType+str(elective_cnt)+"-"+course.leclab)
				elective_cnt += 1
			elif course.courseType == "pe":
				coursenamesToTake.append(course.courseType+str(pe_cnt)+"-"+course.leclab)
				pe_cnt += 1
	return coursenamesToTake

def initbacktracking(coursesToTake, coursesTaken, electiveList):
	coursenamesToTake = variableCourses(coursesToTake)
	problem = classes.Problem(coursenamesToTake, coursesTaken, electiveList)
	assignment = {}
	for key in problem.variable_domain.keys():
		assignment.setdefault(key, None)
	# print(problem.variable_domain)
	assignment = backtracking(assignment, problem)
	return assignment

def backtracking(assignment, problem):
	if sectioning.checkCompleteness(assignment):
		return assignment
	var = sectioning.selectUnassignedVariable(assignment)
	for value in problem.variable_domain[var]:
		temp = assignment
		temp[var] = value
		if not sectioning.checkListConflict(temp):
			assignment[var] = value
			result = backtracking(assignment, problem)
			if result != None:
				return result
			session = [classes.Session("N/A", "TBA", None, None)]
			classoffering = classes.ClassOffering("N/A", "N/A", var, "N/A", "N/A", "N/A", "N/A", "N/A")
			classoffering.setSessions(session)
			assignment[var] = classoffering
	return None

class MyEncoder(JSONEncoder):
	def default(self, o):
		return o.__dict__

if __name__ == "__main__":
	course = sys.argv[1]
	csvpath = sys.argv[2]
	# course = "bs cmsc"
	# csvpath = "../csv/4thYrKomsai3.csv"
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
	assignment = initbacktracking(coursesToTake, student.coursesTaken, student.electiveList)

	try:
		for key in assignment.keys():
			assignment[key] = MyEncoder().encode(assignment[key])
	except Exception as e:
		print("No schedule was made")
	print(json.dumps(assignment))