<?php

# CMSMS - CMS Made Simple
#
# (c)2004-2013 by Ted Kulp (wishy@users.sf.net)
#
# This project's homepage is: http://cmsmadesimple.org
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
# Last version 1.9.2 30/01/2014 
# ------------

function smarty_cms_function_contact_form($params, &$template) { 

	$smarty = $template->smarty;
	// init
	$date_serveur = date("Y-m-d H:m:s"); // date du jour
	//Will be Eq to null or to Captcha instance.
    $captcha = getCaptchaInstance($params);
	//Will be Eq to null or to CmsMailer instance.
	$cmsmailer = getCmsMailerInstance($params);
// -------------------------- langue ------------------------------
	  //$lang = CmsNlsOperations::get_current_language(); echo "langue ==== ".$lang; Renvoi en-US par default, donc Détection directement dans le navigateur.
	if(!($langue = $smarty->get_template_vars('lang_parent'))) $langue = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2); 
	$lang = getTranslation($langue);
// ----------------------------------------------------------------
	
	if (empty($params['email'])){
		echo '<div class="formError">'.$lang[1].'</div>';
		return;
	}
	
	$to = $params['email'];
	$recaptcha = (!empty($params['recaptcha']) && ($params['recaptcha'] == TRUE || strtolower($params['recaptcha']) == 'true'));
	$style = (empty($params['style']) || $params['style'] !== "false" );
	
//Initialisation de tous les styles du plugin
	$styleLabel = '';
	$styleInput = '';
	$captchaStyle = '';
	$OKStyle = '';
	$errorsStyle = '';
	
	if($style) {
		$errorsStyle = 'style="font-weight: bold; color: red;"';
		$OKStyle = 'style="font-weight: bold;"';
		$captchaStyle = 'style="width: 350px; margin-bottom:1em; text-align: center;"';
		$styleLabel = 'style="font-weight: bold;"';
		$styleInput = 'style="width: 350px; border: solid 1px navy; display: block; margin-bottom: 7px;margin-top: 7px;"';
	}
//Messages erreur		
	$errors=$name=$email=$subject=$message = '';
	$bodymessage = '';
	if (!empty($params['subject_get_var']) && !empty($_GET[$params['subject_get_var']])) {
	    $subject = $_GET[$params['subject_get_var']];
	}
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if (!empty($_POST['name'])) $name =($_POST['name']); 
		if (!empty($_POST['email'])) $email = cfSanitize($_POST['email']);
		if (!empty($_POST['subject'])) $subject = ($_POST['subject']); 
		if (!empty($_POST['message'])) $message = $_POST['message'];

		$bodymessage.= " \r\n";
		$bodymessage = $lang[2].utf8_decode($name)."\r\n";	//Pr&eacute;nom et Nom
		$bodymessage.= $lang[3].($email)."\r\n\r\n";			
		$bodymessage.= $lang[4].utf8_decode($message)."\r\n";
		$bodymessage.= " \r\n";

		if (null != $captcha) {
			if (!empty($_POST['recaptcha_response_field'])) { 
				$captcha_resp = $_POST['recaptcha_response_field']; 
			}
		}

//Mail headers
		$name = utf8_decode($name); 	
		$extra = "From: $name <$email>\r\nReply-To: $email\r\n"; //jce
		
		if (empty($name)) $errors .= "\t\t<li>" . $lang[5] . "</li>\n";
		if (empty($email)) $errors .= "\t\t<li>" . $lang[6] . "</li>\n";
		elseif (!validEmail($email)) $errors .= "\t\t<li>" . $lang[7] . "</li>\n";
		if (empty($subject)) $errors .= "\t\t<li>" . $lang[8] . "</li>\n";
		if (empty($message)) $errors .= "\t\t<li>" . $lang[9] . "</li>\n";
		if (null != $captcha) {
		    if (empty($captcha_resp)) $errors .= "\t\t<li>" . $lang[10] . "</li>\n";
		    elseif (! ($captcha->checkCaptcha($captcha_resp))) $errors .= "\t\t<li>" . $lang[11] . "</li>\n";
		}
		
		if (!empty($errors)) {
			echo <<<HTML
			<div class="formError" $errorsStyle><ul>$errors</ul></div>
HTML;
		} else {
			$send = false;
			
			if(null != $cmsmailer) {
				  $tos = explode(',', $to);
				  foreach($tos as $to){
				  	$cmsmailer->AddAddress($to,$to);
				  }
				  $cmsmailer->SetBody(nl2br($bodymessage) . "<br/><p>".$lang[12].$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].$lang[13]." : ".$date_serveur.$lang[14]." : ".$_SERVER["REMOTE_ADDR"]." ".$lang[15]." : ".$_SERVER["HTTP_USER_AGENT"])."</p>";
				  $cmsmailer->IsHTML(true);
				  $cmsmailer->SetSubject(utf8_decode($subject));
				  $cmsmailer->SetFrom($email);
				  $cmsmailer->SetFromName($name);
				  $cmsmailer->AddReplyTo($email);
				  $cmsmailer->Send();
				  $send = true;
				  
			} else {
				$send = @mail(
					$to, 
					($subject), 
					($bodymessage) . "\n\n".$lang[12].$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].$lang[13]." : ".$date_serveur.$lang[14]." : ".$_SERVER["REMOTE_ADDR"]." ".$lang[15]." : ".$_SERVER["HTTP_USER_AGENT"], 
					$extra);
			}
		
			if($send == true){
				echo '<div class="formMessage"' . $OKStyle . '>'.$lang[16].'</div>' . "\n";		
			} else {
				echo '<div class="formError" ' . $errorsStyle . '>'.$lang[17].'</div>' . "\n";
			}
			
			return;
		}
	}
//-
    if (isset($_SERVER['REQUEST_URI']))  {
		$action = $_SERVER['REQUEST_URI'];
    } else {
		$action = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') {
			$action .= '?'.$_SERVER['QUERY_STRING'];
		}
    }

// Start Form  
	$html_name = htmlspecialchars($name);
	$html_email = htmlspecialchars($email);
	$html_subject = htmlspecialchars($subject);
	$html_message = htmlspecialchars($message);
	$base_url = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
    $base_url = htmlentities($base_url);

	echo <<<HTML
    <form action="{$base_url}" method="post" name="contactForm">
		<label for="name" title="{$lang[18]}" $styleLabel>* {$lang[19]} :</label>
		<input type="text" name="name" id="name" title="{$lang[18]}" value="$html_name" size="50" $styleInput />
			
		<label for="email" title="{$lang[20]}" $styleLabel>* {$lang[21]} :</label>
		<input type="text" name="email" id="email" title="{$lang[20]}" value="$html_email" size="50" $styleInput />

		<label for="subject" title="{$lang[22]}" $styleLabel>* {$lang[23]} :</label>	
		<input type="text" name="subject" id="subject" title="{$lang[22]}" value="$html_subject" size="50" $styleInput />
			
		<label for="message" title="{$lang[24]}" $styleLabel>* {$lang[25]} :</label>
		<textarea name="message" id="message" title="{$lang[24]}" cols="40" rows="10" $styleInput>$html_message</textarea>
HTML;

// Start captcha
	if (null != $captcha) {
		if(!$recaptcha) {
			echo <<<HTML
				<label for="recaptcha_response_field" title="{$lang[26]}" {$styleLabel}>* {$lang[26]} : </label><br />
				<input type="text" name="recaptcha_response_field"  id="recaptcha_response_field" title=" {$lang[26]}" value="" size="20" {$captchaStyle} />
HTML;
		}
			echo <<<HTML
				<div $captchaStyle>{$captcha->getCaptcha()}</div>
HTML;
	}
// End captcha

	echo <<<HTML
		<input type="submit" value="{$lang[28]}" /><!-- input type="reset" value="Effacer" / -->
		</form> <br /><small>* {$lang[29]}</small>
HTML;

// End form
}


function smarty_cms_help_function_contact_form() {
	?>
  <h2>NOTE : Ce plugin est obsol&egrave;te</h2>
    <p>Cette balise est obsol&egrave;te, et normalement supprim&eacute;e depuis la version CMS made simple 1.5. Elle est modifi&eacute;e et mise &agrave; diposition sous votre responsabilit&eacute; SANS AUCUNE GARANTIE. CMSMS recommande d&#039;utiliser le module <a href='http://dev.cmsmadesimple.org/projects/formbuilder/' target="_blank">Formbuilder</a> et son formulaire de contact.</p>	
	<h3>Que fait cette Balise ?</h3>
	<p>Affiche un formulaire de contact. Celui-ci peut &ecirc;tre utilis&eacute; par vos visiteurs pour envoyer un mail &agrave; une adresse sp&eacute;cifi&eacute;e.</p>
	<h3>Comment l'utiliser ?</h3>
	<p>Ins&eacute;rer la balise dans votre page comme : <code>{contact_form email='yourname@yourdomain.com'}</code><br />
	<br />Si vous souhaiter envoyer le mail &agrave; plusieurs adresses, s&eacute;parer ces adresses par une virgule.</p>
	<h3>Quels param&egrave;tres ?</h3>
	<ul>
		<li>email - l&#039;adresse ou le message sera envoy&eacute;.</li>
		<li><em>(option)</em> style='true' or 'false', utiliser les styles pr&eacute;d&eacute;finis.  Par D&eacute;faut est &agrave; 'true'.</li>
		<li><em>(option)</em> subject_get_var - Cha&icirc;ne de caract&egrave;res pour sp&eacute;cifier le sujet par d&eacute;faut.

               <p>Exemple:</p>
               <pre>{contact_form email='votre_nom@votredomaine.com' subject_get_var='subject'}</pre>
             <p>Puis appeler la page avec une url comme : /index.php?page=contact&amp;subject=test+mon_sujet ou contact.html&amp;subject=test+mon_sujet</p>
             <p>la Cha&icirc;ne de caract&egrave;res appara&icirc;t dans la case "Sujet du message" : "test mon_sujet"</p>
           </li>
		<li><em>(option)</em> captcha='true' or 'false', pour utiliser l'image Captcha (le module <a href='http://dev.cmsmadesimple.org/projects/captcha/' target="_blank">Captcha</a> doit &ecirc;tre install&eacute;). Par D&eacute;faut est &agrave; 'false'.</li>
		<li><em>(option)</em> recaptcha='true' or 'false', pour utiliser en association avec le param&egrave;tre pr&eacute;c&eacute;dent captcha. Permet d'utiliser correctement Recapcha dans votre formulaire. Inutilis&eacute; si l'option Captcha est d&eacute;j&agrave; &agrave; false</li>
		<li><em>(option)</em> cmsmailer='true' or 'false', pour utiliser le module CmsMailer au lieu d'utiliser la fonction basique mail() de PHP. CmsMailer doit &ecirc;tre correctement configur&eacute;. Par D&eacute;faut est &agrave; 'false'.</li>
	</ul>
	<h3>Ajout Fr</h3>	
	<ul>
		<li>Modification pour envoyer les accents pour la lecture des mails en iso-8859-1.</li>	
		<li>Traduction des termes anglais en fran&ccedil;ais par <a href='http://jc.etiemble.free.fr/' target="_blank">jce76350</a>.</li>
		<li>mise &agrave; jour pour Version CMS 1.10  13/06/2011.</li>
		<li>mise &agrave; jour pour Version CMS 1.10 + gestion de Captcha + gestion du cas sp&eacute;cifique recaptcha (recapcha='true') + gestion de l'envoi d'email avec CMSMailer si sp&eacute;cifi&eacute; (cmsmailer='true') 22/01/2012.</li>
		<li>Pour CmsMadesimple 1.11.x remplace  smarty_cms_function_contact_form par smarty_function_contact_form ( cause version Smarty 3.x )</li>
		<li>Remplace  ( $params, &$smarty ) par  ( $params, &$template ) Et ajout de  $smarty = $template->smarty; </li>
		<li>Remplace smarty_function_contact_form par smarty_cms_function_contact_form POUR ne PAS mettre en cache + Si config avec CmsMailer, le reply-to sera définit à l'adresse fournie dans le formulaire</li>	
		<li>le multi destinataire séparé par des virgules ne fonctionnait pas en mode CmsMailer</li>	
		<li>Correction potentiel XSS sur form action=....</li>
		<li>Ajout détection langue directement dans le navigateur : EN, ES ou Français par défaut par <a href='http://interphacepro.com/' target="_blank">jissey</a></li>	
	</ul>
	<br />	<?php
}

function smarty_cms_about_function_contact_form() {
	?>
	<p>Author: Brett Batie &lt;brett-cms@classicwebdevelopment.com&gt; &amp; Simon van der Linden &lt;ifmy@geekbox.be&gt; modif JCE76350</p>
	<p>Version : 1.9.2 30/01/2014  by JCE</p>
	<p>
	Change History:<br/>
        <ul>
        <li>l.2 : various improvements (errors handling, etc.)</li>
        <li>1.3 : added subject_get_var parameter (by elijahlofgren)</li>
        <li>1.4 : added captcha module support (by Dick Ittmann)</li>
		<li>1.5 : CmsMadesimple 1.10.x ready (by jce7350)</li>
		<li>1.6 : CmsMadesimple 1.10.x + Captcha + Recaptcha + cmsmailer (by bess)</li>
		<li>1.8 : 30/01/2012 CmsMadesimple 1.11.x remplace  smarty_cms_function_contact_form par smarty_function_contact_form ( cause version Smarty 3.x sur CMSms 1.11) (by jce76350)</li>
		<li>1.8.1 : 16/04/2012 remplace  ( $params, &$smarty ) par  ( $params, &$template ) Et ajout de $smarty = $template->smarty; (by jce76350)</li>
		<li>1.8.3 : 05/05/2012 CmsMadesimple 1.11.x - remplace smarty_function_contact_form par smarty_cms_function_contact_form POUR ne PAS mettre en cache (by jce76350) + Si config avec CmsMailer, le reply-to sera définit à l'adresse fournie dans le formulaire (by bess) </li>	
		<li>1.8.4 : le multi destinataire séparé par des virgules ne fonctionnait pas en mode CmsMailer(by bess)</li>	
		<li>1.8.5 : Correction potentiel XSS sur form action=.... (by bess)</li>
		<li>1.8.6 : Nettoyage des commentaires (by jce76350)</li>
		<li>1.9.0 : Ajout détection langue FR et EN (by jissey)</li>
		<li>1.9.1 : Ajout détection langue ES (by jissey)</li>
		<li>1.9.2 : Suppresion de utf8_decode sur utf8_decode($subject) (by JCE)</li>
        </ul>
	</p>
	<?php
}

//Return null if $params['captcha'] is not setted / is null / is false / is not true / if captcha module is not ready. Else return a captcha instance.
function getCaptchaInstance($params){
	
	if(empty($params['captcha']) || ($params['captcha'] !== TRUE && strtolower($params['captcha']) != 'true'))
		return null;
		
	$modops = cmsms()->GetModuleOperations();
	$captcha = $modops->get_module_instance('Captcha');
	return $captcha;
}

//Return null if $params['cmsmailer'] is not setted / is null / is false / is not true / if cmsmailer module is not ready. Else return a cmsmailer instance.
function getCmsMailerInstance($params){
	
	if(empty($params['cmsmailer']) || ($params['cmsmailer'] !== TRUE && strtolower($params['cmsmailer']) != 'true'))
		return null;
			
	$modops = cmsms()->GetModuleOperations();
	$cmsmailer = $modops->get_module_instance('CMSMailer');
	return $cmsmailer;	
}

function cfsanitize($content){
	return str_replace(array("\r", "\n"), "", trim($content));
}

function validEmail($email) {
	if (!preg_match("/^([\w|\.|\-|_]+)@([\w||\-|_]+)\.([\w|\.|\-|_]+)$/i", $email)) {
		return false;
		exit;
	}
	return true;
}
function getTranslation($langue) {
		switch ($langue) {
		case "en" :
		$lang[1] = "An email address must be specified to use this plugin.";
		$lang[2] = " Name and surname : ";
		$lang[3] = " Mail address : ";
		$lang[4] = " Message  : \r\n";
		$lang[5] = "Name and surname are required.";
		$lang[6] = "Email address is required.";
		$lang[7] = "Invalid email address.";
		$lang[8] = "Subject is required.";
		$lang[9] = "Message text is required.";
		$lang[10] = "Please, enter the text of the image.";
		$lang[11] = "The image text is invalid !";
		$lang[12] = "Sent by ";
		$lang[13] = " the";
		$lang[14] = " by IP";
		$lang[15] = " browser";
		$lang[16] = "Your message has succesfully been sent";
		$lang[17] = "Sorry the message can not be sent, an error occured !";
		$lang[18] = "Please enter your full name";
		$lang[19] = "Your full name";
		$lang[20] = "Please, enter your email address";
		$lang[21] = "Your email address";
		$lang[22] = "Please, enter the subject";
		$lang[23] = "Subject of the message";
		$lang[24] = "Please, enter your message";
		$lang[25] = "Your message";
		$lang[26] = "Enter the characters generated by the image";
		$lang[27] = "the characters generated by the image";
		$lang[28] = "Send";
		$lang[29] = "required fields";
		break;
		case "es" :
		$lang[1] = "este pluging necesita una dirección email para ser ejecutado";
		$lang[2] = " Nombre y Apellido ";
		$lang[3] = " Dirección email : ";
		$lang[4] = " Mensaje : \r\n";
		$lang[5] = "Por favor indica su nombre y apellido.";
		$lang[6] = "Por favor indica su dirección email.";
		$lang[7] = "Su dirección email no está valida.";
		$lang[8] = "Por favor indica el objeto.";
		$lang[9] = "Por favor escriba su mensaje.";
		$lang[10] = "Por favor escriba el texto contenido en la imagen";
		$lang[11] = "El texto contenido en la imagen no esta correcto!";
		$lang[12] = "Enviado por ";
		$lang[13] = " El";
		$lang[14] = " por IP";
		$lang[15] = " Navigator";
		$lang[16] = "Su mensaje ha sido enviado correctamente.";
		$lang[17] = "El mensaje no puede ser enviado, el servidor está fuera de servicio o un error está impidiendo el envio !";
		$lang[18] = "Por favor indica su nombre y apellido ";
		$lang[19] = "Nombre y apellido ";
		$lang[20] = "Por favor indica su dirección email";
		$lang[21] = "Su dirección email ";
		$lang[22] = "Por favor indica el objeto";
		$lang[23] = "Objeto del mensaje";
		$lang[24] = "Por favor escriba su mensaje";
		$lang[25] = "Su mensaje ";
		$lang[26] = "Por favor escriba el texto contenido en la imagen";
		$lang[27] = "El texto contenido en la imagen ";
		$lang[28] = "Enviar";
		$lang[29] = "Campos obligatorios";
		break;
		//-------------------- French by default --------------------------
		default : 
		$lang[1] = "Une adresse email doit etre sp&eacute;cifi&eacute;e pour utiliser ce pluging.";
		$lang[2] = " Prenom et Nom : ";
		$lang[3] = " Adresse mail : ";
		$lang[4] = " Message  : \r\n";
		$lang[5] = "Merci d'indiquer votre Pr&eacute;nom et Nom.";
		$lang[6] = "Merci d'indiquer votre adresse mail.";
		$lang[7] = "Votre adresse mail est non valide.";
		$lang[8] = "Merci d'indiquer votre sujet.";
		$lang[9] = "Merci de renseigner le texte de votre message.";
		$lang[10] = "Merci d'entrer le texte contenu dans l'image";
		$lang[11] = "Le texte contenu dans l'image n'est pas correct !";
		$lang[12] = "Emis par ";
		$lang[13] = " le";
		$lang[14] = " par IP";
		$lang[15] = " Navigateur";
		$lang[16] = "Votre message a bien &eacute;t&eacute; envoy&eacute;";
		$lang[17] = "D&eacute;sol&eacute; le message ne peut etre envoy&eacute;, le serveur est hors service ou une erreur interdit l'envoi !";
		$lang[18] = "Veuillez saisir votre Pr&eacute;nom et Nom";
		$lang[19] = "Votre Pr&eacute;nom et Nom";
		$lang[20] = "Veuillez saisir votre adresse email";
		$lang[21] = "Votre adresse mail";
		$lang[22] = "Veuillez saisir votre Sujet";
		$lang[23] = "Sujet du message";
		$lang[24] = "Veuillez saisir votre message";
		$lang[25] = "Votre message";
		$lang[26] = "Entrer les caract&egrave;res g&eacute;n&eacute;r&eacute;s par l'image";
		$lang[27] = "les caract&egrave;res  g&eacute;n&eacute;r&eacute;s par l'image";
		$lang[28] = "Envoyer";
		$lang[29] = "Champs obligatoires";
		}
return $lang;
}
# fin
?>
