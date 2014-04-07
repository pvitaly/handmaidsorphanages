<?php
/*
 * The template for the handmaids footer. Closes the div id="main" atag and the rest of the page.
 */
?>
<head>

</head>
<body>

<!..Facebook Like ..>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!... twitter ...>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>


</script>
<!.. google share..>
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
			</div> <!-- main div -->
			<table>
			<tr>
			

<!..Facebook Like ..>
    <td><div id="fb-root"></div></td>
    <td> <div class="fb-like" data-href="http://www.vitalypeker.com/handmaids/wordpress/" data-width="10" data-layout="button" data-action="like" data-show-faces="false" data-share="true"  ></div></td>
<!... twitter ...>
    <td height="25"><a href="https://twitter.com/share" class="twitter-share-button" data-text="Support Orphanes @ http://www.vitalypeker.com/handmaids/wordpress/" data-count="none">Tweet</a></td>

<td><div class="g-plus" data-action="share" data-annotation="none" ></div></td>

<!-- Place this tag after the last share tag. -->

		 </table>
<?php Timber::render('footer.twig'); ?>
               
	</div> <!-- page div -->
	
	
		<?php wp_footer(); ?> 	
		
		
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

