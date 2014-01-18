<?php
/**
This is the standard template for displaying main page content
*/
?>
<div class="page-content">
<?php
/* add links for any existing subpages */
$cur_page = Page::get_current_page();
if ($cur_page && $cur_page->has_children()){
	echo '<ul>';
	foreach ($cur_page->children as $child){
		$link = $child->get_permalink();
		echo "<li><a href='$link'>$child->title</a></li>";
	}
	echo '</ul>';
}

while (have_posts()){
	the_post();
	the_content();
}
?>
</div>
