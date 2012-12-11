
<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
    <title>Mokolo Mobile</title>

	<!-- CDN Respositories: For production, replace lines above with these uncommented minified versions -->
	 <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />
	 <link rel="stylesheet" href="assets/css/carousel.css" />
	 <link rel="stylesheet" href="assets/css/index.css" />
	 <link rel="stylesheet" href="assets/css/styles.css" />
	 <script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	 <script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>
	 <script src="http://sorgalla.com/projects/jcarousel/lib/jquery.jcarousel.min.js"></script>
	 
  </head>
  
  <body onload="init();">
  <script type="text/javascript">
		$(document).bind("mobileinit", function(){
	  	$.mobile.page.prototype.options.addBackBtn = true;
	});
	</script>
	
	<script type="text/javascript">

		jQuery(document).ready(function() {
		    jQuery('#mycarousel').jcarousel({
		    	wrap: 'circular'
		    });
		});

</script>
  <div data-role="page" class="type-interior" data-theme="b" data-add-back-btn="false">

	
	
	
	
	