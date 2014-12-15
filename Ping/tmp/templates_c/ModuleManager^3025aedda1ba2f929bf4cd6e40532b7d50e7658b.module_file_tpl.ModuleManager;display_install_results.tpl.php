<?php /* Smarty version Smarty-3.1.16, created on 2014-12-13 10:13:22
         compiled from "module_file_tpl:ModuleManager;display_install_results.tpl" */ ?>
<?php /*%%SmartyHeaderCode:407830280548c0332a79402-69600843%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3025aedda1ba2f929bf4cd6e40532b7d50e7658b' => 
    array (
      0 => 'module_file_tpl:ModuleManager;display_install_results.tpl',
      1 => 1311178880,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '407830280548c0332a79402-69600843',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mod' => 0,
    'queue_results' => 0,
    'item' => 0,
    'module_name' => 0,
    'return_link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548c0332b3abe7_32615822',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548c0332b3abe7_32615822')) {function content_548c0332b3abe7_32615822($_smarty_tpl) {?><h3><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('operation_results');?>
</h3>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['module_name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['queue_results']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['module_name']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
  <div class="pageoverflow">
    <?php if ($_smarty_tpl->tpl_vars['item']->value[0]) {?>
      
      <p class="pagetext" style="color: blue;"><?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
</p>
      <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</p>
    <?php } else { ?>
      
      <p class="pagetext" style="color: red;"><?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
</p>
      <br/>
      <p class="pageinput" style="color: red;"><?php echo $_smarty_tpl->tpl_vars['item']->value[1];?>
</p>
    <?php }?>
  </div>
<?php } ?>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['return_link']->value;?>
</p>
</div><?php }} ?>
