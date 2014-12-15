<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:37
         compiled from "tpl_body:22" */ ?>
<?php /*%%SmartyHeaderCode:799407911548e84bd222002-79181632%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f86d86ab39c1bb93a1b057df0c3d0155eccd402c' => 
    array (
      0 => 'tpl_body:22',
      1 => 1242204199,
      2 => 'tpl_body',
    ),
  ),
  'nocache_hash' => '799407911548e84bd222002-79181632',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cms_version' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84bd5d69a0_04643894',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84bd5d69a0_04643894')) {function content_548e84bd5d69a0_04643894($_smarty_tpl) {?><?php if (!is_callable('smarty_function_anchor')) include '/Applications/MAMP/htdocs/rc1/plugins/function.anchor.php';
if (!is_callable('smarty_function_cms_selflink')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_selflink.php';
if (!is_callable('Search::function_plugin')) include '/Applications/MAMP/htdocs/rc1/plugins/function.search.php';
if (!is_callable('smarty_function_cms_version')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_version.php';
if (!is_callable('smarty_function_cms_versionname')) include '/Applications/MAMP/htdocs/rc1/plugins/function.cms_versionname.php';
if (!is_callable('News::function_plugin')) include '/Applications/MAMP/htdocs/rc1/plugins/function.news.php';
if (!is_callable('smarty_function_title')) include '/Applications/MAMP/htdocs/rc1/plugins/function.title.php';
if (!is_callable('smarty_function_global_content')) include '/Applications/MAMP/htdocs/rc1/plugins/function.global_content.php';
?>
  <body>
    <div id="ncleanblue">
      <div id="pagewrapper" class="core-wrap-960 core-center">

        <ul class="accessibility">
          <li><?php echo smarty_function_anchor(array('anchor'=>'menu_vert','title'=>'Aller à la navigation','accesskey'=>'n','text'=>'Aller à la navigation'),$_smarty_tpl);?>
</li>
          <li><?php echo smarty_function_anchor(array('anchor'=>'main','title'=>'Aller au contenu','accesskey'=>'s','text'=>'Aller au contenu'),$_smarty_tpl);?>
</li>
        </ul>

        <hr class="accessibility" />



        <div id="header" class="util-clearfix">

          <div id="logo" class="core-float-left">
            <?php echo smarty_function_cms_selflink(array('dir'=>"start",'text'=>((string)$_smarty_tpl->tpl_vars['sitename']->value)),$_smarty_tpl);?>

          </div>
          

          <div id="search" class="core-float-right">
            <?php echo Search::function_plugin(array('submit'=>'OK','search_method'=>"post"),$_smarty_tpl);?>

          </div>

          <span class="util-clearb">&nbsp;</span>
          

          <h2 class="accessibility util-clearb">Navigation</h2>

          <div class="page-menu util-clearfix">
          <?php echo MenuManager::function_plugin(array('loadprops'=>0,'template'=>'cssmenu_ulshadow.tpl'),$_smarty_tpl);?>

          </div>
          <hr class="accessibility util-clearb" />


        </div>



        <div id="content" class="util-clearfix"> 


          <div title="CMS - <?php echo smarty_function_cms_version(array(),$_smarty_tpl);?>
 - <?php echo smarty_function_cms_versionname(array(),$_smarty_tpl);?>
" id="version">
          <?php $_smarty_tpl->_capture_stack[0][] = array('default', 'cms_version', null); ob_start(); ?><?php ob_start();?><?php echo smarty_function_cms_version(array(),$_smarty_tpl);?>
<?php echo mb_strtolower(ob_get_clean(), 'UTF-8')?><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php echo preg_replace("/-([a-z]).*/",'',$_smarty_tpl->tpl_vars['cms_version']->value);?>

          </div>



          <div id="bar" class="util-clearfix">

            <div class="breadcrumbs core-float-right">
              <?php echo MenuManager::smarty_cms_breadcrumbs(array('root'=>'Home'),$_smarty_tpl);?>

            </div>


            <hr class="accessibility util-clearb" />
          </div>



          <div id="left" class="core-float-left">
            <div class="sbar-top">
              <h2 class="sbar-title">News</h2>
            </div>
            <div class="sbar-main">

              <div id="news">
              <?php echo News::function_plugin(array('number'=>'3','detailpage'=>'news'),$_smarty_tpl);?>

              </div>
              <img class="screen" src="uploads/NCleanBlue/screen-1.6.jpg" width="139" height="142" title="CMS - <?php echo smarty_function_cms_version(array(),$_smarty_tpl);?>
 - <?php echo smarty_function_cms_versionname(array(),$_smarty_tpl);?>
" alt="CMS - <?php echo smarty_function_cms_version(array(),$_smarty_tpl);?>
 - <?php echo smarty_function_cms_versionname(array(),$_smarty_tpl);?>
" />
 
            </div>
            <span class="sbar-bottom">&nbsp;</span> 
          </div>



          <div id="main"  class="core-float-right">


            <div class="main-top">
              <div class="print core-float-right">
                <?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['print'][0][0]->_my_function_plugin(array('showbutton'=>true),$_smarty_tpl);?>

              </div>
            </div> 
            

            <div class="main-main util-clearfix">
              <h1 class="title"><?php echo smarty_function_title(array(),$_smarty_tpl);?>
</h1>
            <?php CMS_Content_Block::smarty_internal_fetch_contentblock(array(),$_smarty_tpl); ?>
            </div>
            

            <div class="main-bottom">
              <div class="right49 core-float-right">
              <?php echo smarty_function_anchor(array('anchor'=>'main','text'=>'^&nbsp;&nbsp;Top'),$_smarty_tpl);?>

              </div>
              <div class="left49 core-float-left">
                <span>
                  <?php echo smarty_function_cms_selflink(array('dir'=>"previous"),$_smarty_tpl);?>
&nbsp;

                </span>
                <span>
                  <?php echo smarty_function_cms_selflink(array('dir'=>"next"),$_smarty_tpl);?>
&nbsp;
                </span>
              </div>


              <hr class="accessibility" />
            </div>


          </div>


        </div>


      </div>

      <span class="util-clearb">&nbsp;</span>
      

      <div id="footer-wrapper">
        <div id="footer" class="core-wrap-960">

          <div class="block core-float-left">
            <?php echo MenuManager::function_plugin(array('loadprops'=>0,'template'=>'minimal_menu.tpl','number_of_levels'=>'1'),$_smarty_tpl);?>

          </div>
          

          <div class="block core-float-left">
            <?php echo MenuManager::function_plugin(array('loadprops'=>0,'template'=>'minimal_menu.tpl','start_level'=>"2"),$_smarty_tpl);?>

          </div>
          

          <div class="block cms core-float-left">
            <?php echo smarty_function_global_content(array('name'=>'footer'),$_smarty_tpl);?>

          </div>
          
          <span class="util-clearb">&nbsp;</span>
        </div>
      </div>

    </div>

  </body>
</html><?php }} ?>
