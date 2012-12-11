<?php
//boris
require('includes/configure.php');
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');
?>
		<div data-role="header" data-theme="b">
			<h1>MokoloMobile</h1>
	 		<a href="#" data-icon="home" data-iconpos="notext" id="intro" class="ui-btn-right">intro</a>
	</div>

			<div class="content-primary">
				<form action="form.php" method="get">
					<div data-role="fieldcontain">
					    <p>
						<!--<h1 id="jqm-logo"><img src="assets/img/Mokolomobilelogos2.jpg" alt="Mokolomobile Mobile shop" /></h1>-->
						<h3 id="jqm-logo"><img src="assets/img/mokolomobileteste2.png" alt="Mokolomobile Mobile shop" width="83" height="68" /></h3>
						 <input type="search" name="password" id="search" value="" />
						</p>
					</div>
				</form>	
					
					<p><a href="#connecter" data-role="button" data-transition="pop">Se Connecter</a></p>
						
					<p><a href="categories.php" data-role="button" data-transition="slide" data-prefetch>Categorie</a></p>	
					
					<p><a href="create_product.php" data-role="button" data-transition="slide" data-prefetch>Vendre</a></p>	
					
				<div class="content-primary">
				<div class="wrap">
					<div class="image_frame">
					
					<ul  data-role="listview" data-inset="true" data-theme="c" data-dividertheme="b">
						<li data-role="list-divider">Meilleur Article </li>
								<li>
									<marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();" >
								
										<img src="assets/img/1.jpg" width="145" height="160" class="image" alt="" />
										<img src="assets/img/10.jpg" width="145" height="160" class="image" alt="" />
										<img src="assets/img/11.jpg" width="145" height="160" class="image" alt="" />
										<img src="assets/img/12.jpg" width="145" height="160" class="image" alt="" />
								
									</marquee>
									</li>
					</ul>
						</div>
						</div>
				</div>
			</div>
			
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>
<?php 
if(isset($_POST['submit']))
{
	$pseudo = htmlspecialchars(trim($_POST['pseudo']));
	$password = htmlspecialchars(trim($_POST['password']));
	
	if($pseudo && $password)
	{
		
		$log = mm_db_query("SELECT * FROM customers = '$pseudo' AND password = '$password'");
		
		$rows =mysql_num_rows($log);
		
		if($rows==1)
		{
			die("Bienvenue");
		}else echo"Nom d'utilisateur ou Password Incorect";
	}else echo "Veuillez Saisir tous les Champs";
}

?>
<div data-role="page" id="connecter">
				<form action="index.php" method="post">
					<div data-role= "fieldcontain" class= "ui-hide-label">
						  <label for="pseudo">pseudo</label> <input type="text" name="name" value="" placeholder="pseudo" >
						  
						  <label for="password">Mot de Passe </label> <input type="password" name="password" value="" placeholder="Mot de Passe">
						  
					 	<input type="submit" value="entrer">
					 </div>	
					  <a href="inscription.php">s'enregistrer?</a> <a href="inscription.php"> mot de passe oublié?</a>
				</form>
							
			</div>