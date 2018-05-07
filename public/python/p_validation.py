#!/usr/bin/python
import csv
import re
import classes
import neededcourses
import study_plan as stp
import preference as pre
import acad_progress 
import sys


if __name__ == '__main__':
	course = sys.argv[1]
	taken = sys.argv[2]
	prefer = sys.argv[3]
	studyplan = classes.createSubjectList(stp.getCoursePath(course))
	takencourses = classes.createSubjectList(taken)
	gelist = classes.createSubjectList("study plans\\ge_list.csv")
	remainAH = pre.remainAH(gelist,stp.getGEAH(takencourses))
	remainSSP = pre.remainSSP(gelist,stp.getGESSP(takencourses))
	remainMST = pre.remainMST(gelist,stp.getGEMST(takencourses))
	remainCORE = pre.remainCORE(studyplan,taken,takencourses)
	if (prefer not in remainAH) and (prefer not in remainCORE) and (prefer not in remainMST) and (prefer not in remainSSP):
		print("FALSE")
	else :
		print("TRUE")
	#print(prefer)