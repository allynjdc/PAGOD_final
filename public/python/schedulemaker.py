#!/usr/bin/python
import csv
import classes
import numpy as np

def initbacktracking(coursesToTake, coursesTaken, electiveList):
	coursenamesToTake = []
	ge_ah_cnt = 1
	ge_mst_cnt = 1
	ge_ssp_cnt = 1
	elective_cnt = 1
	pe_cnt = 1
	for course in coursesToTake:
		if course.courseName != "":
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
	problem = classes.Problem(coursenamesToTake, coursesTaken, electiveList)
	assignment = {}
	print(problem.variable_domain)
	for key in problem.variable_domain.keys():
		assignment.setdefault(key, None)
	# print(assignment)
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
	student = classes.Student(3, "2016-2017", 2, "bs cmsc", classes.createSubjectList("../csv/3rdYrKomsai.csv"))
	coursesToTake = [
		classes.Subject("4", "1", "cmsc137", "core", "3", "lec"),
		classes.Subject("4", "1", "cmsc137", "core", "", "lab"),
		classes.Subject("4", "1", "cmsc142", "core", "3", "lec"),
		classes.Subject("4", "1", "cmsc198.1", "core", "2", "lec"),
		classes.Subject("4", "1", "cmsc192", "core",  "1", "lec"),
		classes.Subject("4", "1", "", "pe", "3", "lec"),
		classes.Subject("4", "1", "", "elective", "3", "lec"),
		classes.Subject("1", "1", "", "ge(ah)", "3", "lec")
	]
	assignment = initbacktracking(coursesToTake, student.coursesTaken, student.electiveList)
	try:
		for key in assignment.keys():
			assignment[key].displayClassOffering()
	except Exception as e:
		print("No schedule was made")