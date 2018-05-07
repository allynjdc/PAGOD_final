#!/usr/bin/python
import classes
import json
import sys

from json import JSONEncoder

class MyEncoder(JSONEncoder):
	def default(self, o):
		return o.__dict__

def csvConversion(pathname):
	ifile, reader = classes.csvReader(pathname)
	index = 0
	subjects = {}
	for row in reader:
		year = row[0]
		semester = row[1]
		courseName = row[2]
		campus = row[3]
		leclab = row[4]
		section = row[5]
		units = row[6]
		instructor = row[7]
		sessions = row[8].split("|")
		classoffering = classes.ClassOffering(year, semester, courseName, campus, leclab, section, units, instructor)
		sessionlist= []
		for session in sessions:
			room, days, start, end = session.split(",")
			s = classes.Session(room, days, start, end)
			sessionlist.append(s)
		classoffering.setSessions(sessionlist)
		subjects[index] = classoffering
		index += 1
	return subjects
	ifile.close()

if __name__ == '__main__':
	############################################
	schedulepath = sys.argv[1]
	############################################
	# schedulepath = "../schedule/1.csv"
	############################################
	assignment = csvConversion(schedulepath)
	# for key in assignment:
	# 	assignment[key].displayClassOffering()
	print(json.dumps(assignment, cls=MyEncoder))
	