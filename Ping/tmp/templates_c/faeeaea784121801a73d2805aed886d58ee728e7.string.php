<?php /* Smarty version Smarty-3.1.16, created on 2014-12-15 07:50:38
         compiled from "faeeaea784121801a73d2805aed886d58ee728e7" */ ?>
<?php /*%%SmartyHeaderCode:1748908982548e84bec14714-03075023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'faeeaea784121801a73d2805aed886d58ee728e7' => 
    array (
      0 => 'faeeaea784121801a73d2805aed886d58ee728e7',
      1 => 0,
      2 => 'string',
    ),
  ),
  'nocache_hash' => '1748908982548e84bec14714-03075023',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.16',
  'unifunc' => 'content_548e84bec97789_81300591',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_548e84bec97789_81300591')) {function content_548e84bec97789_81300591($_smarty_tpl) {?><?php if (!is_callable('smarty_function_root_url')) include '/Applications/MAMP/htdocs/rc1/plugins/function.root_url.php';
?>/*
  @Nuno Costa [criacaoweb.net] Utils CSS.
  @Licensed under GPL2 and MIT.
  @Status: Stable
  @Version: 0.1-20090418
  
  @Contributors:
        -  http://meyerweb.com/eric/tools/css/reset/index.html 
  
  --------------------------------------------------------------- 
*/
/* From: http://meyerweb.com/eric/tools/css/reset/index.html  (Original) */
/* v1.0 | 20080212 */
html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, font, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td {
	margin: 0;
	padding: 0;
	border: 0;
	outline: 0;
	font-size: 100%;
	vertical-align: baseline;
	background: transparent;
}
/*
Stantby for nowbody {
	line-height: 1;
}
*/
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before,
blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
/* remember to define focus styles! */
:focus {
	outline: 0;
}
/* remember to highlight inserts somehow! */
ins {
	text-decoration: none;
}
del {
	text-decoration: line-through;
}
/* tables still need 'cellspacing="0"' in the markup */
table {
	border-collapse: collapse;
	border-spacing: 0;
}
/* ------- @Nuno Costa [criacaoweb.net] Utils CSS. ---------- */
* {
	font-weight: inherit;
	font-style: inherit;
	font-family: inherit;
}
dfn {
	display: none;
	overflow: hidden;
}
/* ----------- Clear Floated Elements ----------- */
html body .util-clearb {
	background: none;
	border: 0;
	clear: both;
	display: block;
	float: none;
	font-size: 0;
	margin: 0;
	padding: 0;
	position: static;
	overflow: hidden;
	visibility: hidden;
	width: 0;
	height: 0;
}
/* ----------- Fix to Clear Floated Elements ----------- */
.util-clearfix:after {
	clear: both;
	content: '.';
	display: block;
	visibility: hidden;
	height: 0;
}
.util-clearfix {
	display: inline-block;
}
* html .util-clearfix {
	height: 1%;
}
.util-clearfix {
	display: block;
}
/* Stylesheet: ncleanblueutils Modified On 2009-05-11 02:38:10 */
/*
  @Nuno Costa [criacaoweb.net] Core CSS.
  @Licensed under GPL and MIT.
  @Status: Stable
  @Version: 0.1-20090418
  
  @Contributors:
  
  --------------------------------------------------------------- 
*/
/*----------- Global Containers ----------- */
/* 
.core-wrap-100   =  width - 100% of Browser Fluid
.core-wrap-960   =  width - 960px  - fixed
.core-wrap-780   =  width - 780px  - fixed
.custom-wrap-x   =  width -  custom   - declared in another css (your site css)
*/
.core-wrap-100 {
	width: 100%;
}
.core-wrap-960 {
	width: 960px;
}
.core-wrap-780 {
	width: 780px;
}
.core-wrap-100,
.core-wrap-960,
.core-wrap-780,
.custom-wrap-x {
	margin-left: auto;
	margin-right: auto;
}
/*----------- Global Float ----------- */
.core-wrap-100  .core-float-left,
.core-wrap-960  .core-float-left,
.core-wrap-780  .core-float-left,
.custom-wrap-x  .core-float-left {
	float: left;
	display: inline;
}
.core-wrap-100  .core-float-right,
.core-wrap-960  .core-float-right,
.core-wrap-780  .core-float-right,
.custom-wrap-x  .core-float-right {
	float: right;
	display: inline;
}
/*----------- Global Center ----------- */
.core-wrap-100   .core-center,
.core-wrap-960   .core-center,
.core-wrap-780   .core-center,
.custom-wrap-x   .core-center {
	margin-left: auto;
	margin-right: auto;
}
/* Stylesheet: ncleanbluecore Modified On 2009-05-11 02:35:43 */
/*  
@Nuno Costa [criacaoweb.net]
@Since [cmsms 1.6]
@Contributors: Mark and Dev-Team
*/
body {
/* default text for entire site */
	font: normal 0.8em Tahoma, Verdana, Arial, Helvetica, sans-serif;
/* default text color for entire site */
	color: #3A3A36;
/* you can set your own image and background color here */
	background: #fff url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__full.png) repeat-x scroll left top;
}
/* Mask helper  for browsers ZOOM, Rezise and Decrease */
#ncleanblue {
/* set to width of viewport */
	width: auto;
/* you can set your own image and background color here */
	background: #fff url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__full.png) repeat-x scroll left top;
}
/* wiki style external links */
/* external links will have "(external link)" text added, lets hide it */
a.external span {
	position: absolute;
	left: -5000px;
	width: 4000px;
}
a.external {
/* make some room for the image, css shorthand rules, read: first top padding 0 then right padding 12px then bottom then right */
	padding: 0 12px 0 0;
}
/* colors for external links */
a.external:link {
	color: #679EBC;
/* background image for the link to show wiki style arrow */
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/external.gif) no-repeat 100% -100px;
}
a.external:visited {
	color: #18507C;
/* a different color can be used for visited external links */
/* Set the last 0 to -100px to use that part of the external.gif image for different color for active links external.gif is actually 300px tall, we can use different positions of the image to simulate rollover image changes.*/
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/external.gif) no-repeat 100% -100px;
}
a.external:hover {
	color: #18507C;
/* Set the last 0 to -200px to use that part of the external.gif image for different color on hover */
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/external.gif) no-repeat 100% 0;
	background-color: inherit;
}
/* end wiki style external links */
/* hr and anything with the class of accessibility is hidden with CSS from visual browsers */
.accessibility, hr {
/* absolute lets us put it outside the viewport with the indents, the rest is to clear all defaults */
	position: absolute;
	top: -9999em;
	left: -9999em;
	background: none;
	border: 0;
	clear: both;
	display: block;
	float: none;
	font-size: 0;
	margin: 0;
	padding: 0;
	overflow: hidden;
	visibility: hidden;
	width: 0;
	height: 0;
	border: none;
}
/* ------------ Standard  HTML elements and their default settings ------------ */
b, strong{font-weight: bold;}i, em{	font-style: italic;}
p {
	padding: 0;
	margin-top: 0.5em;
    margin-bottom: 1em;
   text-align:left;
}
h1, h2, h3, h4, h5 {
	line-height: 1.6em;
	font-weight: normal;
	width: auto;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
}
/*default link styles*/
a {
	color: #679EBC;
	text-decoration: none;
	text-align: left;
}
a:hover {
	color: #3A6B85;
}
a:active {
	color: #3A6B85;
}
a:visited {
	color: #679EBC;
}
input, textarea, select {
	font-size: 0.95em;
}
/* ------------ Wrapper ------------ */
div#pagewrapper {
	font-size: 95%;
	position: relative;
	z-index: 1;
}
/* ------------ Header ------------ */
#header {
	height: 111px;
	width: 960px;
}
#logo a {
/* adjust according your image size */
	height: 75px;
	width: 215px;
/* forces full link size */
	display: block;
/* this hides the text */
	text-indent: -9999em;
	margin-top: 0;
	margin-left: 0;
/* you can set your own image here, note size adjustments */
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/logo.png) no-repeat left top;
}
/* ------------ Header - Search ------------ */
div#search {
	width: 190px;
	height: 28px;
	margin-top: 31px;
	margin-right: 20px;
}
div#search label {
	text-indent: -9999em;
	height: 0pt;
	width: 0pt;
	display: none;
}
div#search input.search-input {
/* specific size for image, your image may need these adjusted */
	width: 143px;
	height: 17px;
/* removes default borders, allows use of image */
	border-style: none;
/* text color */
	color: #999;
/* padding of text */
	padding: 7px 0px 4px 10px;
	float: left;
/* set all font properties at once, weight, size, family */
	font: bold 0.9em Arial, Helvetica, sans-serif;
/* left input image, set your own here */
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/search.png) no-repeat left top;
}
div#search input.search-button {
/* specific size for image, your image may need these adjusted */
	width: 37px;
	height: 28px;
/* removes default borders, allows use of image */
	border-style: none;
/* hides text, image has text */
	text-indent: -9999em;
	float: left;
	margin: 0;
/* provides positive hover effect */
	cursor: pointer;
/* removes default size/height */
	font-size: 0px;
	line-height: 0px;
/* submit button image, set your own here */
	background: transparent url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/search.png) no-repeat right top;
}
/* ------------ Content ------------ */
#content {
	width: auto;
/* all text in #content will default align left, changed in other calls */
	text-align: left;
}
#bar {
	width: auto;
	height: 40px;
	padding-right: 1em;
	padding-left: 1em;
}
.print {
	margin-right: 75px;
	margin-top: 10px;
}
#version {
	width: 50px;
	height: 31px;
	position: absolute;
	z-index: 5;
	top: 130px;
	right: -16px;
	font-size: 1.6em;
	font-weight: bold;
	padding: 28px 15px;
	color: #FFF;
	text-align: center;
	vertical-align: middle;
	background:  url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/version.png) no-repeat left top;
}
/* IE6 fixes */
* html div#version {
	top: 150px;
}
/* End IE6 fixes */
/* Site Title */
h1.title {
	font-size: 1.8em;
	color: #666666;
	margin-bottom: 0.5em;
}
/* Breadcrumbs */
div.breadcrumbs {
	padding: 0.5em 0;
	font-size: 80%;
	margin: 0 1em;
}
div.breadcrumbs span.lastitem {
	font-weight: bold;
}
/* ------------ Side Bar (Left) ------------ */
#left {
	width: 250px;
}
/* Image that Represents the new CMS design */
#left .screen {
	margin: 10px 50px;
}
/* End  */
.sbar-title {
	font: bold 1.2em Arial, Helvetica, sans-serif;
	color: #252523;
}
.sbar-top {
	height: 20px;
	width: auto;
	padding: 10px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__content.png) no-repeat left top;
}
.sbar-main {
	width: auto;
	border-right: 1px solid #E2E2E2;
	border-left: 1px solid #E2E2E2;
	background: #F0F0F0;
}
span.sbar-bottom {
	width: auto;
	display: block;
	height: 10px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__content.png) no-repeat left bottom;
}
/* ------------ Main (Right) ------------ */
#main {
	width: 690px;
}
.main-top {
	height: 15px;
	width: auto;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__content.png) no-repeat right top;
}
.main-main {
	width: auto;
	border-right: 1px solid #E2E2E2;
	border-left: 1px solid #E2E2E2;
	background: #F0F0F0;
	padding: 20px;
	padding-top: 0px;
}
.main-bottom {
	width: auto;
	height: 41px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__content.png) no-repeat right bottom;
}
.right49, .left49 {
	font-size: 0.85em;
	margin: 7px 5px 5px 10px;
	font-weight: bold;
}
.left49 span {
	display: block;
	padding-top: 1px;
}
.left49 a {
	font-weight: normal;
}
.right49 {
	height: 28px;
	width: 50px;
	padding-right: 10px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bull.png) no-repeat right top;
}
.right49 a, .right49 a:visited {
	padding: 7px 4px;
	display: block;
	color: #000;
	height: 15px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bull.png) no-repeat  left top;
}
#main h2,
#main h3,
#main h4,
#main h5,
#main h6 {
	font-size: 1.4em;
	color: #301E12;
}
div#main ul,
div#main ol,
div#main dl,
#footer ul,
#footer ol {
	line-height: 1em;
	margin: 0 0 1.5em 0;
}
div#main ul,
#footer ul {
	list-style: circle;
}
div#main ul li,
div#main ol li,
#footer ul li,
#footer ol li {
	padding: 2px 2px 2px 5px;
	margin-left: 20px;
}
/* definition lists topics on bold */
div#main dl dt {
	font-weight: bold;
	margin: 0 0 0 1em;
}
div#main dl dd {
	margin: 0 0 1em 1em;
}
div#main dl {
	margin-bottom: 2em;
	padding-bottom: 1em;
	border-bottom: 1px solid #c0c0c0;
}
/* ------------ Footer ------------ */
#footer-wrapper {
	min-height: 235px;
	height: auto!important;
	height: 235px;
	width: auto;
	margin-top: 5px;
	text-align: center;
	margin-right: 00px;
	margin-left: 0px;
	background: #7CA3B5 url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__footer.png) repeat-x left top;
}
#footer {
	color: #FFF;
	font-size: 0.8em;
	min-height: 235px;
	height: auto!important;
	height: 235px;
	background: #7CA3B5 url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/bg__footer.png) repeat-x left top;
}
#footer .block {
	width: 300px;
	margin: 20px 10px 10px;
}
#footer .cms {
	text-align: right;
}
/* ------------ Footer Links ------------ */
#footer ul {
	width: auto;
	text-align: left;
	margin-left: 50px;
}
#footer ul ul {
	margin-left: 0px;
}
#footer ul li a {
	color: #FFF;
	display: block;
	font-weight: normal;
	margin-bottom: 0.5em;
	text-decoration: none;
}
#footer a {
	color: #DCEDF1;
	text-decoration: underline;
	font-weight: bold;
}
/* ------------ END LAYOUT ---------------*/
/* ------------  Menu  ROOT  ------------ */
.page-menu {
	width: auto;
	height: 35px;
	margin: 3px 0 0 20px;
}
.menuwrapper {}

ul#primary-nav li hr.menu_separator{
        position: relative;
        visibility: hidden;
        display:block;
        width:5px;
       	height: 32px;
       	margin: 0px 5px 0px;
}
.page-menu ul#primary-nav {
	height: 1%;
	float: left;
	list-style: none;
	padding: 0;
	margin: 0;
}
.page-menu ul#primary-nav li {
	float: left;
}
.page-menu ul#primary-nav li a,
.page-menu ul#primary-nav li a span {
	display: block;
	padding: 0 10px;
	background-repeat: no-repeat;
	background-image: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/tabs.gif);
}
.page-menu ul#primary-nav li a {
	padding-left: 0;
	color: #000;
	font-weight: bold;
	line-height: 2.15em;
	text-decoration: none;
	margin-left: 1px;
	font-size: 0.85em;
}
.page-menu ul#primary-nav li a:hover,
.page-menu ul#primary-nav li a:active {
	color: #000;
}
.page-menu ul#primary-nav li a.menuactive,
.page-menu ul#primary-nav li a:hover span {
	color: #000;
}
.page-menu ul#primary-nav li a span {
	padding-top: 6px;
	padding-right: 0;
	padding-bottom: 5px;
}
.page-menu ul#primary-nav li a.menuparenth,
.page-menu ul#primary-nav li a.menuactive,
.page-menu ul#primary-nav li a:hover,
.page-menu ul#primary-nav li a:focus,
.page-menu ul#primary-nav li a:active {
	background-position: 100% -120px;
}
.page-menu ul#primary-nav li a {
	background-position: 100% -80px;
}
.page-menu ul#primary-nav li a.menuactive span,
.page-menu ul#primary-nav li a:hover span,
.page-menu ul#primary-nav li a:focus span,
.page-menu ul#primary-nav li a:active span {
	background-position: 0 -40px;
}
.page-menu ul#primary-nav li a span {
	background-position: 0 0;
}
.page-menu ul#primary-nav .sectionheader,
.page-menu ul#primary-nav li a:link.menuactive,
.page-menu ul#primary-nav li a:visited.menuactive {
/* @ Opera, use pseudo classes otherwise it confuses cursor... */
	cursor: text;
}
.page-menu ul#primary-nav li span,
.page-menu ul#primary-nav li a,
.page-menu ul#primary-nav li a:hover,
.page-menu ul#primary-nav li a:focus,
.page-menu ul#primary-nav li a:active {
/* @ Opera, we need to be explicit again here now... */
	cursor: pointer;
}
/* Additional IE specific bug fixes... */
* html .page-menu ul#primary-nav {
	display: inline-block;
}
*:first-child+html .page-menu ul#primary-nav {
	display: inline-block;
}
/* --------------------  menu dropdow  -------------------------
/* Unless you know what you do, do not touch this */
/* Reset all ROOT menu styles. */
ul#primary-nav ul.unli li li a span,
ul#primary-nav ul.unli li a span,
ul#primary-nav .menuparent .unli .menuparent .unli li a span {
	font-weight: normal;
	background-image: none;
	display: block;
	padding-top: 0px;
	padding-left: 0px;
	padding-right: 0px;
	padding-bottom: 0px;
}
#primary-nav {
	margin: 0px;
	padding: 0px;
}
#primary-nav ul {
	list-style: none;
	margin: -6px 0px 0px;
	padding: 0px;
/* Set the width of the menu elements at second level. Leaving first level flexible. */
	width: 209px;
}
#primary-nav ul {
	position: absolute;
	z-index: 1001;
	top: auto;
	display: none;
	padding-top: 9px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/ultop.png) no-repeat left top;
}
* html #primary-nav ul.unli {
	padding-top: 12px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/ultop.gif) no-repeat left top;
}
#primary-nav ul.unli ul {
	margin-left: -7px;
	left: 100%;
	top: 3px;
}
* html #primary-nav ul.unli ul {
	margin-left: -0px;
}
#primary-nav li {
	margin: 0px;
	float: left;
}
#primary-nav li li {
	margin-left: 7px;
	margin-top: -1px;
	float: none;
	position: relative;
}
/* Styling the basic appearance of the menu elements */
ul#primary-nav ul hr.menu_separator{
        position: relative;
        visibility: visible;
        display:block;
        width:130px;
       	height: 1px;
       	margin: 2px 30px 2px;
	padding: 0em;
	border-bottom: 1px solid #ccc;
	border-top-width: 0px;
	border-right-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-left-style: none;
}
#primary-nav .separator,
#primary-nav .separatorh {
	height: 9px;
	width: 209px;
	margin: 0px 0px -8px;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/ulbtm.png) no-repeat left bottom;
}
* html #primary-nav .separator {
       z-index:-1;
	background: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/ulbtm.gif) no-repeat left bottom;
}
*:first-child+html #primary-nav .separator {
       z-index:-1;
}
#primary-nav ul.unli li a {
	padding: 0px 10px;
	width: 165px;
	margin: 5px;
	background-image: none;
}
* html #primary-nav ul.unli li a {
	padding: 0px 10px 0px 5px;
	width: 165px;
	margin: 5px 0px;
}
#primary-nav li li a:hover {
	background-color: #DBE7F2;
}
/* Styling the basic appearance of the active page elements (shows what page in the menu is being displayed) */
#primary-nav li.menuactive li a {
	text-decoration: none;
	background: none;
}
#primary-nav ul.unli li.menuparenth,
#primary-nav ul.unli a:hover,
#primary-nav ul.unli a.menuactive {
	background-color: #DBE7F2;
}
/* Styling the basic apperance of the menuparents - here styled the same on hover (fixes IE bug) */
#primary-nav ul.unli li .menuparent,
#primary-nav ul.unli li .menuparent:hover,
#primary-nav ul.unli li .menuparent,
#primary-nav .menuactive.menuparent .unli .menuactive.menuparent .menuactive.menuparent {
	background-image: url(<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
/uploads/NCleanBlue/arrow.gif);
	background-position: center right;
	background-repeat: no-repeat;
}
/* The magic - set to work for up to a 3 level menu, but can be increased unlimited */
#primary-nav ul,
#primary-nav li:hover ul,
#primary-nav li:hover ul ul,
#primary-nav li:hover ul ul ul,
#primary-nav li.menuparenth ul,
#primary-nav li.menuparenth ul ul,
#primary-nav li.menuparenth ul ul ul {
	display: none;
}
#primary-nav li:hover ul,
#primary-nav ul li:hover ul,
#primary-nav ul ul li:hover ul,
#primary-nav ul ul ul li:hover ul,
#primary-nav li.menuparenth ul,
#primary-nav ul li.menuparenth ul,
#primary-nav ul ul li.menuparenth ul,
#primary-nav ul ul ul li.menuparenth ul {
	display: block;
}
/* IE Hacks */
#primary-nav li li {
	float: left;
	clear: both;
}
#primary-nav li li a {
	height: 1%;
}
/*************** End Menu *****************/
/* ------------ News Module ------------ */
#news {
	padding: 10px;
}
.NewsSummary {
}
.NewsSummaryPostdate,
.NewsSummaryCategory,
.NewsSummaryAuthor {
	font-style: italic;
	font-size: 0.8em;
}
.NewsSummaryLink {
	margin: 2px 0;
}
.NewsSummaryContent {
	margin: 10px 0;
}
.NewsSummaryMorelink {
	margin: 5px 0 15px;
}
/* ------------ End News Module ------------ */
/* Stylesheet: Layout: NCleanBlue Modified On 2009-07-22 17:39:51 */
<?php }} ?>
