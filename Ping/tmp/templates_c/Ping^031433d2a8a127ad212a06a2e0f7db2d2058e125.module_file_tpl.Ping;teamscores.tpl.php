<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:43
         compiled from "module_file_tpl:Ping;teamscores.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2125600915548f357b2bcee2-95616406%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '031433d2a8a127ad212a06a2e0f7db2d2058e125' => 
    array (
      0 => 'module_file_tpl:Ping;teamscores.tpl',
      1 => 1418137727,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '2125600915548f357b2bcee2-95616406',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'retrieve_teams' => 0,
    'retrieve_teams_autres' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'id' => 0,
    'equipe' => 0,
    'items' => 0,
    'entry' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f357b34cf35_63135443',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357b34cf35_63135443')) {function content_548f357b34cf35_63135443($_smarty_tpl) {?>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['retrieve_teams']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['retrieve_teams_autres']->value;?>
</p></div>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
</p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th><?php echo $_smarty_tpl->tpl_vars['id']->value;?>
</th>
		<th><?php echo $_smarty_tpl->tpl_vars['equipe']->value;?>
</th>
		<th>Niveau</th>
		<th>Compétition</th>
		<th>Nom court</th>
		<th colspan="4">Actions</th>
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
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->libequipe;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->libdivision;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->friendlyname;?>
</td>
<!--	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->view;?>
</td>-->
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->retrieve_poule_rencontres;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->classement;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
  </tr>
<?php } ?>
 </tbody>
</table>
<?php }?>

<?php }} ?>
