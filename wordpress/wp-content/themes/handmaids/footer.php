<?php
/*
 * The template for the handmaids footer. Closes the div id="main" atag and the rest of the page.
 */
?>

			</div> <!-- main div -->
         </div> <!-- main-container div -->
<?php Timber::render('footer.twig'); ?>
               
	</div> <!-- page div -->
	
		<?php wp_footer(); ?> 	
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

</body>
</html>

