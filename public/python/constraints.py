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

# class MaxStraightClasses(Constraint):


class MustHaveConstraint(Constraint):
	def __init__(self, variables, courseName, penalty=0):
		self.variables = variables
		self.courseName = courseName
		self.penalty = penalty or float('inf') # hard, if penalty undefined
		self.name = 'undefined'

	def test(self, solution):
		values = self.get_assigned_values(solution)
		courseNames = []
		# print(solution)
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