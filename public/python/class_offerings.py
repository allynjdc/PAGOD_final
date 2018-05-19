#!/usr/bin/python
import csv
import classes
import json
import sys
import acquire_schedule as acq


if __name__ == '__main__':
	############################################
	path = "csv\\data.csv"
	prefered = "preferences\\"+sys.argv[1]+".csv"
	############################################
	# path = "../csv/data.csv"
	# prefered = "../preferences/1.csv"
	############################################
	classOfferingList = classes.createClassesList(path)
	preferences = classes.createSubjectList(prefered)	
	for prefer in preferences:
		classOfferingList1 = [classoffering for classoffering in classOfferingList if (classoffering.courseName.lower().replace(" ","") == prefer.courseName.lower().replace('"',"") and classoffering.semester == prefer.semester)]
		for subject in classOfferingList1:
			print(subject.year+"|")
			print(subject.semester+"|")
			print(subject.courseName+"|")
			print(subject.section+"|")
			print(subject.units+"|")
			print(subject.campus+"|")
			for ses in subject.sessions:
				ses.displaySession()
			print("|")
			print(subject.instructor+"|")
			print('/')