#!/usr/bin/python
import csv
import os
def read_preferences(preference_directory):
	subject_dictionary = all_subjects_list("../csv/data.csv")
	preference_paths = os.listdir(preference_directory)
	for preference_path in preference_paths:
		ifile = open(preference_directory+"/"+preference_path, "rt", encoding="utf8", errors="ignore")
		reader = csv.reader(ifile)
		rownum = 1
		for preference in reader:
			if rownum == 1:
				rownum += 1
				continue
			year = preference[0]
			semester = preference[1]
			courseName = preference[2].strip().lower()
			courseType = preference[3]
			units = preference[4]
			leclab = preference[5]
			subject_dictionary[courseName] += 1
	return subject_dictionary

def all_subjects_list(subjects_path):
	ifile = open(subjects_path, "rt", encoding="utf8", errors="ignore")
	reader = csv.reader(ifile)
	subjects = []
	for subject in reader:
		subjects.append(subject[2].strip().replace(" ","").lower())
	subjects = set(subjects)
	subject_dictionary = {}
	for subject in subjects:
		subject_dictionary.setdefault(subject, 0)
	return subject_dictionary

def create_exportable(preference_directory):
	preferences_count = read_preferences(preference_directory)
	ifile = open(preference_directory+"/preference_count.csv", "w", newline="")
	writer = csv.writer(ifile, delimiter=",")
	for subject in preferences_count.keys():
		writer.writerow([
				subject,
				preferences_count[subject]
			])

if __name__ == '__main__':
	create_exportable("../preferences")