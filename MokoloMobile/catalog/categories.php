

<?php
require('includes/configure.php');
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');

$children = 0;
$no_children = array();

function display_children($parent_id, $level) {
	global $children;
	global $no_children;
	
	$children_query = mm_db_query("select categories_id, categories_name from " . TABLE_CATEGORIES . " where parent_id = '" . $parent_id . "'");
	
	if($level > 0) {
		echo "<ul>\n";
	}
	
	while($children_row = mm_db_fetch_array($children_query)) {
		$children++;
		echo "<li>";
		echo $children_row['categories_name'];
		display_children($children_row['categories_id'], $level+1);
		echo "</li>";	
	}
	
	$child_product = display_products($parent_id);
	
	if($level > 0) {
		echo "</ul>\n";
	}
}

function display_products($parent_id) {
	$child_product = false;
	
	$product_query = mm_db_query("select p.products_id, p.products_description, p.products_quantity, p.products_date_added, p.products_status, p.products_name, p.products_image, p.products_price from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " pc where pc.categories_id = '" . $parent_id . "' and p.products_id = pc.products_id");
	while($products = mm_db_fetch_array($product_query)) {
		//display product
		echo "<li>";
		echo "<a href=''>";
		echo "<img src = 'assets/img/".$products['products_id'].".jpg' alt = ".$products['products_name']."/>";
		echo $products['products_name']."<br/>";
		echo $products['products_price']." €";
		echo "</a>";
		echo "</li>";
		$child_product = true;
	}
	return $child_product;
}
?>
<div data-role="header" data-theme="b">
		<h1>Categories</h1>
 		<a href="#" data-icon="home" data-iconpos="notext" id="intro" class="ui-btn-right">intro</a>
	</div>

	<div data-role="content" data-theme="c">

		<div class="content-secondary">
				<ul data-role="listview" data-theme="b" data-dividertheme="b">
				
				<?php 
					
					$first_level_categories_query = mm_db_query("select categories_id, categories_name from " . TABLE_CATEGORIES . " where parent_id = 0");
					
					while ($first_level_categories = mm_db_fetch_array($first_level_categories_query)) {
						echo "<li>".$first_level_categories['categories_name'];
						 display_children($first_level_categories['categories_id'], 1);
						 echo "</li>";
					}
				
				?>
				</ul>
		</div>

<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>