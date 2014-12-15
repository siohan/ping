<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:48
         compiled from "/Applications/MAMP/htdocs/rc1/admin/themes/OneEleven/templates/messages.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2000785887548f3580e64d09-27350584%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f88b03f45b03794bbc2a4f805c41fd48ed1e6c7' => 
    array (
      0 => '/Applications/MAMP/htdocs/rc1/admin/themes/OneEleven/templates/messages.tpl',
      1 => 1327915142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2000785887548f3580e64d09-27350584',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'error' => 0,
    'messages' => 0,
    'message' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f3580ee3588_57508485',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f3580ee3588_57508485')) {function content_548f3580ee3588_57508485($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['errors']->value)&&$_smarty_tpl->tpl_vars['errors']->value[0]!='') {?><aside class="message pageerrorcontainer" role="alert"><?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value) {
$_smarty_tpl->tpl_vars['error']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['error']->value) {?><p><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</p><?php }?><?php } ?></aside><?php }?><?php if (isset($_smarty_tpl->tpl_vars['messages']->value)&&$_smarty_tpl->tpl_vars['messages']->value[0]!='') {?><aside class="message pagemcontainer" role="status"><?php  $_smarty_tpl->tpl_vars['message'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['message']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messages']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['message']->key => $_smarty_tpl->tpl_vars['message']->value) {
$_smarty_tpl->tpl_vars['message']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['message']->value) {?><p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p><?php }?><?php } ?></aside><?php }?>
<?php }} ?>
