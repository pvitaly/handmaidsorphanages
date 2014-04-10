<?php
/*
 * The template for the handmaids footer. Closes the div id="main" atag and the rest of the page.
 */
?>

			</div> <!-- main div -->

			<!-- share tags (js libraries loaded after opening body tag) -->
			<ul id="shareTagList">
			
				<!-- Facebook Like -->
				<li>
					<div class="fb-like" data-href="<?php echo get_site_url(); ?>" data-width="10" data-layout="button" data-action="like" data-show-faces="false" data-share="true"  ></div>
				</li>
				
				<!-- twitter -->
				<li>
					<a href="https://twitter.com/share" class="twitter-share-button" data-text="Support Orphanages @ <?php echo get_site_url(); ?>" data-count="none">Tweet</a>
				</li>
				
				<!-- google+ -->
				<li>
					<div class="g-plus" data-action="share" data-annotation="none" >
				</li>
			
			</ul>

			
	<?php Timber::render('footer.twig'); ?>
               
			   </div> <!-- main-container div -->
			   
	</div> <!-- page div -->
	
	
	<?php wp_footer(); ?> 	
 
		
		
</body>

</html>

