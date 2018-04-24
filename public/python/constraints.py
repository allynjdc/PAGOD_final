import sectioning
class Constraint:
	def __init__(self,variables,penalty=None):
		self.variables = variables
		self.penalty = penalty or float('inf') # hard, if penalty undefined
		self.name = 'undefined'

	def __repr__(self):
		return 'Constraint:%s' % self.name 

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
			return sectioning.checkListConflict(solution)
		else:
			return True