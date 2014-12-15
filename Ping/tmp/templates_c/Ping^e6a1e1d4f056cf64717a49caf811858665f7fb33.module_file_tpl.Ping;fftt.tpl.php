<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:43
         compiled from "module_file_tpl:Ping;fftt.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1784300753548f357bacbe74-89047569%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6a1e1d4f056cf64717a49caf811858665f7fb33' => 
    array (
      0 => 'module_file_tpl:Ping;fftt.tpl',
      1 => 1416944568,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '1784300753548f357bacbe74-89047569',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tablesorter' => 0,
    'formstart' => 0,
    'input_compet' => 0,
    'input_date' => 0,
    'input_player' => 0,
    'submitfilter' => 0,
    'hidden' => 0,
    'formend' => 0,
    'retrieve_all_parties' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'form2start' => 0,
    'items' => 0,
    'entry' => 0,
    'actionid' => 0,
    'actiondemasse' => 0,
    'submit_massaction' => 0,
    'form2end' => 0,
    'retour' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f357bbe28a1_59373713',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357bbe28a1_59373713')) {function content_548f357bbe28a1_59373713($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/Applications/MAMP/htdocs/rc1/lib/smarty/libs/plugins/modifier.date_format.php';
?><script type="text/javascript">
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

<?php if (isset($_smarty_tpl->tpl_vars['formstart']->value)) {?>
<fieldset>
  <legend>Filtres</legend>
  <?php echo $_smarty_tpl->tpl_vars['formstart']->value;?>

  <div class="pageoverflow">
	<p class="pagetext">Type Compétition:</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_compet']->value;?>
 </p>
    <p class="pagetext">Date:</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_date']->value;?>
 </p>
	<p class="pagetext">Joueur :</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_player']->value;?>
 </p>
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['submitfilter']->value;?>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['hidden']->value)===null||$tmp==='' ? '' : $tmp);?>
</p>
  </div>
  <?php echo $_smarty_tpl->tpl_vars['formend']->value;?>

</fieldset>
<?php }?>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['retrieve_all_parties']->value;?>
</p></div>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
</p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<?php echo $_smarty_tpl->tpl_vars['form2start']->value;?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
  <tr>
	<th>Id</th>
	<th>N° Journée</th>
	<th>Date</th>
	<th>Joueur</th>
	<th>Vic/def</th>
	<th>Adversaire</th>
	<th>Points</th>
	<th colspan="3">Actions</th>
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
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->numjourn;?>
</td>
	<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['entry']->value->date_event,"%d/%m");?>

    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->joueur;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->vd;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->advnompre;?>
 </td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->pointres;?>
 </td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->duplicatelink;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
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

<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['retour']->value;?>
</p></div><hr />
<div class="pageoptions"><p class="pageoptions"></p></div>
<?php }} ?>
