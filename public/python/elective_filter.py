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
	ifile = open(electivePath, "w", newline="")
	writer = csv.writer(ifile, delimiter=",")
	for elective in electiveList:
		writer.writerow(elective)
	ifile.close()
	# rownum = 1
	# for elective in electiveList:
	# 	print(rownum, elective)
	# 	rownum += 1

def createCourseList(coursesPath):
	ifile = open(coursesPath, "rt", encoding="utf8", errors="ignore")
	courseList = []
	reader = csv.reader(ifile)
	rownum = 0
	for row in reader:
		if rownum == 0:
			rownum += 1
			continue
		courseList.append(row[2].lower().strip())

	ifile.close()
	return courseList

if __name__ == '__main__':
	# courses = ["ba cd", "ba cms", "ba hist", "ba lit", "ba polsci (double major)", "ba polsci (single major)", "ba psych", "ba socio", "bs accountancy", "bs appmath", "bs bio", " bs business administration", "bs chem", "bs chemical engineering", "bs cmsc", "bs econ", "bs fisheries", "bs food technology", "bs management", "bs ph", "bs stat"]
	# for course in courses:
	# 	print(course+": "+filter(createCourseList("../study plans/"+course+".csv"), "../electives/"+course+".csv"))
	# courses = ["ba cd", "ba psych", "ba hist", "ba polsci (single major)", "ba polsci (double major)", "ba socio"]
	# for course in courses:
	# 	filter(createCourseList("../study plans/ba cd.csv")+createCourseList("../study plans/bs econ.csv")+createCourseList("../study plans/ba hist.csv")+createCourseList("../study plans/ba psych.csv")+createCourseList("../study plans/ba polsci (single major).csv")+createCourseList("../study plans/ba socio.csv"), "../electives/"+course+".csv")
	filter(createCourseList("../study plans/bs food technology.csv"), "../electives/bs food technology.csv")