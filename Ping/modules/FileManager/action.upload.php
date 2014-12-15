<?php
if (!function_exists("cmsms")) exit;
if (!$this->CheckPermission("Modify Files") && !$this->AdvancedAccessAllowed()) exit;

class FileManagerUploadHandler extends jquery_upload_handler
{
  function __construct($options=null)
  {
      if( !is_array($options) ) $options = array();
      // remove image handling, we're gonna handle this another way
      $options['orient_image'] = false;  // turn off auto image rotation
      $options['image_versions'] = array();

      $options['upload_dir'] = filemanager_utils::get_full_cwd().'/';
      $options['upload_url'] = filemanager_utils::get_cwd_url().'/';

      // set everything up.
      parent::__construct($options);
  }

  protected function handle_image_file($file_path,$fileobject)
  {
      parent::handle_image_file($file_path,$fileobject);

      // here we may do image handling, and other cruft.
      if( is_object($fileobject) && $fileobject->name != '' ) {

          $mod = cms_utils::get_module('FileManager');
          $parms = array();
          $parms['file'] = filemanager_utils::join_path(filemanager_utils::get_full_cwd(),$fileobject->name);

          debug_to_log('after uploaded file');
          if( $mod->GetPreference('create_thumbnails') ) {
              $thumb = cms_utils::generate_thumbnail($parms['file']);
              if( $thumb ) {
                  $params['thumb'] = $thumb;
              }
          }

          //$str = $fileobject->name.' uploaded to '.filemanager_utils::get_full_cwd();
		  $str = $fileobject->name.' upload&eacute; vers '.filemanager_utils::get_full_cwd(); //fr
          //if( isset($params['thumb']) ) $str .= ' and a thumbnail was generated';
		  if( isset($params['thumb']) ) $str .= ' et une vignette g&eacute;n&eacute;r&eacute;e'; //fr
		  
          audit('',$mod->GetName(),$str);

          $mod->SendEvent('OnFileUploaded',$parms);
      }
  }
}

try {
    $options = array('param_name'=>$id.'files');
    $upload_handler = new FileManagerUploadHandler($options);
}
catch( Exception $e ) {
    debug_to_log($e->GetMessage());
    //audit('',$this->GetName(),'upload failed: '.$e->GetMessage());
	audit('',$this->GetName(),'�chec upload : '.$e->GetMessage()); //fr
}
exit;

#
# EOF
#
?>
