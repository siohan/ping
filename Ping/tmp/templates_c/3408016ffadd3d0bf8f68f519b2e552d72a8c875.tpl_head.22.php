<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:38
         compiled from "tpl_head:22" */ ?>
<?php /*%%SmartyHeaderCode:1415616980548e84be90aff3-41400002%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3408016ffadd3d0bf8f68f519b2e552d72a8c875' => 
    array (
      0 => 'tpl_head:22',
      1 => 1242204199,
      2 => 'tpl_head',
    ),
  ),
  'nocache_hash' => '1415616980548e84be90aff3-41400002',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'canonical' => 0,
    'content_obj' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84bea16270_76425877',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84bea16270_76425877')) {function content_548e84bea16270_76425877($_smarty_tpl) {?><?php if (!is_callable('smarty_function_title')) include '/Applications/MAMP/htdocs/rc1/plugins/function.title.php';
if (!is_callable('smarty_function_sitename')) include '/Applications/MAMP/htdocs/rc1/plugins/function.sitename.php';
if (!is_callable('smarty_function_metadata')) include '/Applications/MAMP/htdocs/rc1/plugins/function.metadata.php';
if (!is_callable('smarty_cms_function_cms_stylesheet')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_stylesheet.php';
if (!is_callable('smarty_function_cms_selflink')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_selflink.php';
?><head>
<?php if (isset($_smarty_tpl->tpl_vars['canonical']->value)) {?><link rel="canonical" href="<?php echo $_smarty_tpl->tpl_vars['canonical']->value;?>
" /><?php } elseif (isset($_smarty_tpl->tpl_vars['content_obj']->value)) {?><link rel="canonical" href="<?php echo $_smarty_tpl->tpl_vars['content_obj']->value->GetURL();?>
" /><?php }?>

<title><?php echo smarty_function_title(array(),$_smarty_tpl);?>
 | <?php echo smarty_function_sitename(array(),$_smarty_tpl);?>
</title>


<?php echo smarty_function_metadata(array(),$_smarty_tpl);?>



<?php echo smarty_cms_function_cms_stylesheet(array(),$_smarty_tpl);?>



<?php echo smarty_function_cms_selflink(array('dir'=>"start",'rellink'=>1),$_smarty_tpl);?>

<?php echo smarty_function_cms_selflink(array('dir'=>"prev",'rellink'=>1),$_smarty_tpl);?>

<?php echo smarty_function_cms_selflink(array('dir'=>"next",'rellink'=>1),$_smarty_tpl);?>



<!--[if IE 6]>
<script type="text/javascript" src="modules/MenuManager/CSSMenu.js"></script>
<![endif]-->





<!--[if IE 6]>
<script type="text/javascript"  src="uploads/NCleanBlue/js/ie6fix.js"></script>
<script type="text/javascript">
 // argument is a CSS selector
 DD_belatedPNG.fix('.sbar-top,.sbar-bottom,.main-top,.main-bottom,#version');
</script>
<style type="text/css">
/* enable background image caching in IE6 */
html {filter:expression(document.execCommand("BackgroundImageCache", false, true));} 
</style>
<![endif]-->


  </head><?php }} ?>
