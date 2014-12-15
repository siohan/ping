<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:45
         compiled from "module_file_tpl:Ping;spid.tpl" */ ?>
<?php /*%%SmartyHeaderCode:757883997548f357dd4c401-90152128%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0817058ca2ecf0fc3d0ed029034eecb3172780b9' => 
    array (
      0 => 'module_file_tpl:Ping;spid.tpl',
      1 => 1416823416,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '757883997548f357dd4c401-90152128',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tablesorter' => 0,
    'formstart' => 0,
    'input_compet' => 0,
    'prompt_tour' => 0,
    'input_tour' => 0,
    'input_date' => 0,
    'input_player' => 0,
    'submitfilter' => 0,
    'hidden' => 0,
    'formend' => 0,
    'returnlink' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'verif_spid_fftt' => 0,
    'retrieve_all' => 0,
    'form2start' => 0,
    'items' => 0,
    'entry' => 0,
    'actionid' => 0,
    'actiondemasse' => 0,
    'submit_massaction' => 0,
    'form2end' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f357deb2f31_60447119',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357deb2f31_60447119')) {function content_548f357deb2f31_60447119($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/Applications/MAMP/htdocs/rc1/lib/smarty/libs/plugins/modifier.date_format.php';
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
    <!--<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['prompt_tour']->value;?>
:</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_tour']->value;?>
 </p>-->
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
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['returnlink']->value;?>
</p></div>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['itemcount']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['itemsfound']->value;?>
 | <?php echo $_smarty_tpl->tpl_vars['verif_spid_fftt']->value;?>
</p></div>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['retrieve_all']->value;?>
</p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<?php echo $_smarty_tpl->tpl_vars['form2start']->value;?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>	
		<th>Id</th>
		<th>Joueur</th>
		<th>Date</th>
		<th>Epreuve</th>
		<th>Nom adversaire</th>
		<th>Classement</th>
		<th>Victoire</th>
		<th>Ecart</th>
		<th>Coeff</th>
		<th>Points</th>
		<th>Forfait</th>
		<th colspan="2">Actions</th>
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
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->record_id;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->joueur;?>
</td>	
    <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['entry']->value->date_event,"%A %e %B %Y");?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->epreuve;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->classement;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->victoire;?>
</td>
	<?php if ($_smarty_tpl->tpl_vars['entry']->value->ecart=="0.00"||$_smarty_tpl->tpl_vars['entry']->value->ecart==-$_smarty_tpl->tpl_vars['entry']->value->classement) {?><td style="background-color: orange;"><?php } else { ?><td><?php }?><?php echo $_smarty_tpl->tpl_vars['entry']->value->ecart;?>
</td>
	<?php if ($_smarty_tpl->tpl_vars['entry']->value->coeff=="0.00") {?><td style="background-color: red;"><?php } else { ?><td><?php }?><?php echo $_smarty_tpl->tpl_vars['entry']->value->coeff;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->pointres;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->forfait;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->duplicatelink;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
	<td><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
sel[]" value="<?php echo $_smarty_tpl->tpl_vars['entry']->value->record_id;?>
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

<div class="pageoptions"><p class="pageoptions"></p></div>
<?php }} ?>
