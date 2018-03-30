#!/usr/bin/python
import sys
import csv
#import classes 



def csvReader(pathname):
	ifile = open(pathname, "rt", encoding="utf8", errors="ignore")
	reader = csv.reader(ifile)

	return ifile, reader

def validateUser(student_number, password):
	ifile, reader = csvReader("csv/Login.csv")
	user_data = []
	rownum = 0
	for row in reader:
		if rownum == 0:
			rownum += 1
			continue
		if student_number == row[0] and password == row[1]:
			for col in row:
				#user_data.append(col)
				print(col+"/")
			break		
		rownum += 1
	ifile.close()
	#print(list(user_data))

if __name__ == '__main__':
	validateUser(sys.argv[1],sys.argv[2])
