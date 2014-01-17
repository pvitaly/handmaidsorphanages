<?php
/*
 * The template for the handmaids footer. Closes the div id="main" atag and the rest of the page.
 */
?>

		</div> <!-- main div -->
	<div id="footer">
		<?php wp_footer(); ?> 	
	</div>
	</div> <!-- page div -->
</body>
<?php 

/* 
dump out all of the queries for debugging 
TODO: remove this!!
*/ 

echo "<!--\n";
echo "TOTAL QUERY COUNT: ", count($wpdb->queries) ,"\n\n";
var_dump($wpdb->queries); 
echo "\n-->";
?>

</html>

