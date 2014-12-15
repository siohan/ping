<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:47
         compiled from "module_file_tpl:Ping;allsitmens.tpl" */ ?>
<?php /*%%SmartyHeaderCode:75290870548f357fe9c267-17593776%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7286ee31974e03e3a1f7c4ec37a755b8e9d87e86' => 
    array (
      0 => 'module_file_tpl:Ping;allsitmens.tpl',
      1 => 1416493939,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '75290870548f357fe9c267-17593776',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'itemcount' => 0,
    'itemsfound' => 0,
    'retrieveallsitmens' => 0,
    'formstart' => 0,
    'input_month' => 0,
    'input_player' => 0,
    'submitfilter' => 0,
    'hidden' => 0,
    'formend' => 0,
    'form2start' => 0,
    'items' => 0,
    'entry' => 0,
    'actionid' => 0,
    'actiondemasse' => 0,
    'submit_massaction' => 0,
    'form2end' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f3580064164_18158239',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f3580064164_18158239')) {function content_548f3580064164_18158239($_smarty_tpl) {?><div class="pageoptions"><p class="pageoptions"></p></div>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
 </p></div>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['retrieveallsitmens']->value;?>
</p></div>
<?php if (isset($_smarty_tpl->tpl_vars['formstart']->value)) {?>
<fieldset>
  <legend>Filtres</legend>
  <?php echo $_smarty_tpl->tpl_vars['formstart']->value;?>

  <div class="pageoverflow">
	<p class="pagetext">Mois:</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_month']->value;?>
 </p>
	<p class="pagetext">Joueur :</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_player']->value;?>
 </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['submitfilter']->value;?>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['hidden']->value)===null||$tmp==='' ? '' : $tmp);?>
</p>
  </div>
  <?php echo $_smarty_tpl->tpl_vars['formend']->value;?>

</fieldset>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<?php echo $_smarty_tpl->tpl_vars['form2start']->value;?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>ID</th>
		<th>Mois</th>
		<th>Joueur</th>
		<th>Points</th>
		<th>Rang nat</th>
		<th>Rang reg</th>
		<th>Rang dép</th>
		<th>Progression mens</th>
		<th colspan="2">Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
	</tr>
 </thead>
 <tbody>
<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['entry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value) {
$_smarty_tpl->tpl_vars['entry']->_loop = true;
?>
  <tr class="<?php echo $_smarty_tpl->tpl_vars['entry']->value->rowclass;?>
">
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->mois;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->joueur;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->points;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->clnat;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->rangreg;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->rangdep;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->progmois;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
	<td><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
sel[]" value="<?php echo $_smarty_tpl->tpl_vars['entry']->value->licence;?>
" class="select"></td>
  </tr>
<?php } ?>
 </tbody>
</table>
<!-- SELECT DROPDOWN -->
<div class="pageoptions" style="float: right;">
<br/><?php echo $_smarty_tpl->tpl_vars['actiondemasse']->value;?>
<?php echo $_smarty_tpl->tpl_vars['submit_massaction']->value;?>

  </div>
<?php echo $_smarty_tpl->tpl_vars['form2end']->value;?>

<?php }?>
<div class="pageoptions"><p class="pageoptions"></p></div>
<?php }} ?>
