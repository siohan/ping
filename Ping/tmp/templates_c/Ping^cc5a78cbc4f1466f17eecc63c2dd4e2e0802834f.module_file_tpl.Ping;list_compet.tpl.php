<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:46
         compiled from "module_file_tpl:Ping;list_compet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1805493579548f357e274014-48218037%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc5a78cbc4f1466f17eecc63c2dd4e2e0802834f' => 
    array (
      0 => 'module_file_tpl:Ping;list_compet.tpl',
      1 => 1417731076,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '1805493579548f357e274014-48218037',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'formstart' => 0,
    'prompt_tour' => 0,
    'input_tour' => 0,
    'prompt_equipe' => 0,
    'input_equipe' => 0,
    'submitfilter' => 0,
    'hidden' => 0,
    'formend' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'id' => 0,
    'items' => 0,
    'entry' => 0,
    'createlink' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f357e3496f7_80554907',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357e3496f7_80554907')) {function content_548f357e3496f7_80554907($_smarty_tpl) {?><!--
<?php if (isset($_smarty_tpl->tpl_vars['formstart']->value)) {?>
<fieldset>
  <legend>Filtres</legend>
  <?php echo $_smarty_tpl->tpl_vars['formstart']->value;?>

  <div class="pageoverflow">
	<p class="pagetext">Id:</p>
    <p class="pageinput">Nom </p>
    <p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_tour']->value;?>
:</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_tour']->value;?>
 </p>
	<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_equipe']->value;?>
:</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_equipe']->value;?>
 </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['submitfilter']->value;?>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['hidden']->value)===null||$tmp==='' ? '' : $tmp);?>
</p>
  </div>
  <?php echo $_smarty_tpl->tpl_vars['formend']->value;?>

</fieldset>
<?php }?>
-->
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
</p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>	
  	<th><?php echo $_smarty_tpl->tpl_vars['id']->value;?>
</th>
  	<th>Nom</th>
  	<th>Code</th>
  	<th>Coefficient</th>
	<th>Indivs</th>
	<th colspan="2">Actions</th>
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
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->code_compet;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->coefficient;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->indivs;?>

	<?php if ($_smarty_tpl->tpl_vars['entry']->value->indivs==1) {?>
	|<?php echo $_smarty_tpl->tpl_vars['entry']->value->participe;?>
<?php }?></td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
  </tr>
<?php } ?>
 </tbody>
</table>
<?php }?>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['createlink']->value;?>
</p></div>
<?php }} ?>
