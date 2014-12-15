<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:49
         compiled from "/Applications/MAMP/htdocs/rc1/admin/themes/OneEleven/templates/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1336663202548f358112ae94-81460463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2339d33fd90254d9b81ecce20a4187d590fb4836' => 
    array (
      0 => '/Applications/MAMP/htdocs/rc1/admin/themes/OneEleven/templates/footer.tpl',
      1 => 1343072854,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1336663202548f358112ae94-81460463',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'marks' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f3581212644_14527759',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f3581212644_14527759')) {function content_548f3581212644_14527759($_smarty_tpl) {?><?php if (!is_callable('smarty_function_cms_version')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_version.php';
if (!is_callable('smarty_function_cms_versionname')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_versionname.php';
?><footer id="oe_footer" class="cf"><div class="footer-left"><small class="copyright">Copyright &copy; <a rel="external" href="http://www.cmsmadesimple.org">CMS Made Simple&trade; <?php echo smarty_function_cms_version(array(),$_smarty_tpl);?>
 &ldquo;<?php echo smarty_function_cms_versionname(array(),$_smarty_tpl);?>
&rdquo;</a></small></div><?php if (isset($_smarty_tpl->tpl_vars['marks']->value)) {?><div class="footer-right cf"><ul class="links"><li><a href="http://docs.cmsmadesimple.org/" rel="external" title="<?php echo lang('documentation');?>
"><?php echo lang('documentation');?>
</a></li><li><a href="http://wiki.cmsmadesimple.fr/wiki/Accueil" rel="external" title="<?php echo lang('wiki');?>
"><?php echo lang('wiki');?>
</a></li><li><a href="http://www.cmsmadesimple.fr/forum/" rel="external" title="<?php echo lang('forums');?>
"><?php echo lang('forums');?>
</a></li><li><a href="http://www.cmsmadesimple.org/about-link/" rel="external" title="<?php echo lang('about');?>
"><?php echo lang('about');?>
</a></li><li><a href="http://www.cmsmadesimple.org/about-link/about-us/" rel="external" title="<?php echo lang('team');?>
"><?php echo lang('team');?>
</a></li></ul></div><?php }?></footer>
<?php }} ?>
