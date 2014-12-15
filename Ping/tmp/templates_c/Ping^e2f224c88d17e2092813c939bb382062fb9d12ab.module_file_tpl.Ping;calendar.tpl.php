<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:43
         compiled from "module_file_tpl:Ping;calendar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:215486867548f357b46ff43-11159640%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2f224c88d17e2092813c939bb382062fb9d12ab' => 
    array (
      0 => 'module_file_tpl:Ping;calendar.tpl',
      1 => 1417778284,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '215486867548f357b46ff43-11159640',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tablesorter' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'createlink' => 0,
    'maintenant' => 0,
    'form2start' => 0,
    'items' => 0,
    'entry' => 0,
    'submit_massdelete' => 0,
    'form2end' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f357b55cb06_65767743',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357b55cb06_65767743')) {function content_548f357b55cb06_65767743($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/Applications/MAMP/htdocs/rc1/lib/smarty/libs/plugins/modifier.date_format.php';
?>
<script type="text/javascript">
//<![CDATA[
$(document).ready(function(){
  $('#selectall').click(function(){
    var v = $(this).attr('checked');
    if( v == 'checked' ) {
      $('.select').attr('checked','checked');
    } else {
      $('.select').removeAttr('checked');
    }
  });
  $('.select').click(function(){
    $('#selectall').removeAttr('checked');
  });
  $('#toggle_filter').click(function(){
    $('#filter_form').toggle();
  });
  <?php if (isset($_smarty_tpl->tpl_vars['tablesorter']->value)) {?>
  $('#articlelist').tablesorter({ sortList:<?php echo $_smarty_tpl->tpl_vars['tablesorter']->value;?>
 });
  <?php }?>
});
//]]>
</script>


<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
  | <?php echo $_smarty_tpl->tpl_vars['createlink']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['maintenant']->value;?>
</p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<?php echo $_smarty_tpl->tpl_vars['form2start']->value;?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Nom_compet</th>
		<th>Type_compétition</th>
		<th>Date Début</th>
		<th>Date Fin</th>
		<th>N° Tour</th>
		<th colspan="2">Actions</th>
    </tr>
 </thead>
 <tbody>
<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['entry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value) {
$_smarty_tpl->tpl_vars['entry']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['entry']->value->date_fin<$_smarty_tpl->tpl_vars['maintenant']->value) {?><tr class="<?php echo $_smarty_tpl->tpl_vars['entry']->value->rowclass;?>
 past" style="background: red;"><?php } else { ?>
  <tr class="<?php echo $_smarty_tpl->tpl_vars['entry']->value->rowclass;?>
"><?php }?>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->type_compet;?>
</td>
	<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['entry']->value->date_debut,"%d-%m-%Y");?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->date_fin;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->numjourn;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->retrievelink;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
	</tr>
<?php } ?>
 </tbody>
</table>
<?php }?>
<div style="width: 100%;">
<div class="pageoptions" style="float: left;">
	<p class="pageoptions"></p>
</div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
  <div class="pageoptions" style="float: right; text-align: right;">
    <?php echo $_smarty_tpl->tpl_vars['submit_massdelete']->value;?>

  </div>
<?php }?>
<div class="clearb"></div>
</div>
<?php echo $_smarty_tpl->tpl_vars['form2end']->value;?>








<?php }} ?>
