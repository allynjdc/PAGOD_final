#!/usr/bin/python

from sectioning import *
from classes import *
from constraints import *

def createCourse(courseName, start, end, days, count):
	all_classofferings = createClassesList("../csv/data.csv")
	all_classofferings = [classoffering for classoffering in all_classofferings if (classoffering.semester == "2")]
	all_classofferings = [classoffering for classoffering in all_classofferings if (classoffering.courseName == courseName)]
	if start != None and end != None and days != None:
		new_classofferings = []
		schedrestrict = modifiedDomainValues(days, start, end)
		for classoffering in all_classofferings:
			sessions = classoffering.sessions
			intersect_days = False
			for session in sessions:
				session_days = session.days.split(" ")
				if not set(days).isdisjoint(session_days):
					intersect_days = True
					break
			if intersect_days:
				classofferingList = sectioning.classOfferingToList(classoffering)
				if intersection(schedrestrict, classofferingList) == classofferingList:
					new_classofferings.append(classoffering)
		all_classofferings = new_classofferings
	# for classoffering in all_classofferings:
	# 	classoffering.displayClassOffering()
	if count == 1:
		return all_classofferings[0]
	return all_classofferings

def test1():
	#should not return conflict (same day consecutive times)
	sol1 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = NoConflictsConstraint(sol1.keys())
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	print("Test Case 1, No Conflict:",c.test(sol1),"Expected: True")
	#should return conflict (same day same times)
	sol2 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych199.2": createCourse("psych199.2", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1)
	}
	c = NoConflictsConstraint(sol2.keys())
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	print("Test Case 2, No Conflict:",c.test(sol2), "Excpected: False")
	#should not return conflict (different day same time)
	sol3 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych195": createCourse("psych195", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["M", "Th"], 1)
	}
	c = NoConflictsConstraint(sol3.keys())
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	print("Test Case 3, No Conflict:",c.test(sol3), "Expected: True")
	#should return conflict (same day overlapping times)
	sol4 = {
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1),
		"math173": createCourse("math173", timeDecimal("12:00 pm"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = NoConflictsConstraint(sol4.keys())
	c.name = 'No Conflicts'
	c.penalty = float('inf')
	print("Test Case 4, No Conflict:",c.test(sol4), "Expected: False")

def test2():
	#should return true
	sol1 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = MustHaveConstraint(sol1.keys(), "pi100")
	c.name = 'Must Have PI 100'
	c.penalty = float('inf')
	print("Test Case 1, Has PI 100:",c.test(sol1),"Expected: True")
	#should return false
	sol2 = {
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1),
		"math173": createCourse("math173", timeDecimal("12:00 pm"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = MustHaveConstraint(sol2.keys(), "pi100")
	c.name = 'Must Have PI 100'
	c.penalty = float('inf')
	print("Test Case 2, Has PI 100:",c.test(sol2),"Expected: False")

def test3():
	#should return false
	sol1 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = MustNotHaveConstraint(sol1.keys(), "pi100")
	c.name = 'Must Not Have PI 100'
	c.penalty = float('inf')
	print("Test Case 1, Has no PI 100:",c.test(sol1),"Expected: False")
	#should return true
	sol2 = {
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1),
		"math173": createCourse("math173", timeDecimal("12:00 pm"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = MustNotHaveConstraint(sol2.keys(), "pi100")
	c.name = 'Must Not Have PI 100'
	c.penalty = float('inf')
	print("Test Case 2, Has no PI 100:",c.test(sol2),"Expected: True")

def test4():
	# should not return conflict (same day, timeslots are within set start and end times)
	sol1 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = StartEndConstraint(sol1.keys(), ["T", "F"], "8:30 am", "1:00 pm")
	c.name = 'Classes must start from 8:30 AM to 1:00 PM on T, F'
	c.penalty = float('inf')
	print("Test Case 1, Class In Range:",c.test(sol1),"Expected: True")
	# should return conflict (same day, timeslots are not within start and end times)
	sol2 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = StartEndConstraint(sol2.keys(), ["T", "F"], "10:00 am", "1:00 pm")
	c.name = 'Classes must start from 8:30 AM to 1:00 PM on T, F'
	c.penalty = float('inf')
	print("Test Case 2, Class In Range:",c.test(sol2),"Expected: False")
	# should not return conflict (different days from specified days)
	sol3 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = StartEndConstraint(sol3.keys(), ["M", "Th"], "8:30 am", "1:00 pm")
	c.name = 'Classes must start from 8:30 AM to 1:00 PM on M, Th'
	c.penalty = float('inf')
	print("Test Case 3, Class In Range:",c.test(sol3),"Expected: True")
	# should return conflict (some subjects are different from specified days, those included in specified days are not within start and end times)
	sol4 = {
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1)
	}
	c = StartEndConstraint(sol4.keys(), ["M", "Th"], "1:00 pm", "2:30 pm")
	c.name = 'Classes must start from 8:30 AM to 1:00 PM on M, Th'
	c.penalty = float('inf')
	print("Test Case 4, Class In Range:",c.test(sol4),"Expected: False")
	# should not return conflict (some subjects are different from specified days, those included in specified days are within start and end times)
	sol5 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1)
	}
	c = StartEndConstraint(sol5.keys(), ["T", "F"], "8:30 am", "1:00 pm")
	c.name = 'Classes must start from 8:30 AM to 1:00 PM on T, F'
	c.penalty = float('inf')
	print("Test Case 5, Class In Range:",c.test(sol5),"Expected: True")

def test5():
	# should not return conflict (same day, timeslots are not within set start and end times)
	sol1 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = NoClassOnTimeConstraint(sol1.keys(), ["T", "F"], "1:00 pm", "4:00 pm")
	c.name = 'No Classes from 8:30 AM to 1:00 PM on T, F'
	c.penalty = float('inf')
	print("Test Case 1, No Class on Time:",c.test(sol1),"Expected: True")
	# should return conflict (same day, timeslots are within set start and end times)
	sol2 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = NoClassOnTimeConstraint(sol2.keys(), ["T", "F"], "9:00 am", "12:00 pm")
	c.name = 'No Classes from 9:00 AM to 12:00 PM on T, F'
	c.penalty = float('inf')
	print("Test Case 2, No Class on Time:",c.test(sol2),"Expected: False")
	# should not return conflict (different days from specified days)
	sol3 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"mgt142": createCourse("mgt142", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = NoClassOnTimeConstraint(sol3.keys(), ["M", "Th"], "9:00 am", "12:00 pm")
	c.name = 'No Classes from 9:00 AM to 12:00 PM on M, Th'
	c.penalty = float('inf')
	print("Test Case 3, No Class on Time:",c.test(sol3),"Expected: True")
	# should not return conflict (some subjects are different from specified days, those included in specified days are not within start and end times)
	sol4 = {
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1)
	}
	c = NoClassOnTimeConstraint(sol4.keys(), ["M", "Th"], "9:00 am", "11:00 am")
	c.name = 'No Classes from 9:00 AM to 11:00 AM on M, Th'
	c.penalty = float('inf')
	print("Test Case 4, No Class on Time:",c.test(sol4),"Expected: True")
	# should return conflict (some subjects are different from specified days, those included in specified days are within start and end times)
	sol5 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1)
	}
	c = NoClassOnTimeConstraint(sol5.keys(), ["M", "Th"], "11:30 am", "1:00 pm")
	c.name = 'No Classes from 11:30 AM to 1:00 PM on M, Th'
	c.penalty = float('inf')
	print("Test Case 5, No Class on Time:",c.test(sol5),"Expected: False")

def test6():
	# should not return conflict (different days)
	sol1 = {
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = NoClassOnDayConstraint(sol1.keys(), ["M", "Th", "W"])
	c.name = 'No classes on M, W, Th'
	c.penalty = float('inf')
	print("Test Case 1, No Class on Day:", c.test(sol1), "Expected: True")
	# should return conflict (same days)
	c = NoClassOnDayConstraint(sol1.keys(), ["T", "F", "W"])
	c.name = 'No classes on T, W, F'
	c.penalty = float('inf')
	print("Test Case 2, No Class on Day:", c.test(sol1), "Expected: False")
	# should not return conflict (multi-session and no days are in conflict)
	sol2 = {
		"math54": createCourse("math54", None, None, None, 1)
	}
	c = NoClassOnDayConstraint(sol2.keys(), ["M", "Th"])
	c.name = 'No classes on M, Th'
	c.penalty = float('inf')
	print("Test Case 3, No Class on Day:", c.test(sol2), "Expected: True")
	# should return conflict (multi-session and one conflicts with one day/session)
	c = NoClassOnDayConstraint(sol2.keys(), ["M", "Th", "W"])
	c.name = 'No classes on M, W, Th'
	c.penalty = float('inf')
	print("Test Case 4, No Class on Day:", c.test(sol2), "Expected: False")

def test7():
	# should not return conflict (maximum number of daily classes <= limit)
	sol1 = {
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1),
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1),
		"psych101": createCourse("psych180", timeDecimal("11:30 am"), timeDecimal("1:00 pm"), ["T", "F"], 1)
	}
	c = MaxDaily(sol1.keys(), 4)
	c.name = "Maximum Number of Daily Classes must be 4"
	c.penalty = float('inf')
	print("Test Case 1, Number of daily classes is within limit:", c.test(sol1), "Expected: True")
	# should return conflict (maximum number of daily classes > limit)
	c = MaxDaily(sol1.keys(), 2)
	c.name = "Maximum Number of Daily Classes must be 2"
	c.penalty = float('inf')
	print("Test Case 2, Number of daily classes is within limit:", c.test(sol1), "Expected: False")

def test8():
	# should not return conflict (maximum number of straight classes <= limit)
	sol1 = {
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1),
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1)
	}
	# for var, value in sol1.items():
	# 	value.displayClassOffering()
	c = MaxStraightClasses(sol1.keys(), 3)
	c.name = "Maximum Number of Straight Classes must be 4"
	c.penalty = float('inf')
	print("Test Case 1, Number of straight classes is within limit:", c.test(sol1), "Expected: True")
	# should return conflict (maximum number of straight classes > limit)
	c = MaxStraightClasses(sol1.keys(), 2)
	c.name = "Maximum Number of Straight Classes must be 2"
	c.penalty = float('inf')
	print("Test Case 2, Number of straight classes is within limit:", c.test(sol1), "Expected: False")
	
def test9():
	# should return true (preferred instructor is not in the list of possible instructors)
	sol1 = {
		"math54": createCourse("math54", None, None, None, 1),
		"math55": createCourse("math55", None, None, None, 1),
		"pi100": createCourse("pi100", timeDecimal("8:30 am"), timeDecimal("10:00 am"), ["T", "F"], 1),
		"psych10": createCourse("psych10", timeDecimal("10:00 am"), timeDecimal("11:30 am"), ["T", "F"], 1)
	}
	# for var, value in sol1.items():
	# 	value.displayClassOffering()
	instructor_dict = create_instructor_dictionary(sol1)
	c = PreferredInstructor(instructor_dict, sol1.keys(), "ambita,a")
	c.name = "Preferred instructor is AMBITA,A"
	c.penalty = float('inf')
	print("Test Case 1, Preferred Instructor is in sched:", c.test(sol1), "Expected: True")
	# should return false (preferred instructor is in the list of possible instructors)
	c = PreferredInstructor(instructor_dict, sol1.keys(), "catinan,f")
	c.name = "Preferred instructor is CATINAN,F"
	c.penalty = float('inf')
	print("Test Case 2, Preferred Instructor is in sched:", c.test(sol1), "Expected: False")
	# should return true (preferred instructor is in the list of possible instructors and is chosen to be a teacher)
	c = PreferredInstructor(instructor_dict, sol1.keys(), "libo-on,j")
	c.name = "Preferred instructor is LIBO-ON,J"
	c.penalty = float('inf')
	print("Test Case 3, Preferred Instructor is in sched:", c.test(sol1), "Expected: True")
	# should return false (same as test case 2 but uses subjects with multiple teachers)
	sol2 = {
		"mgt101": createCourse("mgt101", None, None, None, 1),
		"fish237": createCourse("fish237", None, None, None, 1),
	}
	instructor_dict = create_instructor_dictionary(sol2)
	# print(instructor_dict)
	# for var, value in sol2.items():
	# 	value.displayClassOffering()
	c = PreferredInstructor(instructor_dict, sol2.keys(), "nual,s")
	c.name = "Preferred instructor is NUAL,S"
	c.penalty = float('inf')
	print("Test Case 4, Preferred Instructor is in sched:", c.test(sol2), "Expected: False")
	# should return true (same as test case 1 but uses subjects with multiple teachers)
	c = PreferredInstructor(instructor_dict, sol2.keys(), "ambita,a")
	c.name = "Preferred instructor is AMBITA,A"
	c.penalty = float('inf')
	print("Test Case 5, Preferred Instructor is in sched:", c.test(sol2), "Expected: True")
	# should return true (same as test case 3 but uses subjects with multiple teachers)
	c = PreferredInstructor(instructor_dict, sol2.keys(), "simora,r")
	c.name = "Preferred instructor is SIMORA,R"
	c.penalty = float('inf')
	print("Test Case 6, Preferred Instructor is in sched:", c.test(sol2), "Expected: True")

def create_instructor_dictionary(solution):
	instructor_dict = {}
	for key in solution.keys():
		instructors = []
		classofferings = createCourse(key, None, None, None, 0)
		for classoffering in classofferings:
			instructor = classoffering.instructor
			instructor = instructor.replace("Ñ", "ñ")
			instructor = instructor.strip().lower()
			instructors.append(instructor)
		instructors = set(instructors)
		instructor_dict[key] = list(instructors)
	return instructor_dict

if __name__ == '__main__':
	to_test = 9
	if to_test == 1:
		print("No Conflict Test")
		test1()
	if to_test == 2:
		print("Must Have Test")
		test2()
	if to_test == 3:
		print("Must Not Have Test")
		test3()
	if to_test == 4:
		print("Start End Test")
		test4()
	if to_test == 5:
		print("No Class On Time Test")
		test5()
	if to_test == 6:
		print("No Class On Day Test")
		test6()
	if to_test == 7:
		print("Max Daily Test")
		test7()
	if to_test == 8:
		print("Max Straight Classes Test")
		test8()
	if to_test == 9:
		print("Preferred Instructor Test")
		test9()