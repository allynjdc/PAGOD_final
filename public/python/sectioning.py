import classes
import re
import numpy as np
def getDayValue(day):
	if day == "M":
		return 0
	elif day == "T":
		return 1
	elif day == "W":
		return 2
	elif day == "Th":
		return 3
	elif day == "F":
		return 4
	elif day == "S":
		return 5
	return 6

def listOfSlots():
	return list(np.arange(7, 19.25, .25, dtype="double"))

def removeDigits(string):
	return "".join(i for i in string if not i.isdigit())

def findSections(courseName, classOfferingList, electiveList, coursesTaken, campus="Miagao"):
	courseName, leclab = courseName.split("-")

	if leclab == "lab":
		return [classoffering for classoffering in classOfferingList if (courseName == classoffering.courseName and classoffering.leclab == "lab" and classoffering.campus==campus)]
	else:
		if "ge(" in courseName:
			courseName = removeDigits(courseName)
			subjectsTaken = [classoffering.courseName for classoffering in coursesTaken]
			############################################
			# return [classoffering for classoffering in classes.createClassesList("../csv/"+courseName+".csv") if (classoffering.courseName not in subjectsTaken and classoffering.campus==campus)]
			return [classoffering for classoffering in classes.createClassesList("csv\\"+courseName+".csv") if classoffering.courseName not in subjectsTaken]
			############################################
		elif "pe" in courseName:
			courseName = removeDigits(courseName)
			pe_2_sports = {"badminton": "7", "bowling": "14", "ballroomdance":"26", "basketballwomen":"1", "tabletennis":"10","swimming":"19", "volleyball":"5", "lawntennis":"9", "football":"3", "softball":"4", "popularballroomdance":"26", "internationalfolkdance":"27", "philippinefolkdance":"28", "basketball":"1", "baseball": "23"}
			pe_3_sports = {"advancedvolleyball": "5", "socialrecreation": "4", "advancedbadminton":"7", "advancedtabletennis": "10", "moderndance": "2", "camping": "6", "jazz": "3", "advancedlawntennis": "9"}
			pe_2_subjects_to_avoid = []
			pe_3_subjects_to_avoid = []
			for course in coursesTaken:
				if course.courseType == "pe":
					if course.courseName in pe_2_sports.keys():
						pe_2_subjects_to_avoid.append(pe_2_sports[course.courseName])
					elif course.courseName in pe_3_sports.keys():
						pe_3_subjects_to_avoid.append(pe_3_sports[course.courseName])
			output = [classoffering for classoffering in classOfferingList if (classoffering.courseName == "pe2" or classoffering.courseName == "pe3" and classoffering.campus==campus)]
			if len(pe_2_subjects_to_avoid) != 0:
				for sec in pe_2_subjects_to_avoid:
					regex = sec+".+"
					output = [classoffering for classoffering in output if not (re.match(regex, classoffering.section, re.M|re.I) and classoffering.courseName == "pe2"  and classoffering.campus==campus)]
			if len(pe_3_subjects_to_avoid) != 0:
				for sec in pe_3_subjects_to_avoid:
					regex = sec+".+"
					output = [classoffering for classoffering in output if not (re.match(regex, classoffering.section, re.M|re.I) and classoffering.courseName == "pe3"  and classoffering.campus==campus)]
			return output

		elif "elective" in courseName:
			courseName = removeDigits(courseName)
			elective_names = [elective.courseName for elective in electiveList]
			available_electives = [classoffering for classoffering in classOfferingList if (classoffering.courseName in elective_names  and classoffering.campus==campus)]
			electives_taken = [course.courseName for course in coursesTaken if course.courseType == "elective"]
			output = [elective for elective in available_electives if elective.courseName not in electives_taken]
			return output

		if len(courseName.split("_")) == 2:
			courseName = courseName.split("_")[0]
	return [classoffering for classoffering in classOfferingList if (courseName == classoffering.courseName and classoffering.leclab == "lec" and classoffering.campus==campus)]


def findDayIndices(slotList, start, end, day):
	if start != None or end != None:
		index1 = slotList.index(start)
		index2 = slotList.index(end)
		day_value = getDayValue(day)
		slotLength = len(slotList)
		index1 = (day_value * slotLength) + index1
		index2 = (day_value * slotLength) + index2
	else:
		index1 = 9999
		index2 = 9999
	return list(np.arange(index1, index2))

def checkCompleteness(assignments):
	for key in assignments.keys():
		if assignments[key] == None:
			return False
	if checkListConflict(assignments):
		return False
	return True

def checkListConflict(assignments):
	for key in assignments.keys():
		currList = assignments[key]
		# print(key, currList)
		currList = classOfferingToList(currList)
		for item in assignments.keys():
			if item == key:
				continue
			if checkConflict(currList, classOfferingToList(assignments[item])):
				return True
	return False

def checkConflict(list1, list2):
	return not set(list1).isdisjoint(list2)

def selectUnassignedVariable(assignments):
	for key in assignments.keys():
		if assignments[key] == None:
			return key

def orderDomainValues(name):
	sections = variable_domain[name]
	values = []
	for section in sections:
		sessions = section.sessions
		slotList = []
		for session in sessions:
			days = session.days.split(" ")
			for day in days:
				dayIndices = findDayIndices(listOfSlots(), session.start, session.end, day)
				slotList = slotList + dayIndices
		values.append(slotList)
	return values

def classOfferingToList(section):
	if section == None:
		return []
	sessions = section.sessions
	slotList = []
	for session in sessions:
		days = session.days.split(" ")
		for day in days:
			dayIndices = findDayIndices(listOfSlots(), session.start, session.end, day)
			slotList = slotList + dayIndices
	return slotList