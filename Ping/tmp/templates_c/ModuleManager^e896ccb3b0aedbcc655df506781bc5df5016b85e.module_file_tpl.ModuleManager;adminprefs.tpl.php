<?php /* Smarty version Smarty-3.1.16, created on 2014-12-13 10:13:30
         compiled from "module_file_tpl:ModuleManager;adminprefs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:538975760548c033a5fc0e7-97482055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e896ccb3b0aedbcc655df506781bc5df5016b85e' => 
    array (
      0 => 'module_file_tpl:ModuleManager;adminprefs.tpl',
      1 => 1307868376,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '538975760548c033a5fc0e7-97482055',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'message' => 0,
    'formstart' => 0,
    'prompt_settings' => 0,
    'prompt_url' => 0,
    'input_url' => 0,
    'extratext_url' => 0,
    'prompt_latestdepends' => 0,
    'input_latestdepends' => 0,
    'info_latestdepends' => 0,
    'prompt_disable_caching' => 0,
    'input_disable_caching' => 0,
    'info_disable_caching' => 0,
    'prompt_chunksize' => 0,
    'input_chunksize' => 0,
    'extratext_chunksize' => 0,
    'submit' => 0,
    'prompt_otheroptions' => 0,
    'prompt_reseturl' => 0,
    'input_reseturl' => 0,
    'prompt_resetcache' => 0,
    'input_resetcache' => 0,
    'formend' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548c033a680285_15223983',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548c033a680285_15223983')) {function content_548c033a680285_15223983($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['message']->value)) {?><p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p><?php }?>
<?php echo $_smarty_tpl->tpl_vars['formstart']->value;?>

        <fieldset>
        <legend><?php echo $_smarty_tpl->tpl_vars['prompt_settings']->value;?>
</legend>
	<div class="pageoverflow">
		<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_url']->value;?>
:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_url']->value;?>
<br/><?php echo $_smarty_tpl->tpl_vars['extratext_url']->value;?>
</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_latestdepends']->value;?>
:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_latestdepends']->value;?>
<br/><?php echo $_smarty_tpl->tpl_vars['info_latestdepends']->value;?>
</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_disable_caching']->value;?>
:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_disable_caching']->value;?>
<br/><?php echo $_smarty_tpl->tpl_vars['info_disable_caching']->value;?>
</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_chunksize']->value;?>
:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_chunksize']->value;?>
<br/><?php echo $_smarty_tpl->tpl_vars['extratext_chunksize']->value;?>
</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['submit']->value;?>
</p>
	</div>
        </fieldset>
        <fieldset>
        <legend><?php echo $_smarty_tpl->tpl_vars['prompt_otheroptions']->value;?>
</legend>
	<div class="pageoverflow">
		<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_reseturl']->value;?>
:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_reseturl']->value;?>
</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_resetcache']->value;?>
:</p>
		<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_resetcache']->value;?>
</p>
	</div>
        </fieldset>
<?php echo $_smarty_tpl->tpl_vars['formend']->value;?>

<?php }} ?>
