<?php

if (!function_exists("cmsms")) exit;

if (!isset($_GET["modulename"])) exit;
if (!isset($_GET["method"])) exit;

$output = "";

$module = $this->GetModuleInstance($_GET["modulename"]);
if ($module != false) {
	if (method_exists($module, "AuthenticateAjaxMSCall")) {
		if ($module->AuthenticateAjaxMSCall($_GET["method"])) {
			if (method_exists($module, $_GET["method"])) {
				$vars = array();
				foreach ($_GET as $var => $value) {
					if ($var == "modulename")
						continue;
					if ($var == "method")
						continue;

					$vars[$var] = $value; //base64_decode
				}
				$output = $module->$_GET["method"]($vars);
			} else {
				$output = $this->Lang("methodnotfound", array($_GET["method"], $_GET["modulename"]));
			}
		} else {
			$output = $this->Lang("methodfailedauthentication", array($_GET["modulename"], $_GET["method"]));
		}
	} else {
		$output = $this->Lang("modulecannotauthenticate", array($_GET["modulename"]));
	}
} else {
	$output = $this->Lang("modulenotfound", array($_GET["modulename"]));
}

echo $output;
die();
?>
