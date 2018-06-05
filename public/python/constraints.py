import sectioning
class Constraint:
	def __init__(self,variables,penalty=None):
		self.variables = variables
		self.penalty = penalty or float('inf') # hard, if penalty undefined
		self.name = 'undefined'

	# def __repr__(self):
	# 	return 'Constraint:%s' % self.name 

	def is_hard(self):
		return self.penalty == float('inf')
		
	def is_soft(self):
		return not self.is_hard()

	def get_assigned_values(self,solution):
		values = []
		for var in self.variables:
			if var in solution:
				values.append(solution[var])
		return values

class NoConflictsConstraint(Constraint):
	def test(self, solution):
		values = self.get_assigned_values(solution)
		if len(values) == len(self.variables):
			return not sectioning.checkListConflict(solution)
		else:
			return True


class MustHaveConstraint(Constraint):
	def __init__(self, variables, courseName, penalty=0):
		self.variables = variables
		self.courseName = courseName
		self.penalty = penalty or float('inf') # hard, if penalty undefined
		self.name = 'undefined'

	def test(self, solution):
		values = self.get_assigned_values(solution)
		courseNames = []
		for var in self.variables:
			classoffering = solution[var]
			courseNames.append(classoffering.courseName)
		return self.courseName in courseNames

class MustNotHaveConstraint(MustHaveConstraint):
	def test(self, solution):
		values = self.get_assigned_values(solution)
		courseNames = []
		for var in self.variables:
			classoffering = solution[var]
			courseNames.append(classoffering.courseName)
		if self.courseName in courseNames:
			return False
		return True

class StartEndConstraint(Constraint):
	def __init__(self,variables,days,start,end,penalty=0):
		self.variables = variables
		self.days = days
		self.start = start
		self.end = end
		self.penalty = penalty or float('inf') # hard, if penalty undefined
		self.name = 'undefined'

	def test(self, solution):
		values = self.get_assigned_values(solution)
		start = timeDecimal(self.start)
		end = timeDecimal(self.end)
		schedrestrict = modifiedDomainValues(self.days, start, end)
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			intersect_day_flag = False
			for session in sessions:
				days = session.days.split(" ")
				if not set(self.days).isdisjoint(days):
					intersect_day_flag = True
					break
			if intersect_day_flag:
				classofferingList = sectioning.classOfferingToList(classoffering)
				# check if multi-session
				if len(sessions) > 1:
					for session in sessions:
						days = session.days.split(" ")
						if not set(self.days).isdisjoint(days):
							classofferingcopy = classoffering
							classofferingcopy.setSessions([session])
							classofferingList = sectioning.classOfferingToList(classofferingcopy)
							# print(classofferingcopy.courseName,"intersection: ", intersection(schedrestrict, classofferingList),"timeslots: ", classofferingList)
							if intersection(schedrestrict, classofferingList) != classofferingList:
								return False
				else:
					if intersection(schedrestrict, classofferingList) != classofferingList:
						return False
		return True

class NoClassOnTimeConstraint(StartEndConstraint):
	def test(self, solution):
		values = self.get_assigned_values(solution)
		start = timeDecimal(self.start)
		end = timeDecimal(self.end)
		schedrestrict = modifiedDomainValues(self.days, start, end)
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			intersect_day_flag = False
			for session in sessions:
				days = session.days.split(" ")
				if not set(self.days).isdisjoint(days):
					intersect_day_flag = True
					break
			if intersect_day_flag:
				classofferingList = sectioning.classOfferingToList(classoffering)
				if not set(schedrestrict).isdisjoint(classofferingList):
					return False
		return True

class NoClassOnDayConstraint(Constraint):
	def __init__(self,variables,days,penalty=0):
		self.variables = variables
		self.days = days
		self.penalty = penalty or float('inf') # hard, if penalty undefined
		self.name = 'undefined'

	def test(self, solution):
		values = self.get_assigned_values(solution)
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			for session in sessions:
				days = session.days.split(" ")
				if not set(self.days).isdisjoint(days):
					return False
		return True

class MaxDaily(Constraint):
	def __init__(self, variables, limit, penalty=0):
		self.variables = variables
		self.limit = limit
		self.penalty = penalty or float('inf')
		self.name = 'undefined'

	def test(self, solution):
		day_counter = {"M":0, "T":0, "W":0, "Th":0, "F":0, "S":0}
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			for session in sessions:
				days = session.days.split(" ")
				for day in days:
					day_counter[day] += 1
		for key,value in day_counter.items():
			if value > self.limit:
				return False
		return True

class MaxStraightClasses(MaxDaily):
	def test(self, solution):
		day_dict = {"M":[], "T":[], "W":[], "Th":[], "F":[], "S":[]}
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			for session in sessions:
				days = session.days.split(" ")
				for day in days:
					day_dict[day].append((session.start, session.end))
		for key, sessions in day_dict.items():
			sorted_sessions = sorted(sessions)
			curr_straight = 1
			for index in range(0, len(sorted_sessions)-1):
				start1, end1 = sorted_sessions[index]
				start2, end2 = sorted_sessions[index+1]
				if end1 == start2:
					curr_straight += 1
					if curr_straight > self.limit:
						return False
				else:
					curr_straight = 1
			if curr_straight > self.limit:
				return False
		return True

class PreferredInstructor(Constraint):
	def __init__(self, instructor_dict, variables, prefInstructor, penalty=0):
		self.variables = variables
		self.instructor_dict = instructor_dict
		self.prefInstructor = prefInstructor
		self.penalty = penalty or float('inf')
		self.name = 'undefined'

	def test(self, solution):
		for var in self.variables:
			instructors = self.instructor_dict[var]
			possible_instructors = []
			preferred_instructor = self.prefInstructor
			for instructor in instructors:
				if len(instructor.split(" / ")) >= 2:
					mult_instructors = instructor.split(" / ")
					for mult_instructor in mult_instructors:
						possible_instructors.append(mult_instructor)
				else:
					possible_instructors.append(instructor)
			if preferred_instructor in possible_instructors:
				solution_instructor = solution[var].instructor.strip().lower()
				if len(solution_instructor.split(" / ")) < 2:
					if solution_instructor != preferred_instructor:
						return False
				else:
					solution_instructor = [x.strip() for x in solution_instructor.lower().split(" / ")]
					if preferred_instructor not in solution_instructor:
						return False
		return True



def timeDecimal(timeString):
	timeString, daytime = timeString.split(" ")
	hour, minute = timeString.split(":")
	hour = int(hour)
	minute = int(minute)
	if daytime == "pm" and hour != 12:
		hour += 12
	minute = minute/60
	return hour+minute

def modifiedDomainValues(days, start, end):
	slotList = []
	for day in days:
		dayIndices = sectioning.findDayIndices(sectioning.listOfSlots(), start, end, day)
		slotList = slotList + dayIndices
	return slotList

def intersection(list1, list2):
	list3 = [value for value in list1 if value in list2]
	return list3