<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:38
         compiled from "content:content_en" */ ?>
<?php /*%%SmartyHeaderCode:989086302548e84be5f3315-70359117%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '62e936251e4799749e89fa9828a0ee7332eb5816' => 
    array (
      0 => 'content:content_en',
      1 => 1242202338,
      2 => 'content',
    ),
  ),
  'nocache_hash' => '989086302548e84be5f3315-70359117',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84be6414c6_44320243',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84be6414c6_44320243')) {function content_548e84be6414c6_44320243($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cms_version')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_version.php';
if (!is_callable('smarty_function_cms_versionname')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_versionname.php';
if (!is_callable('smarty_function_cms_selflink')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_selflink.php';
?><p> Félicitations ! Vous avez maintenant une installation entièrement fonctionnelle de CMS Made Simple et, vous êtes presque prêt pour commencer la construction votre propre site web.</p><p>Une premi&egrave;re chose cependant, v&eacute;rifier si vous avez bien la derni&egrave;re version de CMS Made Simple, si oui, alors vous pouvez passer au d&eacute;veloppement de votre site web !<br /> Si non t&eacute;l&eacute;charger l'archive de <a class="external" title="Fichiers CMS Made Simple" href="http://dev.cmsmadesimple.org/project/files/6" target="_blank">mise à jour</a>, installer les fichiers et cliquer <a href="install/upgrade.php" title="Mise &agrave; jour">ici</a></p><p>Vous avez choisi d'installer le contenu par défaut, vous verrez de nombreuses pages à lire. Vous devriez donc les lire soigneusement car ces pages sont consacrées à vous montrer les rudiments avant de commencer à travailler avec CMS Made Simple. Sur ces pages par exemple, les gabarits, les feuilles styles et de nombreuses caractéristiques de l'installation par défaut de CMS Made Simple sont décrites et démontrées. Vous pouvez en apprendre beaucoup sur la puissance de CMS Made Simple en lisant ces informations.</p><p>Il est préférable d'avoir des connaissances de base sur : les langages HTML, la gestion des CSS, les bases de données et la gestion d'un serveur.</p><p>Pour accéder au panneau d'administration vous devez vous connecter en tant qu'administrateur (avec le nom d'utilisateur et le mot de passe que vous avez entré pendant le processus d'installation à la console <a href="admin" title="Admin">administration</a>.<br /><br />Dans Administration du site/Paramètres globaux, confirmer les paramètres pour votre utilisation.</p> <h3>Apprendre CMS Made Simple <?php echo smarty_function_cms_version(array(),$_smarty_tpl);?>
 &quot;<?php echo smarty_function_cms_versionname(array(),$_smarty_tpl);?>
&quot;</h3><p>Déjà commencer par lire attentivement ces pages, vous trouverez une partie des réponses.<br />Vous pouvez vous renseigner sur la façon d'employer différents menus, gabarits, feuilles se style et autres extensions grâce à la communauté dans la <?php echo smarty_function_cms_selflink(array('ext'=>"http://wiki.cmsmadesimple.fr/wiki/Accueil",'title'=>"CMS Made Simple Documentation",'text'=>"documentation Wiki",'target'=>"_blank"),$_smarty_tpl);?>
, le forum <?php echo smarty_function_cms_selflink(array('ext'=>"http://forum.cmsmadesimple.org/index.php?board=10.0",'title'=>"CMS Made Simple .org",'text'=>"Forum",'target'=>"_blank"),$_smarty_tpl);?>
 ou <a class="external" title="forum.cmsmadesimple.fr" href="http://www.cmsmadesimple.fr/forum/" target="_blank">Aide francophone CMS Made Simple</a>, ou sur le tchat via <?php echo smarty_function_cms_selflink(array('ext'=>"http://www.cmsmadesimple.org/support/irc",'title'=>"Information about the CMS Made Simple IRC channel",'text'=>"IRC",'target'=>"_blank"),$_smarty_tpl);?>
 de CMS Made Simple. </p>Pendant l'installation si vous choisissez d'activer "Mots de passe Admin sécurisé", il n'y a absolument aucun moyen de réinitialiser les mots de passe Admin perdu autrement que par la fonctionnalité de récupération du mot de passe sur la page de connexion administration. Il est essentiel que vous associez donc une adresse email à chaque compte Admin pour recevoir par courrier  électronique ce nouveau mot de passe. <p>&nbsp;</p><h3>Licence </h3> <p>CMS Made Simple est un logiciel libre utilisant la licence <?php echo smarty_function_cms_selflink(array('ext'=>"http://www.gnu.org/licenses/licenses.html#GPL",'title'=>"General Public License",'text'=>"GPL",'target'=>"_blank"),$_smarty_tpl);?>
<br />Certains modules peuvent inclure des restrictions de licence.<br />Ne supprimez pas le Copyright (C) 2004-12 Ted Kulp dans les gabarits.</p><p><strong>Tutoriels : </strong><a class="external" title="Ressources Francisées Version NON officiellle" href="http://jc.etiemble.free.fr/abc/index.php/realisations/ressourcesfr" target="_blank">Ressources pour CMS Madesimple Francisées</a></p><p><strong>Notes de version :</strong><br />Il est conseillé d'utiliser maintenant <strong>PHP 5.3.x</strong><br />De nombreuses modifications ont été apportées avec cette version, lisez le <a href="doc/CHANGELOG.txt" title="CHANGELOG">changelog</a> et le fichier CMSMS_config_reference.pdf dans le dossier doc,  <?php echo smarty_function_cms_selflink(array('ext'=>"http://www.cmsmadesimple.fr/forum/",'title'=>"CMS Made Simple France Forum Fr",'text'=>"le forum",'target'=>"_blank"),$_smarty_tpl);?>
 et le <a href="http://wiki.cmsmadesimple.fr/wiki/Accueil" title="Wiki fr">WiKi</a> pour informations complémentaires. <br /> </p><?php }} ?>
