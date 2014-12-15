<?php /* Smarty version Smarty-3.1.16, created on 2014-12-13 10:13:29
         compiled from "module_file_tpl:ModuleManager;newversionstab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:385498115548c03399352e2-66316300%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1cc29e9dd28c902a263ab666fbb21e1acaaac62' => 
    array (
      0 => 'module_file_tpl:ModuleManager;newversionstab.tpl',
      1 => 1340910694,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '385498115548c03399352e2-66316300',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'updatestxt' => 0,
    'message' => 0,
    'itemcount' => 0,
    'nametext' => 0,
    'vertext' => 0,
    'haveversion' => 0,
    'sizetext' => 0,
    'statustext' => 0,
    'items' => 0,
    'entry' => 0,
    'nvmessage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548c0339ad8624_41666927',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548c0339ad8624_41666927')) {function content_548c0339ad8624_41666927($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['updatestxt']->value)) {?>
<div class="information"><p><?php echo $_smarty_tpl->tpl_vars['updatestxt']->value;?>
</p></div>
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
			<th><?php echo $_smarty_tpl->tpl_vars['haveversion']->value;?>
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
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->name)===null||$tmp==='' ? '' : $tmp);?>
</td>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->version)===null||$tmp==='' ? '' : $tmp);?>
</td>
			<td><?php if (isset($_smarty_tpl->tpl_vars['entry']->value->haveversion)) {?><?php echo $_smarty_tpl->tpl_vars['entry']->value->haveversion;?>
<?php }?></td>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->size)===null||$tmp==='' ? '' : $tmp);?>
</td>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->status)===null||$tmp==='' ? '' : $tmp);?>
</td>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->dependslink)===null||$tmp==='' ? '' : $tmp);?>
</td>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->helplink)===null||$tmp==='' ? '' : $tmp);?>
</td>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['entry']->value->aboutlink)===null||$tmp==='' ? '' : $tmp);?>
</td>
		</tr>
	<?php if (isset($_smarty_tpl->tpl_vars['entry']->value->description)&&$_smarty_tpl->tpl_vars['entry']->value->description!='') {?>
		<tr class="<?php echo $_smarty_tpl->tpl_vars['entry']->value->rowclass;?>
">
                	<td>&nbsp;</td>
                	<td colspan="7"><?php echo $_smarty_tpl->tpl_vars['entry']->value->description;?>
</td>
	        </tr>
	<?php }?>
	 
<?php } ?>
	</tbody>
</table>
<?php } else { ?>
<p><?php echo $_smarty_tpl->tpl_vars['nvmessage']->value;?>
</p>
<?php }?>
<?php }} ?>
