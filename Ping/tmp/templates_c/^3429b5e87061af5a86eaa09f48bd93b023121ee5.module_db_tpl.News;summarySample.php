<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:38
         compiled from "module_db_tpl:News;summarySample" */ ?>
<?php /*%%SmartyHeaderCode:529420076548e84be11d266-72532721%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3429b5e87061af5a86eaa09f48bd93b023121ee5' => 
    array (
      0 => 'module_db_tpl:News;summarySample',
      1 => 1417101067,
      2 => 'module_db_tpl',
    ),
  ),
  'nocache_hash' => '529420076548e84be11d266-72532721',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cats' => 0,
    'node' => 0,
    'category_name' => 0,
    'pagecount' => 0,
    'pagenumber' => 0,
    'firstpage' => 0,
    'prevpage' => 0,
    'pagetext' => 0,
    'oftext' => 0,
    'nextpage' => 0,
    'lastpage' => 0,
    'items' => 0,
    'entry' => 0,
    'category_label' => 0,
    'author_label' => 0,
    'field' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84be425321_89884619',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84be425321_89884619')) {function content_548e84be425321_89884619($_smarty_tpl) {?><?php if (!is_callable('smarty_function_repeat')) include '/Applications/MAMP/htdocs/rc1/plugins/function.repeat.php';
if (!is_callable('smarty_cms_modifier_cms_date_format')) include '/Applications/MAMP/htdocs/rc1/plugins/modifier.cms_date_format.php';
if (!is_callable('smarty_modifier_cms_escape')) include '/Applications/MAMP/htdocs/rc1/plugins/modifier.cms_escape.php';
?><!-- Start News Display Template -->

<ul class="list1">
<?php  $_smarty_tpl->tpl_vars['node'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['node']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cats']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['node']->key => $_smarty_tpl->tpl_vars['node']->value) {
$_smarty_tpl->tpl_vars['node']->_loop = true;
?>
<?php if ($_smarty_tpl->tpl_vars['node']->value['depth']>$_smarty_tpl->tpl_vars['node']->value['prevdepth']) {?>
<?php echo smarty_function_repeat(array('string'=>"<ul>",'times'=>$_smarty_tpl->tpl_vars['node']->value['depth']-$_smarty_tpl->tpl_vars['node']->value['prevdepth']),$_smarty_tpl);?>

<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['depth']<$_smarty_tpl->tpl_vars['node']->value['prevdepth']) {?>
<?php echo smarty_function_repeat(array('string'=>"</li></ul>",'times'=>$_smarty_tpl->tpl_vars['node']->value['prevdepth']-$_smarty_tpl->tpl_vars['node']->value['depth']),$_smarty_tpl);?>

</li>
<?php } elseif ($_smarty_tpl->tpl_vars['node']->value['index']>0) {?></li>
<?php }?>
<li<?php if ($_smarty_tpl->tpl_vars['node']->value['index']==0) {?> class="firstnewscat"<?php }?>>
<?php if ($_smarty_tpl->tpl_vars['node']->value['count']>0) {?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['node']->value['url'];?>
"><?php echo $_smarty_tpl->tpl_vars['node']->value['news_category_name'];?>
</a><?php } else { ?><span><?php echo $_smarty_tpl->tpl_vars['node']->value['news_category_name'];?>
 </span><?php }?>
<?php } ?>
<?php echo smarty_function_repeat(array('string'=>"</li></ul>",'times'=>$_smarty_tpl->tpl_vars['node']->value['depth']-1),$_smarty_tpl);?>
</li>
</ul>


<?php if ($_smarty_tpl->tpl_vars['category_name']->value) {?>
<h1><?php echo $_smarty_tpl->tpl_vars['category_name']->value;?>
</h1>
<?php }?>



<?php if ($_smarty_tpl->tpl_vars['pagecount']->value>1) {?>
  <p>
<?php if ($_smarty_tpl->tpl_vars['pagenumber']->value>1) {?>
<?php echo $_smarty_tpl->tpl_vars['firstpage']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['prevpage']->value;?>
&nbsp;
<?php }?>
<?php echo $_smarty_tpl->tpl_vars['pagetext']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['pagenumber']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['oftext']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['pagecount']->value;?>

<?php if ($_smarty_tpl->tpl_vars['pagenumber']->value<$_smarty_tpl->tpl_vars['pagecount']->value) {?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['nextpage']->value;?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['lastpage']->value;?>

<?php }?>
</p>
<?php }?>
<?php  $_smarty_tpl->tpl_vars['entry'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['entry']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->key => $_smarty_tpl->tpl_vars['entry']->value) {
$_smarty_tpl->tpl_vars['entry']->_loop = true;
?>
<div class="NewsSummary">

<?php if ($_smarty_tpl->tpl_vars['entry']->value->postdate) {?>
	<div class="NewsSummaryPostdate">
		<?php echo smarty_cms_modifier_cms_date_format($_smarty_tpl->tpl_vars['entry']->value->postdate);?>

	</div>
<?php }?>

<div class="NewsSummaryLink">
<a href="<?php echo $_smarty_tpl->tpl_vars['entry']->value->moreurl;?>
" title="<?php echo smarty_modifier_cms_escape($_smarty_tpl->tpl_vars['entry']->value->title,'htmlall');?>
"><?php echo smarty_modifier_cms_escape($_smarty_tpl->tpl_vars['entry']->value->title);?>
</a>
</div>

<div class="NewsSummaryCategory">
	<?php echo $_smarty_tpl->tpl_vars['category_label']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['entry']->value->category;?>

</div>

<?php if ($_smarty_tpl->tpl_vars['entry']->value->author) {?>
	<div class="NewsSummaryAuthor">
		<?php echo $_smarty_tpl->tpl_vars['author_label']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['entry']->value->author;?>

	</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['entry']->value->summary) {?>
	<div class="NewsSummarySummary">
		<?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['entry']->value->summary, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
	</div>

	<div class="NewsSummaryMorelink">
		[<?php echo $_smarty_tpl->tpl_vars['entry']->value->morelink;?>
]
	</div>

<?php } elseif ($_smarty_tpl->tpl_vars['entry']->value->content) {?>

	<div class="NewsSummaryContent">
		<?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['entry']->value->content, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
	</div>
<?php }?>

<?php if (isset($_smarty_tpl->tpl_vars['entry']->value->extra)) {?>
    <div class="NewsSummaryExtra">
        <?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['entry']->value->extra, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
	
    </div>
<?php }?>
<?php if (isset($_smarty_tpl->tpl_vars['entry']->value->fields)) {?>
  <?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['entry']->value->fields; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
?>
     <div class="NewsSummaryField">
        <?php if ($_smarty_tpl->tpl_vars['field']->value->type=='file') {?>
          <img src="<?php echo $_smarty_tpl->tpl_vars['entry']->value->file_location;?>
/<?php echo $_smarty_tpl->tpl_vars['field']->value->displayvalue;?>
"/>
        <?php } else { ?>
          <?php echo $_smarty_tpl->tpl_vars['field']->value->name;?>
:&nbsp;<?php $_template = new Smarty_Internal_Template('eval:'.$_smarty_tpl->tpl_vars['field']->value->displayvalue, $_smarty_tpl->smarty, $_smarty_tpl);echo $_template->fetch(); ?>
        <?php }?>
     </div>
  <?php } ?>
<?php }?>

</div>
<?php } ?>
<!-- End News Display Template -->
<?php }} ?>
