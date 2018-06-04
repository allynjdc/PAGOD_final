#!/usr/bin/python
import csv
import numpy as np
import re
import sectioning
from datetime import datetime

class Problem:
	def __init__(self, variables, coursesTaken, electiveList):
		variable_domain = {}
		self.coursesTaken = coursesTaken
		self.electiveList = electiveList
		for variable in variables:
			variable_domain.setdefault(variable, 0)
			classOfferingList = createClassesList("csv\\data.csv")
			# classOfferingList = createClassesList("../csv/data.csv")
			classOfferingList = [classoffering for classoffering in classOfferingList if (classoffering.year == "2016-2017" and classoffering.semester == "1")]
			variable_domain[variable] = sectioning.findSections(variable, classOfferingList, electiveList, coursesTaken)
		self.variable_domain = variable_domain

class Student:
	biodiv = ["bs bio", "bs ph"]
	cfos = ["bs fisheries"]
	cm = ["bs accountancy", "bs business administration", "bs management"]
	dpsm = ["bs appmath", "bs cmsc", "bs stat"]
	chem = ["bs chem"]
	humdiv = ["bs cms", "ba lit"]
	socscidiv = ["ba cd", "ba hist", "ba polsci (double major)", "ba polsci (single major)", "ba psych", "ba socio", "bs econ"]
	sotech = ["bs chemical engineering", "bs food technology"]
	no_electives = ["bs ph", "bs accountancy"]
	def __init__(self, year,  academicYear, semester, degreeProgram, coursesTaken):
		self.year = year
		self.academicYear = academicYear
		self.semester = semester
		self.degreeProgram = degreeProgram
		############################################
		self.allCourses = createSubjectList("study plans\\"+degreeProgram+".csv")
		# self.allCourses = createSubjectList("../study plans/"+degreeProgram+".csv")
		self.coursesTaken = coursesTaken
		############################################
		if self.degreeProgram in Student.no_electives:
			self.electiveList = []
		else:
			self.electiveList = createElectiveList("electives\\"+degreeProgram+".csv")
			# self.electiveList = createElectiveList("../electives/"+degreeProgram+".csv")
		############################################
		if degreeProgram in Student.biodiv:
			self.department = "bio div"
			self.campus = "Miagao"
		elif degreeProgram in Student.cfos:
			self.department = "cfos"
			self.campus = "Miagao"
		elif degreeProgram in Student.cm:
			self.department = "CM"
			self.campus = "Iloilo City"
		elif degreeProgram in Student.dpsm:
			self.department = "dpsm"
			self.campus = "Miagao"
		elif degreeProgram in Student.chem:
			self.department = "chem"
			self.campus = "Miagao"
		elif degreeProgram in Student.humdiv:
			self.department = "hum div"
			self.campus = "Miagao"
		elif degreeProgram in Student.socscidiv:
			self.department = "socsci div"
			self.campus = "Miagao"
		elif degreeProgram in Student.sotech:
			self.department = "sotech"
			self.campus = "Miagao"

class Subject:
	def __init__(self, year, semester, courseName, courseType, units, leclab):
		self.year = year
		self.semester = semester
		self.courseName = courseName
		self.courseType = courseType
		self.units = units
		self.leclab = leclab

	def displaySubject(self):
		print ("Year : "+ self.year+ ", Semester: "+ self.semester+ ", Course Name: "+ self.courseName+ ", Subject Type: "+ self.courseType+ ", Units: "+ self.units+", Lec or Lab: "+self.leclab)

class ClassOffering:
	def __init__(self, year, semester, courseName, campus, leclab, section, units, instructor):
		self.year = year
		self.semester = semester
		self.courseName = courseName
		self.campus = campus
		self.leclab = leclab
		self.section = section
		self.units = units
		self.instructor = instructor

	def setSessions(self, sessions):
		self.sessions = sessions

	def displayClassOffering(self):
		print(self.year, self.semester, self.courseName, "Section", self.section, self.instructor, self.leclab)
		for session in self.sessions:
			session.displaySession()

class Elective:
	def __init__(self, courseName, courseTitle, units):
		self.courseName = courseName
		self.courseTitle = courseTitle
		self.units = units

def createElectiveList(pathname):
	ifile, reader = csvReader(pathname)
	subjects = []
	for row in reader:
		subject = Elective(row[0], row[1], row[2])
		subjects.append(subject)
	ifile.close()
	return subjects

class Session:
	def __init__(self, room, days, start, end):
		self.room = room
		self.days = days
		self.start = start
		self.end = end
	def setDays(self, days):
		self.days = days
	def setStart(self, start):
		self.start = start
	def setEnd(self, end):
		self.end = end
	def displaySession(self):
		print("\t",self.room, self.days, str(self.start)+"-"+str(self.end))

def csvReader(pathname):
	ifile = open(pathname, "rt", encoding="utf8", errors="ignore")
	reader = csv.reader(ifile)

	return ifile, reader

def csvWriteConstraint(pathname, constraints):
	ifile = open(pathname, "rt", encoding="utf8", errors="ignore")
	reader = csv.reader(ifile)
	constraint_names = [constraint.name.lower() for constraint in constraints]
	all_constraints = []
	for row in reader:
		constraint_name = row[0]
		included = 1
		violated = 1 if constraint_name.lower() in constraint_names else 0
		all_constraints.append([constraint_name, included, violated])
	ifile.close()

	ifile = open(pathname, "w", newline='')
	writer = csv.writer(ifile, delimiter=",")
	for constraint in all_constraints:
		writer.writerow(constraint)
	# for constraint in constraints:
	# 	writer.writerow([constraint.name])
	ifile.close()

def csvWriter(pathname, assignment):
	ifile = open(pathname, "w", newline='')
	writer = csv.writer(ifile, delimiter=",")
	# print(type(assignment[0]), assignment[0])
	# assignment = assignment[0]
	for key in assignment.keys():
		classoffering = assignment[key]
		s_output = ""
		for index in range(0,len(classoffering["sessions"])):
			session_output = ""
			if index != 0:
				session_output = "|"
			session = classoffering["sessions"][index]
			session_output += (session["room"]+","+session["days"]+","+str(session["start"])+","+str(session["end"]))
			s_output += session_output
		writer.writerow(
				[classoffering["year"],
				classoffering["semester"],
				classoffering["courseName"],
				classoffering["campus"],
				classoffering["leclab"],
				classoffering["section"],
				classoffering["units"],
				classoffering["instructor"],
				s_output]
			)
	ifile.close()

def createSubjectList(pathname):
	ifile, reader = csvReader(pathname)
	subjects = []
	rownum = 0
	for row in reader:
		subjectAttributes = []
		if rownum == 0:
			rownum += 1
			continue
		for col in row:
			attribute = col.strip().lower()
			subjectAttributes.append(attribute)
		if(len(subjectAttributes) < 6):
			subject = Subject(" ", " ", subjectAttributes[0], subjectAttributes[1], " ", " ")
		else:
			subject = Subject(subjectAttributes[0], subjectAttributes[1], subjectAttributes[2], subjectAttributes[3], subjectAttributes[4], subjectAttributes[5])
		subjects.append(subject)
		rownum += 1

	ifile.close()
	return subjects

def createClassesList(pathname):
	ifile, reader = csvReader(pathname)
	classofferings = []
	for row in reader:
		sessioncolumns = [5, 7, 8]
		needlower = [2, 4]
		subjectAttributes = []
		for col in range(len(row)):
			if col not in sessioncolumns and col not in needlower:
				subjectAttributes.append(row[col].strip())
			elif col in needlower:
				subjectAttributes.append(row[col].strip().replace(" ","").lower())
			else:
				splitted = row[col].split(", ")
				for index in range(1, len(splitted)):
					splitted[index] = splitted[index].strip()
				subjectAttributes.append(splitted)
		classofferings.append(subjectAttributes)
	classList = []
	for classoffering in classofferings:
		classList.append(createClassOffering(classoffering))

	ifile.close()
	return classList

def createTimeString(timeString):
	# morning = [7, 8, 9, 10, 11]
	# afternoon = [12, 1, 2, 3, 4, 5]
	hour, minute = splitTimeString(timeString)
	if hour >= 7 and hour <= 11:
		timeString = timeString+"AM"
	else:
		timeString = timeString+"PM"
	return timeString
	# parsedTime = datetime.strptime(timeString, "%I:%M%p")
	# return datetime.time(parsedTime)

def createTimeDecimal(timeString):
	hour, minute = splitTimeString(timeString)
	if hour < 7:
		hour += 12
	minute = minute/60
	return hour+minute

def splitTimeString(timeString):
	hour, minute = timeString.split(":")
	hour = int(hour)
	minute = int(minute)
	return hour, minute

def createClassOffering(classitem):
	classoffering = ClassOffering(classitem[0], classitem[1], classitem[2], classitem[3], classitem[4], classitem[6], classitem[9], classitem[11])
	room = classitem[5]
	days = classitem[7]
	time = classitem[8]
	sessions = []
	for index in range(len(room)):
		session = Session(room[index], days[index], "", "")
		try:
			start, end = time[index].split("-")
			start = createTimeDecimal(start)
			end = createTimeDecimal(end)
		except ValueError:
			start = None
			end = None
		session.setStart(start)
		session.setEnd(end)
		sessions.append(session)

	classoffering.setSessions(sessions)
	return classoffering

class ConstraintCSV:
	def __init__(self, meeting_time, no_class, musthave, mustnothave, maxstraight, maxdaily, subject, days, start, end, instructor, maxnum, priority):
		self.meeting_time = int(meeting_time)
		self.no_class = int(no_class)
		self.musthave = int(musthave)
		self.mustnothave = int(mustnothave)
		self.maxstraight = int(maxstraight)
		self.maxdaily = int(maxdaily)
		self.subject = subject
		self.days = days.upper()
		self.start = start
		self.end = end
		self.instructor = instructor
		self.maxnum = int(maxnum)
		self.priority = priority

def createConstraintsList(pathname):
	ifile, reader = csvReader(pathname)
	constraints = []
	rownum = 1
	for row in reader:
		if rownum == 1:
			rownum += 1
			continue
		conattrib = []
		for col in row:
			attribute = col.strip().lower()
			conattrib.append(attribute)
		constraint = ConstraintCSV(conattrib[0], conattrib[1], conattrib[2], conattrib[3], conattrib[4], conattrib[5], conattrib[6], conattrib[7], conattrib[8], conattrib[9], conattrib[10], conattrib[11], conattrib[12])
		constraints.append(constraint)
	ifile.close()
	return constraints

def createPreferredConstraintsList(pathname):
	ifile, reader = csvReader(pathname)
	constraints = []
	for row in reader:
		subject = row[0].strip().lower()
		constraint = ConstraintCSV(0, 0, 1, 0, 0, 0, subject, "", "", "", "", 0, "h")
		constraints.append(constraint)
	ifile.close()
	return constraints