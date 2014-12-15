<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:46
         compiled from "module_file_tpl:Ping;poulesRencontres.tpl" */ ?>
<?php /*%%SmartyHeaderCode:503752541548f357e8e7fa6-78284115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6606b71915aee27f74360457f975d8fe3aac4021' => 
    array (
      0 => 'module_file_tpl:Ping;poulesRencontres.tpl',
      1 => 1416727304,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '503752541548f357e8e7fa6-78284115',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tablesorter' => 0,
    'formstart' => 0,
    'input_tour' => 0,
    'input_club_uniquement' => 0,
    'input_deja_joues_uniquement' => 0,
    'submitfilter' => 0,
    'hidden' => 0,
    'formend' => 0,
    'createlink' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
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
  'unifunc' => 'content_548f357ea193d5_58500181',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357ea193d5_58500181')) {function content_548f357ea193d5_58500181($_smarty_tpl) {?><script type="text/javascript">
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

    <p class="pagetext">Poule</p>
    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_tour']->value;?>
 </p>
	<p class="pagetext">Mon club uniquement:</p>
	<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_club_uniquement']->value;?>
 </p>
	<p class="pagetext">Déjà joués uniquement:</p>
	<p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['input_deja_joues_uniquement']->value;?>
 </p>

    <p class="pageinput"><?php echo $_smarty_tpl->tpl_vars['submitfilter']->value;?>
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['hidden']->value)===null||$tmp==='' ? '' : $tmp);?>
</p>
  </div>
  <?php echo $_smarty_tpl->tpl_vars['formend']->value;?>

</fieldset>
<?php }?>

<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['createlink']->value;?>
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
  <th>Poule</th>
  <th>Equipe A</th>
  <th colspan="2">Score</th>
  <th>Equipe B</th>
<th colspan="3">Actions</th>
<th><input type="checkbox" id="selectall" name="selectall"/></th>	
 
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
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->libelle;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->equa;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->scorea;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->scoreb;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->equb;?>
</td>
   <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->retrieve_details;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->display;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;?>
</td>
	<td><input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
sel[]" value="<?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
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
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['createlink']->value;?>
</p></div>
<?php }} ?>
