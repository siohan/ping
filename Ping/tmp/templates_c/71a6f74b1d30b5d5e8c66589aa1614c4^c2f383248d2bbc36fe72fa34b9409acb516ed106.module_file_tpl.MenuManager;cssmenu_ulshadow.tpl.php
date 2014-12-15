<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:37
         compiled from "module_file_tpl:MenuManager;cssmenu_ulshadow.tpl" */ ?>
<?php /*%%SmartyHeaderCode:631929633548e84bdab3a15-75392980%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c2f383248d2bbc36fe72fa34b9409acb516ed106' => 
    array (
      0 => 'module_file_tpl:MenuManager;cssmenu_ulshadow.tpl',
      1 => 1319355140,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '631929633548e84bdab3a15-75392980',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'menuparams' => 0,
    'count' => 0,
    'nodelist' => 0,
    'node' => 0,
    'number_of_levels' => 0,
    'classes' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84bdd07729_08012077',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84bdd07729_08012077')) {function content_548e84bdd07729_08012077($_smarty_tpl) {?><?php if (!is_callable('smarty_function_repeat')) include '/Applications/MAMP/htdocs/rc1/plugins/function.repeat.php';
?>

<?php if (isset($_smarty_tpl->tpl_vars['number_of_levels'])) {$_smarty_tpl->tpl_vars['number_of_levels'] = clone $_smarty_tpl->tpl_vars['number_of_levels'];
$_smarty_tpl->tpl_vars['number_of_levels']->value = 10000; $_smarty_tpl->tpl_vars['number_of_levels']->nocache = null; $_smarty_tpl->tpl_vars['number_of_levels']->scope = 0;
} else $_smarty_tpl->tpl_vars['number_of_levels'] = new Smarty_variable(10000, null, 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['menuparams']->value['number_of_levels'])) {?>
  <?php if (isset($_smarty_tpl->tpl_vars['number_of_levels'])) {$_smarty_tpl->tpl_vars['number_of_levels'] = clone $_smarty_tpl->tpl_vars['number_of_levels'];
$_smarty_tpl->tpl_vars['number_of_levels']->value = $_smarty_tpl->tpl_vars['menuparams']->value['number_of_levels']; $_smarty_tpl->tpl_vars['number_of_levels']->nocache = null; $_smarty_tpl->tpl_vars['number_of_levels']->scope = 0;
} else $_smarty_tpl->tpl_vars['number_of_levels'] = new Smarty_variable($_smarty_tpl->tpl_vars['menuparams']->value['number_of_levels'], null, 0);?>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['count']->value>0) {?>
<div id="menuwrapper">
<ul id="primary-nav">
<?php  $_smarty_tpl->tpl_vars['node'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['node']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nodelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['node']->key => $_smarty_tpl->tpl_vars['node']->value) {
$_smarty_tpl->tpl_vars['node']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['node']->value->depth>$_smarty_tpl->tpl_vars['node']->value->prevdepth) {?>
  <?php echo smarty_function_repeat(array('string'=>'<ul class="unli">','times'=>$_smarty_tpl->tpl_vars['node']->value->depth-$_smarty_tpl->tpl_vars['node']->value->prevdepth),$_smarty_tpl);?>

<?php } elseif ($_smarty_tpl->tpl_vars['node']->value->depth<$_smarty_tpl->tpl_vars['node']->value->prevdepth) {?>
  <?php echo smarty_function_repeat(array('string'=>'</li><li class="separator once" style="list-style-type: none;">&nbsp;</li></ul>','times'=>$_smarty_tpl->tpl_vars['node']->value->prevdepth-$_smarty_tpl->tpl_vars['node']->value->depth),$_smarty_tpl);?>

  </li>
  <?php } elseif ($_smarty_tpl->tpl_vars['node']->value->index>0) {?></li>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['node']->value->parent==true||$_smarty_tpl->tpl_vars['node']->value->current==true) {?>
  <?php if (isset($_smarty_tpl->tpl_vars['classes'])) {$_smarty_tpl->tpl_vars['classes'] = clone $_smarty_tpl->tpl_vars['classes'];
$_smarty_tpl->tpl_vars['classes']->value = 'menuactive'; $_smarty_tpl->tpl_vars['classes']->nocache = null; $_smarty_tpl->tpl_vars['classes']->scope = 0;
} else $_smarty_tpl->tpl_vars['classes'] = new Smarty_variable('menuactive', null, 0);?>
  <?php if ($_smarty_tpl->tpl_vars['node']->value->parent==true) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['classes'])) {$_smarty_tpl->tpl_vars['classes'] = clone $_smarty_tpl->tpl_vars['classes'];
$_smarty_tpl->tpl_vars['classes']->value = 'menuactive menuparent'; $_smarty_tpl->tpl_vars['classes']->nocache = null; $_smarty_tpl->tpl_vars['classes']->scope = 0;
} else $_smarty_tpl->tpl_vars['classes'] = new Smarty_variable('menuactive menuparent', null, 0);?>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['node']->value->children_exist==true&&$_smarty_tpl->tpl_vars['node']->value->depth<$_smarty_tpl->tpl_vars['number_of_levels']->value) {?>
    <?php if (isset($_smarty_tpl->tpl_vars['classes'])) {$_smarty_tpl->tpl_vars['classes'] = clone $_smarty_tpl->tpl_vars['classes'];
$_smarty_tpl->tpl_vars['classes']->value = ($_smarty_tpl->tpl_vars['classes']->value).(' parent'); $_smarty_tpl->tpl_vars['classes']->nocache = null; $_smarty_tpl->tpl_vars['classes']->scope = 0;
} else $_smarty_tpl->tpl_vars['classes'] = new Smarty_variable(($_smarty_tpl->tpl_vars['classes']->value).(' parent'), null, 0);?>
  <?php }?>
  <?php if ($_smarty_tpl->tpl_vars['node']->value->type=='sectionheader') {?>
    <li class="<?php echo $_smarty_tpl->tpl_vars['classes']->value;?>
"><a class="<?php echo $_smarty_tpl->tpl_vars['classes']->value;?>
"><span class="sectionheader"><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
</span></a>
  <?php } else { ?>
    <li class="<?php echo $_smarty_tpl->tpl_vars['classes']->value;?>
"><a class="<?php echo $_smarty_tpl->tpl_vars['classes']->value;?>
"
  <?php }?>
<?php } elseif ($_smarty_tpl->tpl_vars['node']->value->type=='sectionheader'&&$_smarty_tpl->tpl_vars['node']->value->haschildren==true) {?>
  <li><a ><span class="sectionheader"><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
</span></a>
<?php } elseif ($_smarty_tpl->tpl_vars['node']->value->type=='sectionheader') {?>
  <li><a ><span class="sectionheader"><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
</span></a>
<?php } elseif ($_smarty_tpl->tpl_vars['node']->value->type=='separator') {?>
  <li style="list-style-type: none;"> <hr class="menu_separator" />
<?php } elseif ($_smarty_tpl->tpl_vars['node']->value->children_exist==true&&$_smarty_tpl->tpl_vars['node']->value->depth<$_smarty_tpl->tpl_vars['number_of_levels']->value&&$_smarty_tpl->tpl_vars['node']->value->type!='sectionheader'&&$_smarty_tpl->tpl_vars['node']->value->type!='separator') {?>
  <li class="menuparent"><a class="menuparent" 
<?php } else { ?>
  <li>
  <a 
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['node']->value->type!='sectionheader'&&$_smarty_tpl->tpl_vars['node']->value->type!='separator') {?>
<?php if ($_smarty_tpl->tpl_vars['node']->value->target) {?>target="<?php echo $_smarty_tpl->tpl_vars['node']->value->target;?>
" <?php }?>
href="<?php echo $_smarty_tpl->tpl_vars['node']->value->url;?>
"><span><?php echo $_smarty_tpl->tpl_vars['node']->value->menutext;?>
</span></a>
<?php }?>
<?php } ?>
<?php echo smarty_function_repeat(array('string'=>'</li><li class="separator once" style="list-style-type: none;">&nbsp;</li></ul>','times'=>$_smarty_tpl->tpl_vars['node']->value->depth-1),$_smarty_tpl);?>

</li>
</ul>
<div class="clearb"></div>
</div>
<?php }?>
<?php }} ?>
