::Script for importing handmaids database dumps into a local mysql db

@echo off

set DB=wp_handmaids
set USER=handmaids
set PSWD=handmaids

if "%1" == "" (
	echo USAGE: %0 [sql script]
	goto end
)

if not exist %1 (
	echo Could not find file with name %1
	goto end
)

::ask for confirmation
echo This operation will delete all data in your current MySQL WordPress database and replace it with the data in %1
set /P confirm="Do you want to continue? (y/n) "

if "%confirm%" == "y" (
	:: run the mysql command
	mysql -h localhost -u %USER% -p%PSWD% %DB% < %1
) else (
	echo Operation cancelled
)

:end