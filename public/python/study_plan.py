#!/usr/bin/python
import csv
import re
import classes
import neededcourses
import sys

def getCoursePath(course):
	if course == "BS in Biology":
		return "study plans\\bs bio.csv"
	elif course == "BS in Public Health":
		return "study plans\\bs ph.csv"
	elif course == "BS in Fisheries":
		return "study plans\\bs fisheries.csv"
	elif course == "BS in Accountancy":
		return "study plans\\bs accountancy.csv"
	elif course == "BS in Business Administration":
		return "study plans\\bs business administration majoy in marketing.csv"
	elif course == "BS in Management":
		return "study plans\\bs management.csv"
	elif course == "BS in Applied Mathematics":
		return "study plans\\bs appmath.csv"
	elif course == "BS in Chemistry":
		return "study plans\\bs chem.csv"
	elif course == "BS in Computer Science":
		return "study plans\\bs cmsc.csv"
	elif course == "BS in Statistics":
		return "study plans\\bs stat.csv"
	elif course == "BS in Communication and Media Study":
		return "study plans\\ba cms.csv"
	elif course == "BA in Literature":
		return "study plans\\ba lit.csv"
	elif course == "BA in Community Development":
		return "study plans\\ba cd.csv"
	elif course == "BA in History":
		return "study plans\\ba hist.csv"
	elif course == "BA Political Science (double major)":
		return "study plans\\ba polsci (double major).csv"
	elif course == "BA in Political Science (single major)":
		return "study plans\\ba polsci (single major).csv"
	elif course == "BA in Psychology":
		return "study plans\\ba psych.csv"
	elif course == "BA in Sociology":
		return "study plans\\ba socio.csv"
	elif course == "BS in Economics":
		return "study plans\\bs econ.csv"
	elif course == "BS in Chemical Engineering":
		return "study plans\\bs chemical engineering.csv"
	elif course == "BS in Food Technology":
		return "study plans\\bs food technology.csv"
	
def checkCompletion(taken,subject,subtype):
	for take in taken:
		if take.courseName == subject:
			return 1
	return 0

def getGEAH(taken):
	AH = []
	for take in taken:
		if take.courseType == "ge(ah)":
			AH.append(take.courseName)
	return AH

def getGESSP(taken):
	SSP = []
	for take in taken:
		if take.courseType == "ge(ssp)":
			SSP.append(take.courseName)
	return SSP

def getGEMST(taken):
	MST = []
	for take in taken:
		if take.courseType == "ge(mst)":
			MST.append(take.courseName)
	return MST

def getNSTP(taken):
	NTSP = []
	for take in taken:
		if take.courseType == "nstp":
			NTSP.append(take.courseName)
	return NTSP

def getPE(taken):
	PE = []
	for take in taken:
		if take.courseType == "pe":
			PE.append(take.courseName)
	return PE

def getELECT(taken):
	ELECTIVE = []
	for take in taken:
		if take.courseType == "elective":
			ELECTIVE.append(take.courseName)
	return ELECTIVE

if __name__ == '__main__':
	course = sys.argv[1]
	taken = sys.argv[2]
	studyplan = classes.createSubjectList(getCoursePath(course))
	takencourses = classes.createSubjectList(taken)
	AH = getGEAH(takencourses)
	SSP = getGESSP(takencourses)
	MST = getGEMST(takencourses)
	NSTP = getNSTP(takencourses)
	PE = getPE(takencourses)
	ELECTIVE = getELECT(takencourses)
	for subject in studyplan:
		print(subject.year+",")
		print(subject.semester+",")
		print(subject.courseName+",")
		print(subject.courseType+",")
		print(subject.units+",")
		if checkCompletion(takencourses,subject.courseName,subject.courseType) != 1:
			if subject.courseType == "ge(ah)" and len(AH)>0:
				AH.remove(AH[0])
				print(1)
			elif subject.courseType == "ge(mst)" and len(MST)>0:
				MST.remove(MST[0])
				print(1)
			elif subject.courseType == "ge(ssp)" and len(SSP)>0:
				SSP.remove(SSP[0])
				print(1)
			elif subject.courseType == "nstp" and len(NSTP)>0:
				NSTP.remove(NSTP[0])
				print(1)
			elif subject.courseType == "pe" and len(PE)>0:
				PE.remove(PE[0])
				print(1)
			elif subject.courseType == "elective" and len(ELECTIVE)>0:
				ELECTIVE.remove(ELECTIVE[0])
				print(1)
			else:
				print(0)
		else:
			print(1)
		print("/")