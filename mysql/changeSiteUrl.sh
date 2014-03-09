#! /bin/bash
#
# changeSiteUrl.sh
# A script to change the base url of the WordPress site

DB=wp_handmaids
USER=handmaids
PSWD=handmaids

if [ $# -ne 1 ]; then
	echo "USAGE: $0 [base url without trailing slash]" && exit 0
fi

echo "changing WordPress siteurl to $1"

oldhost=$(mysql -h localhost -u $USER -p${PSWD} $DB -e "select option_value from wp_options where option_name = 'siteurl'" )
oldhost=$(echo $oldhost | perl -ne 'if ($_ =~ m/(http:\/\/\S+)/) { print $1; }')
if [ -e $oldhost ]; then
	echo "Could not find current host name. Operation aborted." && exit 1
fi

echo "previous siteurl: $oldhost"

#update the options values
script="update wp_options set option_value = '$1' where option_name = 'siteurl'; "
script=${script}"update wp_options set option_value = '$1' where option_name = 'home'; "

#update post guids
script=${script}"update wp_posts set guid = replace( guid, '$oldhost', '$1' ) where instr( guid, '$oldhost') = 1;"

#update urls in post content
srcipt=${script}"update wp_posts set post_content = replace( post_content,  '$oldhost', '$1') where post_content like '%$oldhost%';"

mysql -h localhost -u $USER -p${PSWD} $DB -e "$script"

if [ $? -eq 0 ]; then
	echo "operation succeeded. New siteurl is $1"
	exit 0
else
	echo "operation failed!"
	exit 1
fi
