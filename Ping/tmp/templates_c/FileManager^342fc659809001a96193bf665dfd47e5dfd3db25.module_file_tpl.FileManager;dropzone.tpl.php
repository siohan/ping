<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 20:24:49
         compiled from "module_file_tpl:FileManager;dropzone.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1286393179548f358102c9d4-66898365%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '342fc659809001a96193bf665dfd47e5dfd3db25' => 
    array (
      0 => 'module_file_tpl:FileManager;dropzone.tpl',
      1 => 1390837840,
      2 => 'module_file_tpl',
    ),
  ),
  'nocache_hash' => '1286393179548f358102c9d4-66898365',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_ie' => 0,
    'chdir_url' => 0,
    'max_chunksize' => 0,
    'dirlist' => 0,
    'mod' => 0,
    'cwd' => 0,
    'formstart' => 0,
    'actionid' => 0,
    'prompt_dropfiles' => 0,
    'formend' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548f358110f1b4_63526932',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548f358110f1b4_63526932')) {function content_548f358110f1b4_63526932($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/Applications/MAMP/htdocs/rc1/lib/smarty/libs/plugins/function.html_options.php';
?><?php if (!isset($_smarty_tpl->tpl_vars['is_ie']->value)) {?>

<script type="text/javascript">
jQuery(function($) {
   $('.dialog').bind('dialogopen',function(event,ui){
     var url = '<?php echo $_smarty_tpl->tpl_vars['chdir_url']->value;?>
';
     url = url.replace(/amp;/g,'')+'&showtemplate=false';
     $.get(url,function(data) {
       $('#fm_newdir').val('/'+data);
     });
   });
   $('#chdir_form').submit(function(e){
     var data = $(this).serialize(),
         url = '<?php echo $_smarty_tpl->tpl_vars['chdir_url']->value;?>
';
     url = url.replace(/amp;/g,'')+'&showtemplate=false';
     $.post(url,data,function(data,textStatus,jqXHR){
       // stuff to do on post finishing.
       $('.dialog').dialog('close');
       $('#chdir_form').trigger('dropzone_chdir');
     });
     e.preventDefault();
   });
   
   var thediv = '#theme_dropzone';

   // prevent browser default drag/drop handling
   $(document).bind('drop dragover', function(e) {
       // prevent default drag/drop stuff.
       e.preventDefault();
   });

   $('#theme_dropzone_i').fileupload({
     dataType: 'json',
     dropZone: $('#theme_dropzone'),
     maxChunkSize: <?php echo $_smarty_tpl->tpl_vars['max_chunksize']->value;?>
,
  
     progressall: function(e,data) {
       var total = (data.loaded / data.total * 100).toFixed(0);
       $(thediv).progressbar({ value: parseInt(total) });
       $('.ui-progressbar-value').html(total+'%');
     },

     stop: function(e,data) {
       $(thediv).progressbar('destroy');
       $(thediv).trigger('dropzone_stop');
     }
   });
});
</script>
<div class="drop">
	<div class="drop-inner cf">
	<?php if (isset($_smarty_tpl->tpl_vars['dirlist']->value)) {?>
		<span class="folder-selection open" title="<?php echo lang('open');?>
"></span>
		<div class="dialog invisible" role="dialog" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('change_working_folder');?>
">
			<form id="chdir_form" class="cms_form" action="<?php echo $_smarty_tpl->tpl_vars['chdir_url']->value;?>
" method="post">
				<fieldset>
					<legend><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('change_working_folder');?>
</legend>
					<label><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('folder');?>
: </label>
                                        <input type="hidden" name="m1_path" value="<?php echo $_smarty_tpl->tpl_vars['cwd']->value;?>
"/>
                                        <input type="hidden" name="m1_ajax" value="1"/>
					<select class="cms_dropdown" id="fm_newdir" name="m1_newdir">
                                          <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['dirlist']->value,'selected'=>$_smarty_tpl->tpl_vars['cwd']->value),$_smarty_tpl);?>

					</select>
					<input type="submit" name="m1_submit" value="<?php echo $_smarty_tpl->tpl_vars['mod']->value->lang('ok');?>
" />
				</fieldset>
				</form>
		</div>
	<?php }?>								
		<div class="zone">
			<div id="theme_dropzone">
				<?php echo $_smarty_tpl->tpl_vars['formstart']->value;?>

				<input type="hidden" name="disable_buffer" value="1"/>
				<input type="file" id="theme_dropzone_i" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
files[]" multiple style="display: none;"/>
				<?php echo $_smarty_tpl->tpl_vars['prompt_dropfiles']->value;?>

				<?php echo $_smarty_tpl->tpl_vars['formend']->value;?>

			</div>
		</div>
	</div>									
	<a href="#" title="<?php echo lang('open');?>
/<?php echo lang('close');?>
" class="toggle-dropzone"><?php echo lang('open');?>
/<?php echo lang('close');?>
</a>
</div>
<?php }?>
<?php }} ?>
