#!/usr/bin/python
import csv

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
		elif degreeProgram in Student.cfos:
			self.department = "cfos"
		elif degreeProgram in Student.cm:
			self.department = "CM"
		elif degreeProgram in Student.dpsm:
			self.department = "dpsm"
		elif degreeProgram in Student.humdiv:
			self.department = "hum div"
		elif degreeProgram in Student.socscidiv:
			self.department = "socsci div"
		elif degreeProgram in Student.sotech:
			self.department = "sotech"

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

def createSubjectList(pathname):
	ifile = open(pathname, "rt", encoding="utf8")
	reader = csv.reader(ifile)
	subjects = []
	subjectAttributes = []
	rownum = 0
	for row in reader:
		if rownum == 0:
			rownum += 1
			continue
		for col in row:
			subjectAttributes.append(col.strip())
		if(len(subjectAttributes) < 6):
			subject = Subject(" ", " ", subjectAttributes[0].lower(), subjectAttributes[1].lower(), " ", " ")
		else:
			subject = Subject(subjectAttributes[0], subjectAttributes[1], subjectAttributes[2].lower(), subjectAttributes[3].lower(), subjectAttributes[4], subjectAttributes[5].lower())
		subjects.append(subject)
		subjectAttributes = []
		rownum += 1

	ifile.close()
	return subjects

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
	student = Student(3, 2, "bs chemical engineering", createSubjectList("../study plans/bs chemical engineering.csv"), createSubjectList("../csv/3rdYrChemEng.csv"))
	# print("_______Courses you already took________")
	# for courseTaken in student.coursesTaken:
	# 	courseTaken.displaySubject()
	# for course in student.allCourses:
	# 	course.displaySubject()
	# print(student.department)
	# print("_______Courses you need to take________")
	# neededcourses = coursesToTake(student.allCourses, student.coursesTaken)
	# for course in neededcourses:
	# 	course.displaySubject()
	neededcourses = coursesToTake(student.allCourses, student.coursesTaken)
	for neededcourse in neededcourses:
		neededcourse.displaySubject()
