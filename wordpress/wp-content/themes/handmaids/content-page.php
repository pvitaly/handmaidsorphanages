<?php
/**
This is the standard template for displaying main page content
*/
?>
<div class="page-content">
<?php
while (have_posts()){
	the_post();
	the_content();
}
?>
</div>
