#!/usr/bin/python
import csv
import re
import classes
import neededcourses
import study_plan as stp
import acad_progress 
import sys
 
def remainAH(gelist,taken):
	AH = []
	for ge in gelist:
		if ge.courseType == "ge(ah)":
			if ge.courseName.replace(" ","") not in taken:
				AH.append(ge.courseName)
	return AH

def remainSSP(gelist,taken):
	SSP = []
	for ge in gelist:
		if ge.courseType == "ge(ssp)":
			if ge.courseName.replace(" ","") not in taken:
				SSP.append(ge.courseName)
	return SSP

def remainMST(gelist,taken):
	MST = []
	for ge in gelist:
		if ge.courseType == "ge(mst)":
			if ge.courseName.replace(" ","") not in taken:
				MST.append(ge.courseName)
	return MST

def cor_list(plan,taken):
	core_list = []
	for subj in plan:
		for take in taken:
			if subj.courseName.replace(" ","") == take.courseName: # and take.courseName!="pe1":
				core_list.append(subj.courseName)
	return core_list

def remainCORE(plan,taken):
	CORE = []
	for subj in plan:
		if ((subj.courseName.replace(" ","") not in stp.getGEAH(takencourses)) and (subj.courseName.replace(" ","") not in stp.getGESSP(takencourses)) and (subj.courseName.replace(" ","") not in stp.getGEMST(takencourses)) and (subj.courseName.replace(" ","") not in cor_list(plan,taken))):
			if subj.courseName != '':
				CORE.append(subj.courseName)
	return CORE

if __name__ == '__main__':
	course = sys.argv[1]
	taken = sys.argv[2]
	studyplan = classes.createSubjectList(stp.getCoursePath(course))
	takencourses = classes.createSubjectList(taken)
	gelist = classes.createSubjectList("study plans\\ge_list.csv")
	remainAH = remainAH(gelist,stp.getGEAH(takencourses))
	remainSSP = remainSSP(gelist,stp.getGESSP(takencourses))
	remainMST = remainMST(gelist,stp.getGEMST(takencourses))
	remainCORE = remainCORE(studyplan,takencourses)
	for subj in remainAH:
		print(subj+",")
	print("/")
	for subj in remainMST:
		print(subj+",")
	print("/")
	for subj in remainSSP:
		print(subj+",")
	print("/")
	for subj in remainCORE:
		print(subj+",")
	print("/")
	#print(remainAH)
	#print(remainSSP)
	#print(remainMST)
	#print(remainCORE)