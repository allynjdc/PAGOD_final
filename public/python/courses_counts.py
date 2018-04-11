import csv
import re
import classes
import neededcourses
import study_plan as stp
import sys

def countGEAH(course):
	count = 0
	for sub in course:
		if sub.courseType == "ge(ah)":
			count+=1
	return count

def countGESSP(course):
	count = 0
	for sub in course:
		if sub.courseType == "ge(ssp)":
			count+=1
	return count

def countGEMST(course):
	count = 0
	for sub in course:
		if sub.courseType == "ge(mst)":
			count+=1
	return count

def countOPEN(course):
	count = 0
	for sub in course:
		if sub.courseType == "pe" or sub.courseType == "nstp":
			count+=1
	return count

def countELECT(course):
	count = 0
	for sub in course:
		if sub.courseType == "elective":
			count+=1
	return count

def countCORE(course):
	count = 0
	for sub in course:
		if sub.courseType == "core" or sub.courseType == "service":
			count+=1
	return count

if __name__ == '__main__':
	course = sys.argv[1]
	studyplan = classes.createSubjectList(stp.getCoursePath(course))
	print(countCORE(studyplan))
	print(",")
	print(countELECT(studyplan))
	print(",")
	print(countGEAH(studyplan))
	print(",")
	print(countGEMST(studyplan))
	print(",")
	print(countGESSP(studyplan))
	print(",")
	print(countOPEN(studyplan))