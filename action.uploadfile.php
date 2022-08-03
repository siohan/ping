<?php

/**
 * gCms
 */
 
if (!isset($gCms)) 
	exit ();
debug_display($params, 'Parameters');
/**
* This module
*/

$sMod = $this->GetName();

/**
 * Permissions
 */

if (!$this->CheckPermission($sMod .' Add') || !$this->CheckPermission($sMod .' Edit')) 
	exit ();


/**
* Declare
*/

$aConfig = cmsms()->GetConfig();

$sSelectFile = (isset($params['newfile'])) ? $params['newfile'] : -1;	

$bError = 0;
$sResponse = '';
$sWidth = '';
$sHeight = '';
$sFile = '';

/***
* Actions
*/

if (!isset($_FILES[$sSelectFile]))
{
	$bError = 1;
	$sResponse = $this->Lang('Error upload. No File selected!');
}

if ($bError == 0)
{
	// dat file
	$sFileName 	= $_FILES[$sSelectFile]['name'];
	$sFileType 	= $_FILES[$sSelectFile]['type']; 
	$sFileTmp 	= $_FILES[$sSelectFile]['tmp_name'];
	$sFileError	= $_FILES[$sSelectFile]['error'];
	$sFileSize 	= $_FILES[$sSelectFile]['size'];

	// file extension
	$sExt = strrchr($sFileName,".");	
	$sFileName = substr($sFileName, 0, strlen($sFileName)-strlen($sExt));

	// test file extension
	$aExt = explode(',',$this->GetPreference('extensions_images',''));
    if (!in_array($sExt, $aExt)) 
    {
    	$bError = 1;
		$sResponse = $this->Lang('Bad File format!', $this->GetPreference('extensions_images',''));
    }
}

if ($bError == 0)
{
	list($width, $height) = getimagesize($sFileTmp);

	$sMaxWidth = $this->GetPreference('max_images_width','');
	$sMaxHeight = $this->GetPreference('max_images_height','');
	if ($width > $sMaxWidth || $height > $sMaxHeight)
	{
		$bError = 1;
		$sResponse = $this->Lang('Error File dimensions!', $sMaxWidth.'x'.$sMaxHeight);
	}
}

if ($bError == 0)
{
	if ($sFileSize > $aConfig['max_upload_size'])
	{
		$bError = 1;
		$sResponse = $this->Lang('Error Filesize!', ceil($aConfig['max_upload_size']*1024/1000000).'ko');
	}
}

if ($bError == 0)
{	
	if ($params['file_name'] == '')
	{
		$sFileName = munge_string_to_url(strtolower($sFileName)).$sExt;
	
	} else {
		// if rename file, remove ext if this is in the new name and put origine ext
		$sFileName = $params['file_name'];
		$sExt2 = strrchr($sFileName,".");	
		$sFileName = substr($sFileName, 0, strlen($sFileName)-strlen($sExt2));
		$sFileName = munge_string_to_url(strtolower($sFileName)).$sExt;
	}

	// upload
	$sDest = cms_join_path($aConfig['uploads_path'], $params['path'], $sFileName);
	
	//@move_uploaded_file($sFileTmp, $sDest);
	if (@cms_move_uploaded_file($sFileTmp, $sDest) === FALSE )
    {
    	$aTrans = array("\\" => " ", "/" => " ");
		$sDest = strtr($sDest, $aTrans);
    	$bError = 1;
		$sResponse = $this->Lang('Error Movefile!' , $sDest);
    }
}

if ($bError == 0)
{
	list($width, $height) = getimagesize($aConfig['uploads_url'] .'/'. $params['link'] .'/'. $sFileName);

	// output
	$sResponse = $this->Lang('File uploaded');
	$sWidth = $width;
	$sHeight = $height;
	$sFile = $params['link'] .'/'. $sFileName;
}

sleep(1);

// return script to hiddenframe
echo '
<script language="javascript" type="text/javascript">
	window.top.window.stop_uploadfile('. $bError .', "'. $sFile .'", "'. $sResponse .'", "'. $sWidth .'", "'. $sHeight .'", "'. $sFileType .'", "'. $sFileSize .'");
</script>';
exit();
