#! /bin/bash
# 
# Script for exporting handmaids database dumps

DB=wp_handmaids
USER=handmaids
PSWD=handmaids

if [ $# -ne 1 ]; then
	echo "USAGE: $0 [output sql file name]" && exit 0
fi

#ask for confirmation is the file already exists
if [ -f $1 ]; then
	echo -n "The file $1 already exists. Do you want to overwrite it? (y/n)> "
	read line

	if [ $line != "y" -a $line != "Y" ]; then
		echo "Operation cancelled" && exit 0
	fi
fi

# run the dump
echo "Running mysqldump..."
mysqldump -h localhost -u $USER -p${PSWD} $DB > $1

if [ $? -eq 0 ]; then
	echo "Operation succeeded" && exit 0
else
	echo "Operation failed!" && exit 1
fi
