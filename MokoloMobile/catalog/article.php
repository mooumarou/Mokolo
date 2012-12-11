<?php
require('includes/configure.php');
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');
?>

<div data-role="header" data-theme="b">
  <h1>MokoloMobile</h1>
  <a href="#" data-icon="home" data-iconpos="notext" id="intro" class="ui-btn-right">intro</a>
</div>


<div class="content-primary">
<!--  erste listview presentation du Produit -->
 <ul data-role="listview"  data-theme="b" data-dividertheme="b">

    <li>
        <img src="./img/2.jpg" width="75" height="75" alt="" />
         <h3>article name</h3>
         <p>Article preis</p>
         <p>Ort article</p>
         <p><button type="button" data-theme="b">Acheter</button></p>
      </li>
      
 </ul>
 
 <!--  zweite listview Description du produit -->
 <ul data-role="listview"  data-theme="b" data-dividertheme="b">
   <li> Description article </li>
 </ul>
 
 <!--  dritte listview Presentation des images -->
 <ul id="mycarousel" data-role="listview"  data-theme="b" data-dividertheme="b">
    <li><img src="./img/1.jpg" width="75" height="75" alt="" /></li>
    <li><img src="./img/11.jpg" width="75" height="75" alt="" /></li>
    <li><img src="./img/.10.jpg" width="75" height="75" alt="" /></li>
    <li><img src="./img/8.jpg" width="75" height="75" alt="" /></li>
 </ul>

</div>

<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>