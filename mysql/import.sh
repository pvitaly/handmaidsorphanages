#! /bin/bash
# 
# Script for importing handmaids database dumps into a local mysql db

DB=wp_handmaids
USER=handmaids
PSWD=handmaids

if [ $# -ne 1 ]; then
	echo "USAGE: $0 [sql script]" && exit 0
fi

if ! [ -f $1 ]; then
	echo "Could not find file with name $1" && exit 1
fi

# ask for confirmation
echo "This operation will delete all data in your current MySQL WordPress database and replace it with the data in $1"
echo -n "Do you want to continue? (y/n)> "
read line

if [ $line == "y" -o  $line == "Y" ]; then
	#run the mysql command
	mysql -h localhost -u $USER -p${PSWD} $DB < $1

	if [ $? -ne 0 ]; then
		echo "Operation failed!" && exit 1
	else
		echo "Operation succeeded" && exit 0
	fi
else
	echo "Operation cancelled" && exit 0
fi
