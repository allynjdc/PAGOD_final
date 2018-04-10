#!/usr/bin/python
import csv
import classes

def countCourseType(courseList, courseType):
	counter = 0
	for course in courseList:
		if course.courseType == courseType:
			counter += 1
	return counter

def getWildCardCourses(courseList):
	wildcard_courseTypes = set([course.courseType for course in courseList if course.courseName.strip() == ''])
	wildcard_courseTypes_max_counts = {}
	for wildcard_courseType in wildcard_courseTypes:
		wildcard_courseTypes_max_counts[wildcard_courseType] = countCourseType(courseList, wildcard_courseType)
	return wildcard_courseTypes_max_counts

def getCurrentCounts(coursesTaken, wildcard_courseTypes_max_counts):
	wildcard_courseTypes_current_counts = {}

	for course in coursesTaken:
		if course.courseType in wildcard_courseTypes_max_counts.keys():
			wildcard_courseTypes_current_counts.setdefault(course.courseType, 0)
			wildcard_courseTypes_current_counts[course.courseType] += 1

	return wildcard_courseTypes_current_counts

def getLackingCounts(wildcard_courseTypes_max_counts, wildcard_courseTypes_current_counts):
	wildcard_courseTypes_lacking_counts = {}

	for courseType,max_count in wildcard_courseTypes_max_counts.items():
		actual_count = 0
		if courseType in wildcard_courseTypes_current_counts.keys():
			actual_count = wildcard_courseTypes_current_counts[courseType]
		lacking_count = max_count - actual_count
		wildcard_courseTypes_lacking_counts[courseType] = lacking_count

	return wildcard_courseTypes_lacking_counts


def coursesToTake(allCourses, coursesTaken):
	wildcard_courseTypes_max_counts = getWildCardCourses(allCourses)

	wildcard_courseTypes_current_counts = getCurrentCounts(coursesTaken, wildcard_courseTypes_max_counts)

	wildcard_courseTypes_lacking_counts = getLackingCounts(wildcard_courseTypes_max_counts, wildcard_courseTypes_current_counts)
	
	output = []
	name_coursesTaken = [course.courseName for course in coursesTaken]
	for course in allCourses:
		if course.courseName.strip() != '': #if not blank, match name
			if course.courseName not in name_coursesTaken:
				output.append(course)
		else: # blank course name, match type
			courseType = course.courseType
			if  wildcard_courseTypes_lacking_counts[courseType] > 0:
				output.append(course)
				wildcard_courseTypes_lacking_counts[courseType] -= 1

	return output

if __name__ == '__main__':
	student = classes.Student(3, "2016-2017", 2, "bs cmsc", classes.createSubjectList("../csv/3rdYrKomsai.csv"))
	neededcourses = coursesToTake(student.allCourses, student.coursesTaken)
	for neededcourse in neededcourses:
		neededcourse.displaySubject()
