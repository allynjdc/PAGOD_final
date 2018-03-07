#!/usr/bin/python
import csv
from datetime import datetime

class Student:
	biodiv = ["bs bio", "bs ph"]
	cfos = ["bs fisheries"]
	cm = ["bs accountancy", "bs business administration", "bs management"]
	dpsm = ["bs appmath", "bs chem", "bs cmsc", "bs stat"]
	humdiv = ["bs cms", "ba lit"]
	socscidiv = ["ba cd", "ba hist", "ba polsci (double major)", "ba polsci (single major)", "ba psych", "ba socio", "bs econ"]
	sotech = ["bs chemical engineering", "bs food technology"]
	def __init__(self, year, semester, degreeProgram, allCourses, coursesTaken):
		self.year = year
		self.semester = semester
		self.degreeProgram = degreeProgram
		self.allCourses = allCourses
		self.coursesTaken = coursesTaken
		if degreeProgram in Student.biodiv:
			self.department = "bio div"
			self.campus = "miagao"
		elif degreeProgram in Student.cfos:
			self.department = "cfos"
			self.campus = "miagao"
		elif degreeProgram in Student.cm:
			self.department = "CM"
			self.campus = "iloilocity"
		elif degreeProgram in Student.dpsm:
			self.department = "dpsm"
			self.campus = "miagao"
		elif degreeProgram in Student.humdiv:
			self.department = "hum div"
			self.campus = "miagao"
		elif degreeProgram in Student.socscidiv:
			self.department = "socsci div"
			self.campus = "miagao"
		elif degreeProgram in Student.sotech:
			self.department = "sotech"
			self.campus = "miagao"

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
	def __init__(self, academicYear, semester, courseName, campus, leclab, section, units, instructor):
		self.academicYear = academicYear
		self.semester = semester
		self.courseName = courseName
		self.campus = campus
		self.leclab = leclab
		self.section = section
		self.units = units
		self.instructor = instructor

	def setSessions(self, sessions):
		self.sessions = sessions

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
	# def displaySession(self):
	# 	print(self.room+" "+self.days+" "+self.start+"-"+self.end)

def csvReader(pathname):
	ifile = open(pathname, "rt", encoding="utf8", errors="ignore")
	reader = csv.reader(ifile)

	return ifile, reader

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
				splitted = row[col].split(",")
				for index in range(1, len(splitted)):
					splitted[index] = splitted[index].replace(" ","")
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
	# print(type(classoffering))
	return classoffering