#!/usr/bin/python
import csv
def filter(courseList, electivePath):
	ifile = open(electivePath, "rt", encoding="utf8", errors="ignore")
	electiveList = []
	reader = csv.reader(ifile)
	for row in reader:
		courseName = row[0]
		courseTitle = row[1]
		units = row[2]
		if courseName not in courseList:
			electiveList.append(row)

	ifile.close()
	return electiveList

def createCourseList(coursesPath):
	ifile = open(coursePath, "rt", encoding="utf8", errors="ignore")
	courseList = []
	reader = csv.reader(ifile)
	rownum = 0
	for row in reader:
		if rownum == 0:
			rownum += 1
			continue
		courseList.append(row[2])

	ifile.close()
	return courseList

if __name__ == '__main__':
	courses = ["ba cd", "ba cms", "ba hist", "ba lit", "ba polsci (double major)", "ba polsci (single major)", "ba psych", "ba socio", "bs accountancy", "bs appmath", "bs bio", " bs business administration", "bs chem", "bs chemical engineering", "bs cmsc", "bs econ", "bs fisheries", "bs food technology", "bs management", "bs ph", "bs stat"]
	for course in courses:
		print(course+": "+filter(createCourseList("../study plans/"+course), "../electives/"+course))