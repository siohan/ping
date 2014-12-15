<?php /* Smarty version Smarty-3.1.16, created on 2014-12-13 10:13:29
         compiled from "module_file_tpl:ModuleManager;admin_search_tab.tpl" */ ?>
<?php /*%%SmartyHeaderCode:788010549548c0339b2f4e3-36610618%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0eb5bb1c55fa4d888c8c17cc401b10cb59eb0211' => 
    array (
      0 => 'module_file_tpl:ModuleManager;admin_search_tab.tpl',
      1 => 1316277556,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '788010549548c0339b2f4e3-36610618',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'formstart' => 0,
    'mod' => 0,
    'actionid' => 0,
    'term' => 0,
    'advanced' => 0,
    'formend' => 0,
    'search_data' => 0,
    'statustext' => 0,
    'rowclass' => 0,
    'entry' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548c0339c69030_24061488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548c0339c69030_24061488')) {function content_548c0339c69030_24061488($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cycle')) include '/Applications/MAMP/htdocs/rc1/lib/smarty/libs/plugins/function.cycle.php';
?><script type="text/javascript">

function showhide_advanced()
{
  if( document.getElementById('advanced').checked )
  {
    document.getElementById('advhelp').style.display = 'inline';
  }
  else
  {
    document.getElementById('advhelp').style.display = 'none';
  }
}

</script>

<?php echo $_smarty_tpl->tpl_vars['formstart']->value;?>

<fieldset>
<legend><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('search_input');?>
:</legend>
<div class="pageoverflow">
  <p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('searchterm');?>
</p>
  <p class="pageinput">
    <input type="text" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
term" size="50" value="<?php echo $_smarty_tpl->tpl_vars['term']->value;?>
"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_advancedsearch');?>
</p>
  <p class="pageinput">
    <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
advanced" value="0"/>
    <input type="checkbox" id="advanced" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
advanced" value="1" onclick="showhide_advanced();" <?php if ($_smarty_tpl->tpl_vars['advanced']->value) {?>checked="checked"<?php }?>/>
    <span id="advhelp" <?php if (!$_smarty_tpl->tpl_vars['advanced']->value) {?>style="display: none;<?php }?>"><br/><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('advancedsearch_help');?>
</span>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
submit" value="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('submit');?>
"/>
  </p>
</div>
</fieldset>
<?php echo $_smarty_tpl->tpl_vars['formend']->value;?>


<?php if (isset($_smarty_tpl->tpl_vars['search_data']->value)) {?>
<br/>
<fieldset>
<legend><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('search_results');?>
:</legend>
<table class="pagetable" cellspacing="0">
 <thead>
  <tr>
   <th width="20%"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('nametext');?>
</th>
   <th><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('vertext');?>
</th>
   <th><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('sizetext');?>
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
 $_from = $_smarty_tpl->tpl_vars['search_data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value) {
$_smarty_tpl->tpl_vars['entry']->_loop = true;
?>
   <?php echo smarty_function_cycle(array('values'=>'row1,row2','assign'=>'rowclass'),$_smarty_tpl);?>

   <tr class="<?php echo $_smarty_tpl->tpl_vars['rowclass']->value;?>
">
     <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
     <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->version;?>
</td>
     <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->size;?>
</td>
     <td><?php if (isset($_smarty_tpl->tpl_vars['entry']->value->status)) {?><?php echo $_smarty_tpl->tpl_vars['entry']->value->status;?>
<?php }?></td>
     <td><?php if (isset($_smarty_tpl->tpl_vars['entry']->value->dependslink)) {?><?php echo $_smarty_tpl->tpl_vars['entry']->value->dependslink;?>
<?php }?></td>
     <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->helplink;?>
</td>
     <td><?php if (isset($_smarty_tpl->tpl_vars['entry']->value->aboutlink)) {?><?php echo $_smarty_tpl->tpl_vars['entry']->value->aboutlink;?>
<?php }?></td>
   </tr>
   <?php if (isset($_smarty_tpl->tpl_vars['entry']->value->description)) {?>
   <tr class="<?php echo $_smarty_tpl->tpl_vars['rowclass']->value;?>
">
     <td>&nbsp;</td>
     <td colspan="6"><?php echo $_smarty_tpl->tpl_vars['entry']->value->description;?>
</td>
   </tr>
   <?php }?>
 <?php } ?>
 </tbody>
</table>
</fieldset>
<?php }?><?php }} ?>
