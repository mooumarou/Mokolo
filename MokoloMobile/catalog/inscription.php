<?php
require('includes/configure.php');
require('includes/application_top.php');
require(DIR_WS_INCLUDES . 'template_top.php');

    		  $name = mm_db_prepare_input($HTTP_POST_VARS['name']);
    		  $pseudo = mm_db_prepare_input($HTTP_POST_VARS['pseudo']);
    		  $password = mm_db_prepare_input($HTTP_POST_VARS['password']);
    		  $confirmation = mm_db_prepare_input($HTTP_POST_VARS['confirmation']);
    		  $cni_numero = mm_db_prepare_input($HTTP_POST_VARS['cni_numero']);
    		  $telephone = mm_db_prepare_input($HTTP_POST_VARS['tel']);
    		  $city = mm_db_prepare_input($HTTP_POST_VARS['city']);
    		  $email_address = mm_db_prepare_input($HTTP_POST_VARS['email_address']);
    		  if (ACCOUNT_DOB == 'true') $dob = mm_db_prepare_input($HTTP_POST_VARS['dob']);
    		  $code_de_verification = mm_db_prepare_input($HTTP_POST_VARS['code_de_verification']);
    		  if (isset($HTTP_POST_VARS['newsletter'])) {
    		  	$newsletter = mm_db_prepare_input($HTTP_POST_VARS['newsletter']);
    		  } else {
    		  	$newsletter = false;
    		  }
    		  
    		  $error = false;
    		  if (strlen($name) < ENTRY_NAME_MIN_LENGTH) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_NAME_ERROR);
    		  }
    		  if (ACCOUNT_DOB == 'true') {
    		  	if ((is_numeric(mm_date_raw($dob)) == false) || (@checkdate(substr(mm_date_raw($dob), 4, 2), substr(mm_date_raw($dob), 6, 2), substr(mm_date_raw($dob), 0, 4)) == false)) {
    		  		$error = true;
    		  
    		  		$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
    		  	}
    		  }
    		  if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
    		  } elseif (mm_validate_email($email_address) == false) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
    		  } else {
    		  	$check_email_query = mm_db_query("select count(*) as total from " . TABLE_CUSTOMERS . " where customers_email_address = '" . mm_db_input($email_address) . "'");
    		  	$check_email = mm_db_fetch_array($check_email_query);
    		  	if ($check_email['total'] > 0) {
    		  		$error = true;
    		  
    		  		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
    		  	}
    		  }
    		  if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_CITY_ERROR);
    		  }
    		  if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
    		  }
    		  if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
    		  } elseif ($password != $confirmation) {
    		  	$error = true;
    		  
    		  	$messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
    		  }
    		  if ($error == false) {
    		  	$sql_data_array = array('customers_name' => $name,
    		  								'customers_pseudo' => $pseudo,
    		  								'customers_password' => mm_encrypt_password($password),
    		                                'customers_telephone' => $telephone,
    		                                'customers_email_address' => $email_address,
    		                                'customers_newsletter' => $newsletter);
    		  
    		  	if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = mm_date_raw($dob);
    		  
    		  	mm_db_perform(TABLE_CUSTOMERS, $sql_data_array);
    		  
    		  	$customer_id = mm_db_insert_id();
    		  
    		  	$sql_data_array = array('customers_id' => $customer_id,
    		                                'entry_name' => $name,
    		                                'entry_pseudo' => $pseudo,
    		                                'entry_city' => $city);
    		  
    		  	mm_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
    		  
    		  	mm_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");
    		  
    		  	if (SESSION_RECREATE == 'True') {
    		  		mm_session_recreate();
    		  	}
    		  
    		  	$customer_pseudo= $pseudo;
    		  	mm_session_register('customer_id');
    		  	mm_session_register('customer_pseudo');
    		  
    		  	// reset session token
    		  	$sessiontoken = md5(mm_rand() . mm_rand() . mm_rand() . mm_rand());
    		  
    		  	// restore cart contents
    		  	$cart->restore_contents();
    		  
    		  	$email_text = sprintf(EMAIL_GREET_NONE, $pseudo);
    		  
    		  	$email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
    		  	mm_mail($name, $email_address, EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
    		  
    		  	mm_redirect(mm_href_link(FILENAME_CREATE_ACCOUNT_SUCCESS, '', 'SSL'));
    		  	
    		  	}
    		  	if(isset($HTTP_POST_VARS['submit'])){
    		  	
    		  		if($name && $pseudo && $password && $confirmation && $cni_numero && $telephone && $city){
    		  	
    		  			if($password==$confirmation){
    		  	
    		  				if(strlen($password)>4){
    		  					 
    		  					mm_db_query("INSERT INTO customers VALUES ('', '', '$pseudo', '$cni_numero', '', '$name', '', '$email_address', '$tel', '$password', '$city', )");
    		  					die('Inscription terminée');
    		  					 
    		  				}else echo "Le mot de passe est trop petit";
    		  	
    		  			}else echo "Les mots de passe ne sont pas identiques";
    		  				
    		  		}else echo "Veuillez entrer tous les champs suivis de l'étoile rouge";
    		  	}
?>
			 
			<div data-role="header" data-theme="b">
				<h1>Inscription</h1>
			</div>
			
			<div data-role="content" data-theme="c">
				<!--  <h3>Enregistrement</h3> -->	
				<!-- <div class="content-primary" id="page1"> -->
						<form action="inscription.php" method="post">
							<div data-role="fieldcontain" class="ui-hide-label">
					         <label for="name">Noms et Pr&#233;noms:</label> 
					         <input type="text" name="name" id="name" value="" placeholder="Noms et pr&#233;noms" /> *
							</div>
										
							<div data-role="fieldcontain" class="ui-hide-label">
					         <label for="pseudo">Pseudo:</label> 
					         <input type="text" name="pseudo" id="pseudo" value="" placeholder="Pseudo" /> *
							</div>
							
							<div data-role="fieldcontain" class="ui-hide-label">
					         <label for="confirmation">Mot de passe:</label> 
					         <input type="password" name="confirmation" id="confirmation" value="" placeholder="Mot de passe" /> *
							</div>
							
							<div data-role="fieldcontain" class="ui-hide-label">
					         <label for="password">Veuillez reprendre le mot de passe svp:</label>
					         <input type="password" name="password" id="password" value="" placeholder="Veuillez reprendre le mot de passe svp" /> *
							</div>
							
							<p><a href="#page2" data-role="button">Page suivante</a></p>
							
							<!-- le Bouton de retour sur le menu principal manque -->
							
						</form>
					<!--  </div> -->
				</div>
			
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>		
			<div data-role="page" id="page2" data-theme="c">
				<div data-role="header" data-theme="b">
					<h1>Inscription(Suite)</h1>
				</div>
				<div data-role="content" data-theme="c">
					<!--  <h3>Enregistrement(Suite)</h3> -->
					<form action="inscription.php" method="post">
						<div data-role="fieldcontain" class="ui-hide-label">
				         <label for="cni_numero">CNI-Num&#233;ro:</label>
				         <input type="number" name="cni_numero" id="cni_numero" value="" placeholder="CNI-Num&#233;ro" /> *
						</div>
						
						<div data-role="fieldcontain" class="ui-hide-label">
				         <label for="tel">Tel:</label>
				         <input type="tel" name="tel" id="tel" value="" placeholder="Tel" /> *
						</div>
						
						<div data-role="fieldcontain" class="ui-hide-label">
				         <label for="city">Ville:</label>
				         <input type="text" name="city" id="city" value="" placeholder="Ville" /> *
						</div>
						
						<div data-role="fieldcontain" class="ui-hide-label">
				         <label for="email_address">Email:</label>
				         <input type="email" name="email_address" id="email_address" value="" placeholder="Email" />
						</div>
						
						<div data-role="fieldcontain" class="ui-hide-label">
						 <fieldset data-role="controlgroup" data-type="horizontal">
						 <legend>Date de naissance:</legend>
				
						 <label for="select-choice-month">Month</label>
						 <select name="select-choice-month" id="select-choice-month">
							 <option>Month</option>
							 <option value="jan">Janvier</option>
							 <option value="feb">Fevrier</option>
							 <option value="mar">Mars</option>
							 <option value="apr">Avril</option>
							 <option value="may">Mai</option>
							 <option value="jun">Juin</option>
							 <option value="jul">Juillet</option>
							 <option value="aug">Ao&#251;t</option>
							 <option value="sep">Septembre</option>
							 <option value="oct">Octobre</option>
							 <option value="nov">November</option>
							 <option value="dec">December</option>
						 </select>
				
						 <label for="select-choice-day">Day</label>
						 <select name="select-choice-day" id="select-choice-day">
							 <option>Day</option>
							 <option value="1">1</option>
							 <option value="2">2</option>
							 <option value="3">3</option>
							 <option value="4">4</option>
							 <option value="5">5</option>
							 <option value="6">6</option>
							 <option value="7">7</option>
							 <option value="8">8</option>
							 <option value="9">9</option>
							 <option value="10">10</option>
							 <option value="11">11</option>
							 <option value="12">12</option>
							 <option value="13">13</option>
							 <option value="14">14</option>
							 <option value="15">15</option>
							 <option value="16">16</option>
							 <option value="17">17</option>
							 <option value="18">18</option>
							 <option value="19">19</option>
							 <option value="20">20</option>
							 <option value="21">21</option>
							 <option value="22">22</option>
							 <option value="23">23</option>
							 <option value="24">24</option>
							 <option value="25">25</option>
							 <option value="28">28</option>
							 <option value="29">29</option>
							 <option value="30">30</option>
							 <option value="31">31</option>
						 </select>
				
						 <label for="select-choice-year">Year</label>
						 <select name="select-choice-year" id="select-choice-year">
							 <option>Year</option>
							 <option value="1996">1996</option>
							 <option value="1995">1995</option>
							 <option value="1994">1994</option>
							 <option value="1993">1993</option>
							 <option value="1992">1992</option>
							 <option value="1991">1991</option>
							 <option value="1990">1990</option>
							 <option value="1989">1989</option>
							 <option value="1988">1988</option>
							 <option value="1987">1987</option>
							 <option value="1986">1986</option>
							 <option value="1985">1985</option>
							 <option value="1984">1984</option>
							 <option value="1983">1983</option>
							 <option value="1982">1982</option>
							 <option value="1981">1981</option>
							 <option value="1980">1980</option>
							 <option value="1979">1979-</option>
						 </select>
					 </fieldset>
					 </div>
					 
					 <p><a href="#page3" data-role="button">Page suivante</a></p>
					 
					 <p><a href="#page1" data-rel="back" data-role="button" data-inline="true" data-icon="back">Page pr&#233;c&#233;dente</a></p>
					 
				 </form>
		 	</div>
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>

		 <div data-role="page" id="page3">
		 	<div data-role="header" data-theme="b">
					<h1>Inscription(Suite et Fin)</h1>
			</div>
			<div data-role="content" data-theme="c">
					<!--  <h3>Enregistrement(Suite et Fin)</h3> -->
		 			<!--  <div class="content-primary" id="page3"> -->
				 	<form action="inscription.php" method="post">	
						<div data-role="fieldcontain">
						<label for="code_de_verification">Code de v&#233;rification:</label>
							<!-- la doit etre plac&#233; l'image -->
							<textarea name="code_de_verification" id="code_de_verification"></textarea>
						</div>
							
						<div data-role="fieldcontain">
						<label for="flip-b">J'accepte <a href="#">les Conditions d'utilisation</a></label>
							<select name="slider" id="flip-b" data-role="slider">
								<option value="no">Non</option>
								<option value="yes">Oui</option>
							</select> 
						</div>
						
						<div data-role="fieldcontain">
							<!--  <a href="index.php" data-role="button" data-inline="true">Annuler</a>
							<a href="index.php" data-role="button" data-theme="b" data-inline="true">Sauvegarder</a> -->
							
							<input type="submit" name="submit" data-role="button" value="valider" data-theme="b"/> 
						</div>
					</form>
			</div>
<?php
require(DIR_WS_INCLUDES . 'template_bottom.php');
?>
				