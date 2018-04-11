#!/usr/bin/python
import csv
import re
import classes
import neededcourses
import study_plan as stp
import sys

def checkUnits(course,subject,subtype):
	for sub in course:
		if sub.courseName == subject:
			return sub.units
		elif subtype!="pe":
				return "3"
		elif subtype == "pe":
			return "2"


if __name__ == '__main__':
	course = sys.argv[1]
	taken = sys.argv[2]
	studyplan = classes.createSubjectList(stp.getCoursePath(course))
	takencourses = classes.createSubjectList(taken)
	for takencourse in takencourses:
		print(takencourse.courseName+",")
		print(takencourse.courseType+",")
		print(checkUnits(studyplan,takencourse.courseName,takencourse.courseType))
		print("/")