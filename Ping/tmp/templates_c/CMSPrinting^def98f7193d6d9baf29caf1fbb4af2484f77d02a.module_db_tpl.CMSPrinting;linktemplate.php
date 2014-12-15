<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:38
         compiled from "module_db_tpl:CMSPrinting;linktemplate" */ ?>
<?php /*%%SmartyHeaderCode:808865693548e84be55e953-90738453%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'def98f7193d6d9baf29caf1fbb4af2484f77d02a' => 
    array (
      0 => 'module_db_tpl:CMSPrinting;linktemplate',
      1 => 1417101066,
      2 => 'module_db_tpl',
    ),
  ),
  'nocache_hash' => '808865693548e84be55e953-90738453',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'imgsrc' => 0,
    'linktext' => 0,
    'imgclass' => 0,
    'href' => 0,
    'class' => 0,
    'target' => 0,
    'more' => 0,
    'image' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84be5ec049_68565619',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84be5ec049_68565619')) {function content_548e84be5ec049_68565619($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['imgsrc']->value)) {?>
<?php $_smarty_tpl->_capture_stack[0][] = array('default', 'image', null); ob_start(); ?>
  <img src="<?php echo $_smarty_tpl->tpl_vars['imgsrc']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['linktext']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['linktext']->value;?>
" <?php if (isset($_smarty_tpl->tpl_vars['imgclass']->value)&&$_smarty_tpl->tpl_vars['imgclass']->value!='') {?>class="<?php echo $_smarty_tpl->tpl_vars['imgclass']->value;?>
"<?php }?> />
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['target']->value;?>
 <?php if (isset($_smarty_tpl->tpl_vars['more']->value)) {?><?php echo $_smarty_tpl->tpl_vars['more']->value;?>
<?php }?> rel="nofollow"><?php echo $_smarty_tpl->tpl_vars['image']->value;?>
</a>
<?php } else { ?>
<a href="<?php echo $_smarty_tpl->tpl_vars['href']->value;?>
" class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['target']->value;?>
 <?php if (isset($_smarty_tpl->tpl_vars['more']->value)) {?><?php echo $_smarty_tpl->tpl_vars['more']->value;?>
<?php }?> rel="nofollow"><?php echo $_smarty_tpl->tpl_vars['linktext']->value;?>
</a>
<?php }?>
<?php }} ?>
