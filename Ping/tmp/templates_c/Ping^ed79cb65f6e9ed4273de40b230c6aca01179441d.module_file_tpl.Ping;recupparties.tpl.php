<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:47
         compiled from "module_file_tpl:Ping;recupparties.tpl" */ ?>
<?php /*%%SmartyHeaderCode:295359792548f357f0450e5-42714506%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed79cb65f6e9ed4273de40b230c6aca01179441d' => 
    array (
      0 => 'module_file_tpl:Ping;recupparties.tpl',
      1 => 1414427805,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '295359792548f357f0450e5-42714506',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tablesorter' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'form2start' => 0,
    'id' => 0,
    'items' => 0,
    'entry' => 0,
    'actionid' => 0,
    'actiondemasse' => 0,
    'submit_massaction' => 0,
    'form2end' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f357f12ee10_06883949',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357f12ee10_06883949')) {function content_548f357f12ee10_06883949($_smarty_tpl) {?><script type="text/javascript">
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
<h2>Etat des récupérations des joueurs actifs</h2>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
  </p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<?php echo $_smarty_tpl->tpl_vars['form2start']->value;?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th><?php echo $_smarty_tpl->tpl_vars['id']->value;?>
</th>
		<th>Joueur</th>
		<th>Dernière Situation</th>
		<th>Parties FFTT</th>
		<th>Parties Spid</th>
		<th colspan='4'>Actions</th>
		<th><input type="checkbox" id="selectall" name="selectall"></th>
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
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->joueur;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->sit_mens;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->fftt;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->spid;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->sitmenslink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->getpartieslink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->getpartiesspid;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->doedit;?>
</td>
<!--	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>-->
	<td><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
sel[]" value="<?php echo $_smarty_tpl->tpl_vars['entry']->value->licence;?>
" class="select"></td>
  </tr>
<?php } ?>
 </tbody>
</table>
<!-- SELECT DROPDOWN -->
<div class="pageoptions" style="float: right;">
<br/><?php echo $_smarty_tpl->tpl_vars['actiondemasse']->value;?>
<?php echo $_smarty_tpl->tpl_vars['submit_massaction']->value;?>

  </div>
<?php echo $_smarty_tpl->tpl_vars['form2end']->value;?>

<?php }?>
<?php }} ?>
