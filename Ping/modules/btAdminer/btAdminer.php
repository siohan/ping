<?php

#-------------------------------------------------------------------------------
#
# Module : btAdminer (c) 2011 - 2013 by blattertech informatik (info@blattertech.ch)
#          a Adminer extension for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/btadminer/
#          CMS Made Simple is (c) 2004-2010 by Ted Kulp
#          The projects homepage is: cmsmadesimple.org
# Version: 1.6.0
# File   : btAdminer.php
# Purpose: include the Adminer with own preferences
# License: GPL
#
#-------------------------------------------------------------------------------

$session_name = 'btAdminer';
session_name($session_name);
session_start();

if (!isset($_SESSION['ADM_user']) and !isset($_SESSION['ADM_server'])) {
	header("HTTP/1.0 403 Forbidden");
	if ($_GET['lang'] == "de") {
		echo "
			<html>
				<head>
				<title>403 Zugriff nicht erlaubt</title>
				</head>
			<body>
				<p>Sie haben keinen Zugriff auf diese Datei.<br />
				Möglicherweise ist Ihre Session abgelaufen. <br />
				Bitte loggen Sie sich neu ein oder laden sie die Modulseite neu.</p>
			</body>
			</html>
		";
	}
	else {
		echo "
			<html>
				<head>
				<title>403 Forbidden</title>
				</head>
			<body>
				<p>You have no access. Please login or reload modul in Backend.</p>
			</body>
			</html>
		";
	}
	exit;
}

function adminer_object() {

		// required to run any plugin
	include_once "./adminer/plugins/plugin.php";

		// autoloader
	foreach (glob("./adminer/plugins/*.php") as $filename) {
		include_once "./$filename";
	}

	$plugins = array(
			// specify enabled plugins here
		new AdminerFrames, new AdminerVersionNoverify
	);

	if (isset($_SESSION['ADM_plugin_zipexport']) and $_SESSION['ADM_plugin_zipexport'] == 1) $plugins[] = new AdminerDumpZip;
	if (isset($_SESSION['ADM_plugin_xmlexport']) and $_SESSION['ADM_plugin_xmlexport'] == 1) $plugins[] = new AdminerDumpXml;
	if (isset($_SESSION['ADM_plugin_foreign']) and $_SESSION['ADM_plugin_foreign'] == 1) $plugins[] = new AdminerEditForeign;
	if (isset($_SESSION['ADM_plugin_textarea']) and $_SESSION['ADM_plugin_textarea'] == 1) $plugins[] = new AdminerEditTextarea;
	if (isset($_SESSION['ADM_plugin_enum']) and $_SESSION['ADM_plugin_enum'] == 1) $plugins[] = new AdminerEnumOption;


	class AdminerSoftware extends AdminerPlugin {

		function name() {
			// custom name in title and heading
			if (isset($_SESSION['ADM_prog']) and $_SESSION['ADM_prog'] == "editor")
				return 'btAdminer Editor';
			else
				return 'btAdminer';
		}

		function permanentLogin() {
			// key used for permanent login
			return "74b941992ef29727ccabf82889fe837a";
		}

		function credentials() {
			// server, username and password for connecting to database
			return array(
				$_SESSION['ADM_server'], $_SESSION['ADM_user'], $_SESSION['ADM_password']
			);
		}

		function database() {
			// database name, will be escaped by Adminer
			return $_SESSION['ADM_db'];
		}

		/** Prints table list in menu
		 * @param array
		 * @return null
		 */
		function tablesPrint($tables) {
			echo '<p id="tables">' . "\n";
			foreach ($tables as $table => $type) {
				echo '<span class="tables-line';
				if ($_GET["select"] == $table or $_GET["table"] == $table) {
					echo '-active';
				}
				echo '">';
				echo '<a href="' . h(ME) . 'select=' . urlencode($table) . '"' . bold($_GET["select"] == $table) . ">" .
					lang('select') . "</a> ";
				echo '<a href="' . h(ME) . 'table=' . urlencode($table) . '"' . bold($_GET["table"] == $table) . ">" .
					$this->tableName(array(
										  "Name" => $table
									 )) . "</a></span>\n"; //! Adminer::tableName may work with full table status
			}
			echo '</p>';
		}

		/** Print homepage
		 * @return bool whether to print default homepage
		 */
		function homepage() {
			echo '<p class="tabs">' . ($_GET["ns"] == "" ? '<a href="' . h(ME) . 'database=">' . lang('Alter database') . "</a>\n" : "");
			if (support("scheme")) {
				echo"<a href='" . h(ME) . "scheme='>" . ($_GET["ns"] != "" ? lang('Alter schema') : lang('Create schema')) .
					"</a>\n";
			}
			return true;
		}


	}

	return new AdminerSoftware($plugins);
}

include './adminer/adminer-3.7.1-mysql.php';
