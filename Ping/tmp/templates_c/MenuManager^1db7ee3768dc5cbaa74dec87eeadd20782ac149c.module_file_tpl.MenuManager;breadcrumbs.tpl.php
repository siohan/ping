<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:37
         compiled from "module_file_tpl:MenuManager;breadcrumbs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1926745361548e84bdd29d15-06603964%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1db7ee3768dc5cbaa74dec87eeadd20782ac149c' => 
    array (
      0 => 'module_file_tpl:MenuManager;breadcrumbs.tpl',
      1 => 1347531020,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '1926745361548e84bdd29d15-06603964',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nodelist' => 0,
    'starttext' => 0,
    'node' => 0,
    'spanclass' => 0,
    'extraspanclass' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84bddd5265_43936734',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84bddd5265_43936734')) {function content_548e84bddd5265_43936734($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['nodelist']->value)) {?>
<div class="breadcrumb"><?php echo $_smarty_tpl->tpl_vars['starttext']->value;?>
:&nbsp;<?php  $_smarty_tpl->tpl_vars['node'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['node']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nodelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['node']->key => $_smarty_tpl->tpl_vars['node']->value) {
$_smarty_tpl->tpl_vars['node']->_loop = true;
?><?php if (isset($_smarty_tpl->tpl_vars['spanclass'])) {$_smarty_tpl->tpl_vars['spanclass'] = clone $_smarty_tpl->tpl_vars['spanclass'];
$_smarty_tpl->tpl_vars['spanclass']->value = 'crumb'; $_smarty_tpl->tpl_vars['spanclass']->nocache = null; $_smarty_tpl->tpl_vars['spanclass']->scope = 0;
} else $_smarty_tpl->tpl_vars['spanclass'] = new Smarty_variable('crumb', null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['extraspanclass'])) {$_smarty_tpl->tpl_vars['extraspanclass'] = clone $_smarty_tpl->tpl_vars['extraspanclass'];
$_smarty_tpl->tpl_vars['extraspanclass']->value = ''; $_smarty_tpl->tpl_vars['extraspanclass']->nocache = null; $_smarty_tpl->tpl_vars['extraspanclass']->scope = 0;
} else $_smarty_tpl->tpl_vars['extraspanclass'] = new Smarty_variable('', null, 0);?><?php if ($_smarty_tpl->tpl_vars['node']->value->current==true) {?><?php if (isset($_smarty_tpl->tpl_vars['extraspanclass'])) {$_smarty_tpl->tpl_vars['extraspanclass'] = clone $_smarty_tpl->tpl_vars['extraspanclass'];
$_smarty_tpl->tpl_vars['extraspanclass']->value = ' current'; $_smarty_tpl->tpl_vars['extraspanclass']->nocache = null; $_smarty_tpl->tpl_vars['extraspanclass']->scope = 0;
} else $_smarty_tpl->tpl_vars['extraspanclass'] = new Smarty_variable(' current', null, 0);?><?php }?><span class="<?php echo ($_smarty_tpl->tpl_vars['spanclass']->value).($_smarty_tpl->tpl_vars['extraspanclass']->value);?>
"><?php if ($_smarty_tpl->tpl_vars['node']->value->current==true) {?><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
&nbsp;<?php } elseif (($_smarty_tpl->tpl_vars['node']->value->url==''||$_smarty_tpl->tpl_vars['node']->value->url=='#')&&$_smarty_tpl->tpl_vars['node']->value->type!='sectionheader') {?>&raquo;&nbsp;<?php } elseif ($_smarty_tpl->tpl_vars['node']->value->type=='sectionheader') {?><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
&nbsp;<?php } else { ?><a href="<?php echo $_smarty_tpl->tpl_vars['node']->value->url;?>
" title="<?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
"><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
</a>&nbsp;<?php }?></span><?php } ?></div>
<?php }?><?php }} ?>
