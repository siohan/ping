<?php /* Smarty version Smarty-3.1.16, created on 2014-12-13 10:13:30
         compiled from "module_file_tpl:ModuleManager;adminpanel.tpl" */ ?>
<?php /*%%SmartyHeaderCode:930643504548c033a513cc4-05435827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '265a11b2dcc91a358282412e190d23818b45a4d3' => 
    array (
      0 => 'module_file_tpl:ModuleManager;adminpanel.tpl',
      1 => 1396292508,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '930643504548c033a513cc4-05435827',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'header' => 0,
    'letters' => 0,
    'message' => 0,
    'itemcount' => 0,
    'nametext' => 0,
    'vertext' => 0,
    'sizetext' => 0,
    'statustext' => 0,
    'items' => 0,
    'entry' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548c033a5ea6b1_55247499',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548c033a5ea6b1_55247499')) {function content_548c033a5ea6b1_55247499($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['header']->value)) {?>
<h3><?php echo $_smarty_tpl->tpl_vars['header']->value;?>
</h3>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['letters']->value)) {?>
<p class="pagerows"><?php echo $_smarty_tpl->tpl_vars['letters']->value;?>
</p>
<?php }?>
<div style="clear:both;">&nbsp;</div>
<?php if (isset($_smarty_tpl->tpl_vars['message']->value)) {?>
<p class="pageerror"><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['itemcount']->value)&&$_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th width="20%"><?php echo $_smarty_tpl->tpl_vars['nametext']->value;?>
</th>
			<th><?php echo $_smarty_tpl->tpl_vars['vertext']->value;?>
</th>
			<th><?php echo $_smarty_tpl->tpl_vars['sizetext']->value;?>
</th>
			<th><?php echo $_smarty_tpl->tpl_vars['statustext']->value;?>
</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
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
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->version;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->size;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->status;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->dependslink;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->helplink;?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->aboutlink;?>
</td>
		</tr>
	<?php if (isset($_smarty_tpl->tpl_vars['entry']->value->description)&&$_smarty_tpl->tpl_vars['entry']->value->description) {?>
		<tr class="<?php echo $_smarty_tpl->tpl_vars['entry']->value->rowclass;?>
">
                	<td>&nbsp;</td>
                	<td colspan="6"><?php echo $_smarty_tpl->tpl_vars['entry']->value->description;?>
</td>
	        </tr>
	<?php }?>
	 
<?php } ?>
	</tbody>
</table>
<?php }?>
<?php }} ?>
