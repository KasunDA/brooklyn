<?php  
if ( in_category('blog') ) {
	include(TEMPLATEPATH . '/single-blog.php');
} else {
	include(TEMPLATEPATH . '/single-base.php');
}
?>
