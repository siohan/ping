<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:43
         compiled from "module_file_tpl:Ping;joueurs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1562223976548f357b00ea21-99645972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a4dd1408c4a14e7c9a0268e2ba381ec875909106' => 
    array (
      0 => 'module_file_tpl:Ping;joueurs.tpl',
      1 => 1414427805,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '1562223976548f357b00ea21-99645972',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tablesorter' => 0,
    'itemcount' => 0,
    'itemsfound' => 0,
    'retrieve_users' => 0,
    'createlink' => 0,
    'display_unable_players' => 0,
    'create_new_user3' => 0,
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
  'unifunc' => 'content_548f357b176d92_95669665',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f357b176d92_95669665')) {function content_548f357b176d92_95669665($_smarty_tpl) {?><script type="text/javascript">
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
&nbsp;|&nbsp;<?php echo $_smarty_tpl->tpl_vars['retrieve_users']->value;?>
&nbsp;|&nbsp;<?php echo $_smarty_tpl->tpl_vars['createlink']->value;?>
&nbsp;| &nbsp;| <?php echo $_smarty_tpl->tpl_vars['display_unable_players']->value;?>
&nbsp;|&nbsp;<?php echo $_smarty_tpl->tpl_vars['create_new_user3']->value;?>
</p></div>
<?php if ($_smarty_tpl->tpl_vars['itemcount']->value>0) {?>
<?php echo $_smarty_tpl->tpl_vars['form2start']->value;?>

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th><?php echo $_smarty_tpl->tpl_vars['id']->value;?>
</th>
		<th>Joueur</th>
		<th>Licence</th>
		<th>Actif</th>
		<th>Sexe</th>
		<th>Date naissance</th>
		<th colspan='2'>Actions</th>
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
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->licence;?>
</td>
    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->actif;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->sexe;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->birthday;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->doedit;?>
</td>
	<td><?php echo $_smarty_tpl->tpl_vars['entry']->value->view_contacts;?>
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

<?php } else { ?>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['retrieve_users']->value;?>
</p></div>
<?php }?>
<div class="pageoptions"><p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['createlink']->value;?>
</p></div>
<?php }} ?>
