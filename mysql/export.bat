::Script for exporting handmaids database dumps

@echo off

set DB=wp_handmaids
set USER=handmaids
set PSWD=handmaids

if "%1" == "" (
	echo USAGE: %0 [output sql file name]
	goto end
)

set confirm=y
if exist %1 (
	set /P confirm="The file already exists. Do you want to overwrite it? (y/n) "
)

if not "%confirm%" == "y" (
	echo Operation cancelled
	goto end
) 

:: run mysqldump
echo Running mysqldump...
mysqldump -h localhost -u %USER% -p%PSWD% %DB% > %1


:end