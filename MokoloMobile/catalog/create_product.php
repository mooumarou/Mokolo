

<?php
require('includes/configure.php');
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div data-role="header" data-theme="b">
		<h1>Create Product</h1>
 		<a href="#" data-icon="home" data-iconpos="notext" id="intro" class="ui-btn-right">intro</a>
	</div>

	<div data-role="content" data-theme="c">

<form action="create_product_handle.php" method="POST">
	<div data-role="fieldcontain" class="ui-hide-label">
		<input type="text" name="articlename" id="articlename" value="" placeholder="Article Name"/>
		<input type="text" name="picturepath" id="picturepath" value="" placeholder="Picture"/>
		<div class="ui-block-b">
			<div data-role="button" onclick="selectPicture()">Pic from Library</div>
		</div>
		<span id="camera_status"></span><br>
		
		<div data-role="fieldcontain">
			<select name="select-choice-a" id="select-choice-a" data-native-menu="false">
				<option>Choose a Category</option>
				<option value="express">Express: next day</option>
				<option value="overnight">Overnight</option>
			</select>
		</div>
		<input type="text" name="price" id="price" value="" placeholder="Price"/>
		<input type="text" name="quantity" id="quantity" value="" placeholder="Quantity"/>
		<textarea cols="40" rows="20" name="descriptionarea" id="descriptionarea" placeholder="Description"></textarea>	
	</div>
	<div class="ui-body ui-body-b">
		<fieldset class="ui-grid-a">
			<div class="ui-block-a"><button type="submit" data-theme="d">Cancel</button></div>
			<div class="ui-block-b"><button type="submit" data-theme="a">Submit</button></div>
	    </fieldset>
	</div>
</form>

<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>