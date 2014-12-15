<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:48
         compiled from "module_file_tpl:Ping;adminprefs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:263398194548f35803cc6f9-55827287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf69d386deda4b9d9e678af7a1a8a647acc3fe85' => 
    array (
      0 => 'module_file_tpl:Ping;adminprefs.tpl',
      1 => 1414427805,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '263398194548f35803cc6f9-55827287',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'startform' => 0,
    'input_club_number' => 0,
    'input_phase' => 0,
    'input_saison_en_cours' => 0,
    'input_nom_equipes' => 0,
    'input_populate_calendar' => 0,
    'input_affiche_club_uniquement' => 0,
    'submit' => 0,
    'endform' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f3580406c08_04484671',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f3580406c08_04484671')) {function content_548f3580406c08_04484671($_smarty_tpl) {?><?php echo $_smarty_tpl->tpl_vars['startform']->value;?>

<fieldset>
<legend>Configuration principale</legend>
	<div class="pageoverflow">
		<p class="pagetext">Le numéro de votre club</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_club_number']->value;?>
</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Phase en cours:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_phase']->value;?>
</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">Saison en cours :</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_saison_en_cours']->value;?>
</p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Nom générique de vos équipes :</p>
			<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_nom_equipes']->value;?>
</p>
			</div>

</fieldset>
<fieldset>
	<legend>Autres options</legend>
	<div class="pageoverflow">
		<p class="pagetext">Le calendrier se remplit avec le résultats des poules (recommandé)</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_populate_calendar']->value;?>
</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Afficher les résultats de mes équipes uniquement</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_affiche_club_uniquement']->value;?>
</p>
	</div>
	</fieldset>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['submit']->value;?>
</p>
	</div>
<?php echo $_smarty_tpl->tpl_vars['endform']->value;?>

<?php }} ?>
