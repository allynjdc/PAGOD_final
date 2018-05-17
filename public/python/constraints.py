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
		return not self.courseName in courseNames

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
			intersect_flag = False
			for session in sessions:
				days = session.days.split(" ")
				if not set(self.days).isdisjoint(days):
					intersect_flag = True
					break
			if intersect_flag:
				classofferingList = sectioning.classOfferingToList(classoffering)
				if set(schedrestrict).isdisjoint(classofferingList):
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
			intersect_flag = False
			for session in sessions:
				days = session.days.split(" ")
				if not set(self.days).isdisjoint(days):
					intersect_flag = True
					break
			if intersect_flag:
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
	def __init__(self, variables, numClass, penalty=0):
		self.variables = variables
		self.numClass = numClass
		self.penalty = penalty or float('inf')
		self.name = 'undefined'

	def test(self, solution):
		day_counter = {"M":0, "T":0, "W":0, "Th":0, "F":0}
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			for session in sessions:
				days = session.days.split(" ")
				for day in days:
					day_counter[day] += 1
		for key,value in day_counter.items():
			if value > self.numClass:
				return False
		return True

class MaxStraightClasses(MaxDaily):
	def test(self, solution):
		day_dict = {"M":[], "T":[], "W":[], "Th":[], "F":[]}
		for var in self.variables:
			classoffering = solution[var]
			sessions = classoffering.sessions
			for session in sessions:
				days = session.days.split(" ")
				for day in days:
					day_dict[day].append((session.start, session.end))
		for key, sessions in day_dict.items():
			sorted_sessions = sorted(sessions)
			curr_num = 0
			for index in range(0, len(sorted_sessions)-1):
				start1, end1 = sorted_sessions[index]
				start2, end2 = sorted_sessions[index+1]
				if end1 == start2:
					curr_num += 1
			if curr_num > self.numClass:
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
			if self.prefInstructor in instructors:
				curr_instructor = solution[var].instructor
				if (len(curr_instructor.split(" / ")) < 2):
					if curr_instructor.strip().lower() != self.prefInstructor.strip().lower():
						return False
				else:
					curr_instructor = curr_instructor.strip().lower().split(" / ")
					if self.prefInstructor.strip().lower() not in curr_instructor:
						return False
		return True



def timeDecimal(timeString):
	timeString, daytime = timeString.split(" ")
	hour, minute = timeString.split(":")
	hour = int(hour)
	minute = int(minute)
	if daytime == "pm":
		hour += 12
	minute = minute/60
	return hour+minute

def modifiedDomainValues(days, start, end):
	slotList = []
	for day in days:
		dayIndices = sectioning.findDayIndices(sectioning.listOfSlots(), start, end, day)
		slotList = slotList + dayIndices
	return slotList