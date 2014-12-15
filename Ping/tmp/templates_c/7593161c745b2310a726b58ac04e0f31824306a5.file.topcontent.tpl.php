<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 18:03:45
         compiled from "/Applications/MAMP/htdocs/rc1/admin/themes/OneEleven/templates/topcontent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1907298646548f1471709f98-58471920%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7593161c745b2310a726b58ac04e0f31824306a5' => 
    array (
      0 => '/Applications/MAMP/htdocs/rc1/admin/themes/OneEleven/templates/topcontent.tpl',
      1 => 1344886976,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1907298646548f1471709f98-58471920',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'nodes' => 0,
    'node' => 0,
    'module' => 0,
    'icon' => 0,
    'one' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f14719ab985_09209083',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f14719ab985_09209083')) {function content_548f14719ab985_09209083($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['node'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['node']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['nodes']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['box']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['node']->key => $_smarty_tpl->tpl_vars['node']->value) {
$_smarty_tpl->tpl_vars['node']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['box']['index']++;
?><?php if (isset($_smarty_tpl->tpl_vars['icon'])) {$_smarty_tpl->tpl_vars['icon'] = clone $_smarty_tpl->tpl_vars['icon'];
$_smarty_tpl->tpl_vars['icon']->value = "themes/OneEleven/images/icons/topfiles/".((string)$_smarty_tpl->tpl_vars['node']->value['name']); $_smarty_tpl->tpl_vars['icon']->nocache = null; $_smarty_tpl->tpl_vars['icon']->scope = 0;
} else $_smarty_tpl->tpl_vars['icon'] = new Smarty_variable("themes/OneEleven/images/icons/topfiles/".((string)$_smarty_tpl->tpl_vars['node']->value['name']), null, 0);?><?php if (isset($_smarty_tpl->tpl_vars['module'])) {$_smarty_tpl->tpl_vars['module'] = clone $_smarty_tpl->tpl_vars['module'];
$_smarty_tpl->tpl_vars['module']->value = "../modules/".((string)$_smarty_tpl->tpl_vars['node']->value['name'])."/images/icon"; $_smarty_tpl->tpl_vars['module']->nocache = null; $_smarty_tpl->tpl_vars['module']->scope = 0;
} else $_smarty_tpl->tpl_vars['module'] = new Smarty_variable("../modules/".((string)$_smarty_tpl->tpl_vars['node']->value['name'])."/images/icon", null, 0);?><?php if ($_smarty_tpl->tpl_vars['node']->value['show_in_menu']&&$_smarty_tpl->tpl_vars['node']->value['url']&&$_smarty_tpl->tpl_vars['node']->value['title']) {?><div class="dashboard-box<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['box']['index']%3==2) {?> last<?php }?>"><nav class="dashboard-inner cf"><a href="<?php echo $_smarty_tpl->tpl_vars['node']->value['url'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['target'])) {?> target="<?php echo $_smarty_tpl->tpl_vars['node']->value['target'];?>
"<?php }?><?php if ($_smarty_tpl->tpl_vars['node']->value['selected']) {?> class="selected"<?php }?>><?php if (file_exists(($_smarty_tpl->tpl_vars['module']->value).('.gif'))) {?><img src="<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
.gif" alt="<?php echo $_smarty_tpl->tpl_vars['node']->value['title'];?>
"<?php if ($_smarty_tpl->tpl_vars['node']->value['description']) {?> title="<?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['node']->value['description']);?>
"<?php }?> /><?php } elseif (file_exists(($_smarty_tpl->tpl_vars['module']->value).('.png'))) {?><img src="<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
.png" alt="<?php echo $_smarty_tpl->tpl_vars['node']->value['title'];?>
"<?php if ($_smarty_tpl->tpl_vars['node']->value['description']) {?> title="<?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['node']->value['description']);?>
"<?php }?> /><?php } elseif (file_exists(($_smarty_tpl->tpl_vars['icon']->value).('.png'))) {?><img src="<?php echo $_smarty_tpl->tpl_vars['icon']->value;?>
.png" width="48" height="48" alt="<?php echo $_smarty_tpl->tpl_vars['node']->value['title'];?>
"<?php if ($_smarty_tpl->tpl_vars['node']->value['description']) {?> title="<?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['node']->value['description']);?>
"<?php }?> /><?php } elseif (file_exists(($_smarty_tpl->tpl_vars['icon']->value).('.gif'))) {?><img src="<?php echo $_smarty_tpl->tpl_vars['icon']->value;?>
.gif" width="48" height="48" alt="<?php echo $_smarty_tpl->tpl_vars['node']->value['title'];?>
"<?php if ($_smarty_tpl->tpl_vars['node']->value['description']) {?> title="<?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['node']->value['description']);?>
"<?php }?> /><?php } else { ?><img src="themes/OneEleven/images/icons/topfiles/modules.png" width="48" height="48" alt="<?php echo $_smarty_tpl->tpl_vars['node']->value['title'];?>
"<?php if ($_smarty_tpl->tpl_vars['node']->value['description']) {?> title="<?php echo preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->tpl_vars['node']->value['description']);?>
"<?php }?> /><?php }?></a><h3><a href="<?php echo $_smarty_tpl->tpl_vars['node']->value['url'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['node']->value['target'])) {?> target="<?php echo $_smarty_tpl->tpl_vars['node']->value['target'];?>
"<?php }?><?php if ($_smarty_tpl->tpl_vars['node']->value['selected']) {?> class="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['node']->value['title'];?>
</a></h3><?php if ($_smarty_tpl->tpl_vars['node']->value['description']) {?><span class="description"><?php echo $_smarty_tpl->tpl_vars['node']->value['description'];?>
</span><?php }?><?php if (isset($_smarty_tpl->tpl_vars['node']->value['children'])) {?><h4><?php echo lang('subitems');?>
</h4><ul class="subitems cf"><?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['one']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['node']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value) {
$_smarty_tpl->tpl_vars['one']->_loop = true;
?><li><a href="<?php echo $_smarty_tpl->tpl_vars['one']->value['url'];?>
"<?php if (isset($_smarty_tpl->tpl_vars['one']->value['target'])) {?> target="<?php echo $_smarty_tpl->tpl_vars['one']->value['target'];?>
"<?php }?>><?php echo $_smarty_tpl->tpl_vars['one']->value['title'];?>
</a></li><?php } ?></ul><?php }?></nav></div><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['box']['index']%3==2) {?><div class="clear"></div><?php }?><?php }?><?php } ?><?php }} ?>
