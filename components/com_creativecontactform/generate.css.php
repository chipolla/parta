<?php
/**
 * Joomla! component Creative Contact Form
 *
 * @version $Id: 2012-04-05 14:30:25 svn $
 * @author creative-solutions.net
 * @package Creative Contact Form
 * @subpackage com_creativecontactform
 * @license GNU/GPL
 *
 */

// no direct access
define('_JEXEC',true);
defined('_JEXEC') or die('Restircted access');
/*
 * This is external PHP file and used on AJAX calls, so it has not "defined('_JEXEC') or die;" part.
 */

error_reporting(0);
header('Content-Type: text/css');
include '../../configuration.php';

$config = new JConfig;

//conects to datababse
mysql_connect($config->host, $config->user, $config->password);
mysql_select_db($config->db);
mysql_query("SET NAMES utf8");

$id_form = isset($_GET['id_form']) ? (int)$_GET['id_form'] : 0;

$query = 
						'SELECT '.
						'st.styles styles '.
					'FROM '.
						'`'.$config->dbprefix.'creative_forms` sp '.
					'LEFT JOIN '.
						'`'.$config->dbprefix.'contact_templates` st ON st.id = sp.id_template ';
$query .=
					'WHERE sp.published = \'1\' AND sp.id = \''.$id_form.'\' ';

$result = mysql_query($query);
$row = mysql_fetch_assoc($result);
$styles_value = $row['styles'];

$styles_array = explode('|',$styles_value);
$styles = array();
foreach ($styles_array as $val) {
	$arr = explode('~',$val);
	$styles[$arr[0]] = $arr[1];
}

?>
.creative_form_<?php echo $id_form;?>,.creative_form_<?php echo $id_form;?> h1,.creative_form_<?php echo $id_form;?> h2,.creative_form_<?php echo $id_form;?> h3 {
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[131];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper {
	border: <?php echo $styles[2];?>px <?php echo $styles[3];?> <?php echo $styles[1];?>;
	background-color: <?php echo $styles[0];?>;
	<?php if($styles[627] == '1') {?>
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[0];?>', endColorstr='<?php echo $styles[130];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[0];?>), to(<?php echo $styles[130];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[0];?>, <?php echo $styles[130];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[0];?>, <?php echo $styles[130];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[0];?>, <?php echo $styles[130];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[0];?>, <?php echo $styles[130];?>);/* Opera 11.10+ */
	<?php }?>
	
	-moz-box-shadow: <?php echo $styles[9];?> <?php echo $styles[10];?>px <?php echo $styles[11];?>px <?php echo $styles[12];?>px <?php echo $styles[13];?>px  <?php echo $styles[8];?>;
	-webkit-box-shadow: <?php echo $styles[9];?> <?php echo $styles[10];?>px <?php echo $styles[11];?>px <?php echo $styles[12];?>px <?php echo $styles[13];?>px  <?php echo $styles[8];?>;
	box-shadow: <?php echo $styles[9];?> <?php echo $styles[10];?>px <?php echo $styles[11];?>px <?php echo $styles[12];?>px <?php echo $styles[13];?>px  <?php echo $styles[8];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[4];?>px;
	-moz-border-radius-topleft: <?php echo $styles[4];?>px;
	border-top-left-radius: <?php echo $styles[4];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[5];?>px;
	-moz-border-radius-topright: <?php echo $styles[5];?>px;
	border-top-right-radius: <?php echo $styles[5];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[6];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[6];?>px;
	border-bottom-left-radius: <?php echo $styles[6];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[7];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[7];?>px;
	border-bottom-right-radius: <?php echo $styles[7];?>px;

	color: <?php echo $styles[587]?>;
	font-size: <?php echo $styles[588]?>px;

}
.creative_form_<?php echo $id_form;?> .creativecontactform_header {
	-webkit-border-top-left-radius: <?php echo $styles[4];?>px;
	-moz-border-radius-topleft: <?php echo $styles[4];?>px;
	border-top-left-radius: <?php echo $styles[4];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[5];?>px;
	-moz-border-radius-topright: <?php echo $styles[5];?>px;
	border-top-right-radius: <?php echo $styles[5];?>px;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_footer {
	-webkit-border-bottom-left-radius: <?php echo $styles[6];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[6];?>px;
	border-bottom-left-radius: <?php echo $styles[6];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[7];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[7];?>px;
	border-bottom-right-radius: <?php echo $styles[7];?>px;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_loading_wrapper {
	-webkit-border-top-left-radius: <?php echo $styles[4];?>px;
	-moz-border-radius-topleft: <?php echo $styles[4];?>px;
	border-top-left-radius: <?php echo $styles[4];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[5];?>px;
	-moz-border-radius-topright: <?php echo $styles[5];?>px;
	border-top-right-radius: <?php echo $styles[5];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[6];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[6];?>px;
	border-bottom-left-radius: <?php echo $styles[6];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[7];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[7];?>px;
	border-bottom-right-radius: <?php echo $styles[7];?>px;
}
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper:hover {
	-moz-box-shadow: <?php echo $styles[15];?> <?php echo $styles[16];?>px <?php echo $styles[17];?>px <?php echo $styles[18];?>px <?php echo $styles[19];?>px  <?php echo $styles[14];?>;
	-webkit-box-shadow: <?php echo $styles[15];?> <?php echo $styles[16];?>px <?php echo $styles[17];?>px <?php echo $styles[18];?>px <?php echo $styles[19];?>px  <?php echo $styles[14];?>;
	box-shadow: <?php echo $styles[15];?> <?php echo $styles[16];?>px <?php echo $styles[17];?>px <?php echo $styles[18];?>px <?php echo $styles[19];?>px  <?php echo $styles[14];?>;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_header {
	padding:  <?php echo $styles[603];?>px  <?php echo $styles[604];?>px <?php echo $styles[605];?>px <?php echo $styles[606];?>px;
	border-bottom: <?php echo $styles[607];?>px <?php echo $styles[608];?> <?php echo $styles[609];?>;

	<?php if($styles[600] == '1') {?>
	background-color: <?php echo $styles[601];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[601];?>', endColorstr='<?php echo $styles[602];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[601];?>), to(<?php echo $styles[602];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[601];?>, <?php echo $styles[602];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[601];?>, <?php echo $styles[602];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[601];?>, <?php echo $styles[602];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[601];?>, <?php echo $styles[602];?>);/* Opera 11.10+ */
	<?php }?>

}
.creative_form_<?php echo $id_form;?> .creativecontactform_body {
	padding:  <?php echo $styles[613];?>px  <?php echo $styles[614];?>px <?php echo $styles[615];?>px <?php echo $styles[616];?>px;

	<?php if($styles[610] == '1') {?>
	background-color: <?php echo $styles[611];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[611];?>', endColorstr='<?php echo $styles[612];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[611];?>), to(<?php echo $styles[612];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[611];?>, <?php echo $styles[612];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[611];?>, <?php echo $styles[612];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[611];?>, <?php echo $styles[612];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[611];?>, <?php echo $styles[612];?>);/* Opera 11.10+ */
	<?php }?>
}
.creative_form_<?php echo $id_form;?> .creativecontactform_footer {
	padding:  <?php echo $styles[620];?>px  <?php echo $styles[621];?>px <?php echo $styles[622];?>px <?php echo $styles[623];?>px;
	border-top: <?php echo $styles[624];?>px <?php echo $styles[625];?> <?php echo $styles[626];?>;

	<?php if($styles[617] == '1') {?>
	background-color: <?php echo $styles[618];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[618];?>', endColorstr='<?php echo $styles[619];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[618];?>), to(<?php echo $styles[619];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[618];?>, <?php echo $styles[619];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[618];?>, <?php echo $styles[619];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[618];?>, <?php echo $styles[619];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[618];?>, <?php echo $styles[619];?>);/* Opera 11.10+ */
	<?php }?>
}


.creative_form_<?php echo $id_form;?> .creativecontactform_title {
	color: <?php echo $styles[20];?>;
	font-size: <?php echo $styles[21];?>px;
	font-style: <?php echo $styles[23];?>;
	font-weight: <?php echo $styles[22];?>;
	text-align: <?php echo $styles[25];?>;
	text-decoration: <?php echo $styles[24];?>;
	text-shadow: <?php echo $styles[28];?>px <?php echo $styles[29];?>px <?php echo $styles[30];?>px <?php echo $styles[27];?>;
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[506];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}

.creative_form_<?php echo $id_form;?> .creativecontactform_field_name {
	color: <?php echo $styles[31];?>;
	font-size: <?php echo $styles[32];?>px;
	font-style: <?php echo $styles[34];?>;
	font-weight: <?php echo $styles[33];?>;
	text-align: <?php echo $styles[36];?>;
	text-decoration: <?php echo $styles[35];?>;
	text-shadow: <?php echo $styles[38];?>px <?php echo $styles[39];?>px <?php echo $styles[40];?>px <?php echo $styles[37];?>;
	margin:  <?php echo $styles[215];?>px  <?php echo $styles[216];?>px <?php echo $styles[217];?>px <?php echo $styles[218];?>px;
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[507];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}

.creative_form_<?php echo $id_form;?> .answer_name label {
	color: <?php echo $styles[31];?>;
	font-size: <?php echo $styles[32] - 1;?>px;
	font-style: <?php echo $styles[34];?>;
	font-weight: <?php echo $styles[33];?>;
	text-decoration: <?php echo $styles[35];?>;
	text-shadow: <?php echo $styles[38];?>px <?php echo $styles[39];?>px <?php echo $styles[40];?>px <?php echo $styles[37];?>;
}
.creative_form_<?php echo $id_form;?> .answer_name label.without_parent_label {
	font-size: <?php echo $styles[32];?>px;
}

.creative_form_<?php echo $id_form;?> .creative_uploaded_file {
	color: <?php echo $styles[31];?>;
	font-size: <?php echo $styles[32] - 1;?>px;
	font-style: <?php echo $styles[34];?>;
	font-weight: <?php echo $styles[33];?>;
	text-decoration: <?php echo $styles[35];?>;
	text-shadow: <?php echo $styles[38];?>px <?php echo $styles[39];?>px <?php echo $styles[40];?>px <?php echo $styles[37];?>;
}

.creative_form_<?php echo $id_form;?> .creativecontactform_field_required {
	color: <?php echo $styles[41];?>;
	font-size: <?php echo $styles[42];?>px;
	font-style: <?php echo $styles[44];?>;
	font-weight: <?php echo $styles[43];?>;
	text-shadow: <?php echo $styles[47];?>px <?php echo $styles[48];?>px <?php echo $styles[49];?>px <?php echo $styles[46];?>;
}

.creative_form_<?php echo $id_form;?> .creativecontactform_send,
.creative_form_<?php echo $id_form;?> .creativecontactform_send_new,
.creative_form_<?php echo $id_form;?> .creative_fileupload
 {
	background-color: <?php echo $styles[91];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[91];?>', endColorstr='<?php echo $styles[50];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[91];?>), to(<?php echo $styles[50];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[91];?>, <?php echo $styles[50];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[91];?>, <?php echo $styles[50];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[91];?>, <?php echo $styles[50];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[91];?>, <?php echo $styles[50];?>);/* Opera 11.10+ */
	
	padding: <?php echo $styles[92];?>px <?php echo $styles[93];?>px;
	-moz-box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px  <?php echo $styles[94];?>;	
	-webkit-box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px  <?php echo $styles[94];?>;	
	box-shadow: <?php echo $styles[95];?> <?php echo $styles[96];?>px <?php echo $styles[97];?>px <?php echo $styles[98];?>px <?php echo $styles[99];?>px  <?php echo $styles[94];?>;	
	border-style: <?php echo $styles[127];?>;
	border-width: <?php echo $styles[101];?>px;
	border-color: <?php echo $styles[100];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[102];?>px;
	-moz-border-radius-topleft: <?php echo $styles[102];?>px;
	border-top-left-radius: <?php echo $styles[102];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[103];?>px;
	-moz-border-radius-topright: <?php echo $styles[103];?>px;
	border-top-right-radius: <?php echo $styles[103];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[104];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[104];?>px;
	border-bottom-left-radius: <?php echo $styles[104];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[105];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[105];?>px;
	border-bottom-right-radius: <?php echo $styles[105];?>px;
	float: <?php echo $styles[212];?>;

	font-size: <?php echo $styles[107];?>px;
	color: <?php echo $styles[106];?>;
	font-style: <?php echo $styles[109];?>;
	font-weight: <?php echo $styles[108];?>;
	text-decoration: <?php echo $styles[110];?>;
	text-shadow: <?php echo $styles[114];?>px <?php echo $styles[115];?>px <?php echo $styles[116];?>px <?php echo $styles[113];?>;
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[112];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}

.creative_form_<?php echo $id_form;?> .creative_fileupload
{
padding: <?php echo $styles[597];?>px <?php echo $styles[598];?>px;
}

.creative_form_<?php echo $id_form;?> .creativecontactform_send:hover,.creative_form_<?php echo $id_form;?> .creativecontactform_send_new:hover, 
.creative_form_<?php echo $id_form;?> .creativecontactform_send:active,.creative_form_<?php echo $id_form;?> .creativecontactform_send_new:active, 
.creative_form_<?php echo $id_form;?> .creativecontactform_send:focus,.creative_form_<?php echo $id_form;?> .creativecontactform_send_new:focus,

.creative_form_<?php echo $id_form;?> .creative_fileupload:hover,.creative_form_<?php echo $id_form;?> .creative_fileupload:hover, 
.creative_form_<?php echo $id_form;?> .creative_fileupload:active,.creative_form_<?php echo $id_form;?> .creative_fileupload:active, 
.creative_form_<?php echo $id_form;?> .creative_fileupload:focus,.creative_form_<?php echo $id_form;?> .creative_fileupload:focus

{
	background-color: <?php echo $styles[51];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[51];?>', endColorstr='<?php echo $styles[52];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[51];?>), to(<?php echo $styles[52];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[51];?>, <?php echo $styles[52];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[51];?>, <?php echo $styles[52];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[51];?>, <?php echo $styles[52];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[51];?>, <?php echo $styles[52];?>);/* Opera 11.10+ */
	
	color: <?php echo $styles[124];?>;
	text-shadow: <?php echo $styles[114];?>px <?php echo $styles[115];?>px <?php echo $styles[116];?>px <?php echo $styles[125];?>;
	-moz-box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px  <?php echo $styles[117];?>;
	-webkit-box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px  <?php echo $styles[117];?>;
	box-shadow: <?php echo $styles[118];?> <?php echo $styles[119];?>px <?php echo $styles[120];?>px <?php echo $styles[121];?>px <?php echo $styles[122];?>px  <?php echo $styles[117];?>;
	border-style: <?php echo $styles[127];?>;
	border-width: <?php echo $styles[101];?>px;
	border-color: <?php echo $styles[126];?>;
}
		        	
.creative_form_<?php echo $id_form;?> .creativecontactform_submit_wrapper {
	width: 	<?php echo $styles[209];?>%;
}

.creative_form_<?php echo $id_form;?> .creativecontactform_input_element input,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element textarea,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element{
	font-size: <?php echo $styles[148];?>px;
	color: <?php echo $styles[147];?>;
	font-style: <?php echo $styles[150];?>;
	font-weight: <?php echo $styles[149];?>;
	text-decoration: <?php echo $styles[151];?>;
	text-shadow: <?php echo $styles[154];?>px <?php echo $styles[155];?>px <?php echo $styles[156];?>px <?php echo $styles[153];?>;
	text-align: <?php echo $styles[500];?>;
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[152];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}

.creative_form_<?php echo $id_form;?> .creativecontactform_input_element:hover,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element:focus,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element.focused {
	background-color: <?php echo $styles[157];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[157];?>', endColorstr='<?php echo $styles[158];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[157];?>), to(<?php echo $styles[158];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[157];?>, <?php echo $styles[158];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[157];?>, <?php echo $styles[158];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[157];?>, <?php echo $styles[158];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[157];?>, <?php echo $styles[158];?>);/* Opera 11.10+ */
	
	-moz-box-shadow: <?php echo $styles[163];?> <?php echo $styles[164];?>px <?php echo $styles[165];?>px <?php echo $styles[166];?>px <?php echo $styles[167];?>px  <?php echo $styles[162];?>;
	-webkit-box-shadow: <?php echo $styles[163];?> <?php echo $styles[164];?>px <?php echo $styles[165];?>px <?php echo $styles[166];?>px <?php echo $styles[167];?>px  <?php echo $styles[162];?>;
	box-shadow: <?php echo $styles[163];?> <?php echo $styles[164];?>px <?php echo $styles[165];?>px <?php echo $styles[166];?>px <?php echo $styles[167];?>px  <?php echo $styles[162];?>;
	border-style: <?php echo $styles[136];?>;
	border-width: <?php echo $styles[135];?>px;
	border-color: <?php echo $styles[161];?>;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_input_element,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element.closed:hover {
	background-color: <?php echo $styles[132];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[132];?>', endColorstr='<?php echo $styles[133];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[132];?>), to(<?php echo $styles[133];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[132];?>, <?php echo $styles[133];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[132];?>, <?php echo $styles[133];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[132];?>, <?php echo $styles[133];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[132];?>, <?php echo $styles[133];?>);/* Opera 11.10+ */
	
	-moz-box-shadow: <?php echo $styles[142];?> <?php echo $styles[143];?>px <?php echo $styles[144];?>px <?php echo $styles[145];?>px <?php echo $styles[146];?>px  <?php echo $styles[141];?>;	
	-webkit-box-shadow: <?php echo $styles[142];?> <?php echo $styles[143];?>px <?php echo $styles[144];?>px <?php echo $styles[145];?>px <?php echo $styles[146];?>px  <?php echo $styles[141];?>;		
	box-shadow: <?php echo $styles[142];?> <?php echo $styles[143];?>px <?php echo $styles[144];?>px <?php echo $styles[145];?>px <?php echo $styles[146];?>px  <?php echo $styles[141];?>;		
	border-style: <?php echo $styles[136];?>;
	border-width: <?php echo $styles[135];?>px;
	border-color: <?php echo $styles[134];?>;
	
	-webkit-border-top-left-radius: <?php echo $styles[137];?>px;
	-moz-border-radius-topleft: <?php echo $styles[137];?>px;
	border-top-left-radius: <?php echo $styles[137];?>px;
	
	-webkit-border-top-right-radius: <?php echo $styles[138];?>px;
	-moz-border-radius-topright: <?php echo $styles[138];?>px;
	border-top-right-radius: <?php echo $styles[138];?>px;
	
	-webkit-border-bottom-left-radius: <?php echo $styles[139];?>px;
	-moz-border-radius-bottomleft: <?php echo $styles[139];?>px;
	border-bottom-left-radius: <?php echo $styles[139];?>px;
	
	-webkit-border-bottom-right-radius: <?php echo $styles[140];?>px;
	-moz-border-radius-bottomright: <?php echo $styles[140];?>px;
	border-bottom-right-radius: <?php echo $styles[140];?>px;

}
.creative_form_<?php echo $id_form;?> .creativecontactform_input_element input:hover,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element input:focus,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element textarea:hover,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element textarea:focus,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element.focused input,.creative_form_<?php echo $id_form;?> .creativecontactform_input_element.focused textarea {
	color: <?php echo $styles[159];?>;
	text-shadow: <?php echo $styles[154];?>px <?php echo $styles[155];?>px <?php echo $styles[156];?>px <?php echo $styles[160];?>;
}


.creative_form_<?php echo $id_form;?> .creativecontactform_error .creativecontactform_field_name,.creative_form_<?php echo $id_form;?> .creativecontactform_error .creativecontactform_field_name:hover {
	color: <?php echo $styles[171];?>;
	text-shadow: <?php echo $styles[173];?>px <?php echo $styles[174];?>px <?php echo $styles[175];?>px <?php echo $styles[172];?>;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_error .creativecontactform_input_element,.creative_form_<?php echo $id_form;?> .creativecontactform_error .creativecontactform_input_element:hover {
	background-color: <?php echo $styles[176];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[176];?>', endColorstr='<?php echo $styles[177];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[176];?>), to(<?php echo $styles[177];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[176];?>, <?php echo $styles[177];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[176];?>, <?php echo $styles[177];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[176];?>, <?php echo $styles[177];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[176];?>, <?php echo $styles[177];?>);/* Opera 11.10+ */
	
	-moz-box-shadow: <?php echo $styles[185];?> <?php echo $styles[186];?>px <?php echo $styles[187];?>px <?php echo $styles[188];?>px <?php echo $styles[189];?>px  <?php echo $styles[184];?>;	
	-webkit-box-shadow: <?php echo $styles[185];?> <?php echo $styles[186];?>px <?php echo $styles[187];?>px <?php echo $styles[188];?>px <?php echo $styles[189];?>px  <?php echo $styles[184];?>;		
	box-shadow: <?php echo $styles[185];?> <?php echo $styles[186];?>px <?php echo $styles[187];?>px <?php echo $styles[188];?>px <?php echo $styles[189];?>px  <?php echo $styles[184];?>;		
	border-color: <?php echo $styles[178];?>;
	
}
.creative_form_<?php echo $id_form;?> .creativecontactform_error input,.creative_form_<?php echo $id_form;?> .creativecontactform_error .creative_input_dummy_wrapper,.creative_form_<?php echo $id_form;?> .creativecontactform_error input:hover,.creative_form_<?php echo $id_form;?> .creativecontactform_error .focused input:hover,.creative_form_<?php echo $id_form;?> .creativecontactform_error .focused input,.creative_form_<?php echo $id_form;?> .creativecontactform_error .focused textarea,.creative_form_<?php echo $id_form;?> .creativecontactform_error textarea,.creative_form_<?php echo $id_form;?> .creativecontactform_error textarea:hover {
	
	color: <?php echo $styles[179];?>;
	text-shadow: <?php echo $styles[181];?>px <?php echo $styles[182];?>px <?php echo $styles[183];?>px <?php echo $styles[180];?>;
}

.creative_form_<?php echo $id_form;?> .creativecontactform_pre_text {
	margin-top: <?php echo $styles[190];?>px;
	margin-bottom: <?php echo $styles[191];?>;
	<?php $mr =$styles[502] == 'right' ? '0' : ($styles[502] == 'center' ? 'auto' : '0');?>
	<?php $ml = $styles[502] == 'right' ? 'auto' : ($styles[502] == 'center' ? 'auto' : '0');?>
	margin-right: <?php echo $mr;?>;
	margin-left: <?php echo $ml;?>;
	padding: <?php echo $styles[193];?>px 0 0 0;
	width: <?php echo $styles[192];?>%;
	
	font-size: <?php echo $styles[198];?>px;
	color: <?php echo $styles[197];?>;
	font-style: <?php echo $styles[200];?>;
	font-weight: <?php echo $styles[199];?>;
	text-decoration: <?php echo $styles[201];?>;
	text-shadow: <?php echo $styles[204];?>px <?php echo $styles[205];?>px <?php echo $styles[206];?>px <?php echo $styles[203];?>;
	text-align: <?php echo $styles[502];?>;
	
	border-top: <?php echo $styles[194];?>px <?php echo $styles[196];?> <?php echo $styles[195];?>;
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[202];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}


.creative_form_<?php echo $id_form;?> .creativecontactform_field_box_textarea_inner {
	<?php $box_margin = $styles[501] == 'right' ? '0 0 0 auto' : ($styles[501] == 'center' ? '0 auto' : '0');  ?>
	margin: <?php echo $box_margin;?>;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_field_box_inner {
	<?php $box_margin = $styles[501] == 'right' ? '0 0 0 auto' : ($styles[501] == 'center' ? '0 auto' : '0');  ?>
	margin: <?php echo $box_margin;?>;
}

.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper .tooltip_inner {
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[508];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper .creativecontactform_field_required {
	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[509];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>
}

/*************************************************RTL rules*******************************************************************************************/

<?php
if($styles[501] == 'right') {?>
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper .answer_name {
	float: right!important;
	text-align: right !important;
}
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper .answer_name label {
	margin: 6px 33px 0 0px;
}
.creative_form_<?php echo $id_form;?> .answer_input {
	float: right !important;
	margin-right: -100%;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_field_required {
	left: -12px !important;
}
.creative_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner {
left: 0 !important;
padding: 3px 16px 4px 8px;
text-align: right;
}
.creative_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:after,.creative_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:before {
	left: 0;
}
.creative_form_<?php echo $id_form;?> .creative_input_dummy_wrapper img.ui-datepicker-trigger {
	left: -29px;
}

/***fileupload**/
.creative_form_<?php echo $id_form;?> .creative_progress .bar {
float: right;
}
.creative_form_<?php echo $id_form;?> .creative_fileupload_wrapper {
	text-align: right;
}
.creative_form_<?php echo $id_form;?> .creative_uploaded_file {
	float: right;	
}
.creative_form_<?php echo $id_form;?> .creative_remove_uploaded {
	float: right;	
}
.creative_form_<?php echo $id_form;?> .creative_uploaded_icon {
	float: right;
}
/***captcha**/
.creative_form_<?php echo $id_form;?> img.creative_captcha{
	float: right;
	margin: 3px 0px 5px 5px !important;
}
.creative_form_<?php echo $id_form;?> .reload_creative_captcha {
	float: right;
}
.creative_form_<?php echo $id_form;?> .creative_timing_captcha  {
	text-align: right;
}
<?php }
else { ?>
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper .answer_name {
	float: left!important;
	text-align: left !important;
}
.creative_form_<?php echo $id_form;?>.creativecontactform_wrapper .answer_name label {
	margin: 6px 0px 0 33px;
}
.creative_form_<?php echo $id_form;?> .answer_input {
	float: left !important;
	margin-left: -100%;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_field_required {
	right: -12px !important;
}
.creative_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner {
right: 0 !important;
padding: 3px 16px 4px 8px;
text-align: left;
}
.creative_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:after,.creative_form_<?php echo $id_form;?> .the-tooltip.right > .tooltip_inner:before {
	right: 0;
}
.creative_form_<?php echo $id_form;?> .creative_input_dummy_wrapper img.ui-datepicker-trigger {
	right: -29px;
}
/***fileupload**/
.creative_form_<?php echo $id_form;?> .creative_progress .bar {
float: left;
}
.creative_form_<?php echo $id_form;?> .creative_fileupload_wrapper {
	text-align: left;
}
.creative_uploaded_file {
	float: left;	
}
.creative_form_<?php echo $id_form;?> .creative_remove_uploaded {
	float: left;	
}
.creative_form_<?php echo $id_form;?> .creative_uploaded_icon {
	float: left;
}
/***captcha**/
.creative_form_<?php echo $id_form;?> img.creative_captcha{
	float: left;
	margin: 3px 5pxpx 5px 0px !important;
}
.creative_form_<?php echo $id_form;?> .reload_creative_captcha {
	float: left;
}
.creative_form_<?php echo $id_form;?> .creative_timing_captcha  {
	text-align: left;
}
/****************************Multiple Columns***************************/
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_1 {
	width:<?php echo $styles[517];?>%;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_2 {
	width:<?php echo $styles[518];?>%;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_0 .creativecontactform_field_box_inner {
	width:<?php echo $styles[168];?>%;
}

.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_1 .creativecontactform_field_box_inner {
	width:<?php echo $styles[519];?>%;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_2 .creativecontactform_field_box_inner {
	width:<?php echo $styles[520];?>%;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_0 .creativecontactform_field_box_textarea_inner {
	width:<?php echo $styles[169];?>%;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_1 .creativecontactform_field_box_textarea_inner {
	width:<?php echo $styles[521];?>%;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_2 .creativecontactform_field_box_textarea_inner {
	width:<?php echo $styles[522];?>%;
}

.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_0 .creative_textarea_wrapper {
	height:<?php echo $styles[170];?>px;
}
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_1 .creative_textarea_wrapper,
.creative_form_<?php echo $id_form;?> .creative_field_box_wrapper_2 .creative_textarea_wrapper {
	height:<?php echo $styles[523];?>px;
}
.creative_form_<?php echo $id_form;?> .creativecontactform_heading {
	overflow: hidden;

	margin: <?php echo $styles[539];?>px 0 <?php echo $styles[540];?>px 0;
	
	border-top: <?php echo $styles[543];?>px <?php echo $styles[547];?> <?php echo $styles[548];?>;
	border-right: <?php echo $styles[544];?>px <?php echo $styles[547];?> <?php echo $styles[549];?>;
	border-bottom: <?php echo $styles[545];?>px <?php echo $styles[547];?> <?php echo $styles[550];?>;
	border-left: <?php echo $styles[546];?>px <?php echo $styles[547];?> <?php echo $styles[551];?>;

	background-color: <?php echo $styles[541];?>;
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $styles[541];?>', endColorstr='<?php echo $styles[542];?>'); /* for IE */
	background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(<?php echo $styles[541];?>), to(<?php echo $styles[542];?>));/* Safari 4-5, Chrome 1-9 */
	background: -webkit-linear-gradient(top, <?php echo $styles[541];?>, <?php echo $styles[542];?>); /* Safari 5.1, Chrome 10+ */
	background: -moz-linear-gradient(top, <?php echo $styles[541];?>, <?php echo $styles[542];?>);/* Firefox 3.6+ */
	background: -ms-linear-gradient(top, <?php echo $styles[541];?>, <?php echo $styles[542];?>);/* IE 10 */
	background: -o-linear-gradient(top, <?php echo $styles[541];?>, <?php echo $styles[542];?>);/* Opera 11.10+ */

	<?php 

		$ccf_googlefont = 'ccf-googlewebfont-';
		$ccf_font_rule = $styles[529];
		if (strpos($ccf_font_rule,$ccf_googlefont) !== false) {
			$ccf_font_rule = str_replace($ccf_googlefont, '', $ccf_font_rule);
			$ccf_font_rule .= ', sans-serif';
		}
	?>
	font-family: <?php echo $ccf_font_rule;?>

}
.creative_form_<?php echo $id_form;?> .creativecontactform_heading_inner {
	margin: <?php echo $styles[535];?>px <?php echo $styles[536];?>px <?php echo $styles[537];?>px <?php echo $styles[538];?>px;
	line-height: 1.2;
	font-size: <?php echo $styles[525];?>px;
	color: <?php echo $styles[524];?> !important;
	font-style: <?php echo $styles[527];?>;
	font-weight: <?php echo $styles[526];?>;
	text-decoration: <?php echo $styles[528];?>;
	text-shadow: <?php echo $styles[532];?>px <?php echo $styles[533];?>px <?php echo $styles[534];?>px <?php echo $styles[531];?> !important;
	
}

/****************************Sections, Links, Popups***************************/
.creative_form_<?php echo $id_form;?> .ccf_content_element_label {
	font-size: <?php echo $styles[554];?>px !important;
	color: <?php echo $styles[553];?> !important;
	font-style: <?php echo $styles[556];?> !important;
	font-weight: <?php echo $styles[555];?> !important;
	text-shadow: <?php echo $styles[559];?>px <?php echo $styles[560];?>px <?php echo $styles[561];?>px <?php echo $styles[558];?> !important;
	border-bottom: <?php echo $styles[590];?>px <?php echo $styles[591];?> <?php echo $styles[592];?> !important;

	text-decoration: <?php echo $styles[596];?> !important;
}
.creative_form_<?php echo $id_form;?> a,
.creative_form_<?php echo $id_form;?> .ccf_popup_link
 {
	color: <?php echo $styles[564];?> !important;
	font-style: <?php echo $styles[566];?> !important;
	font-weight: <?php echo $styles[565];?> !important;
	text-shadow: <?php echo $styles[571];?>px <?php echo $styles[572];?>px <?php echo $styles[573];?>px <?php echo $styles[570];?> !important;
	border-bottom: <?php echo $styles[567];?>px <?php echo $styles[568];?> <?php echo $styles[569];?> !important;

	text-decoration: <?php echo $styles[594];?> !important;
}
.creative_form_<?php echo $id_form;?> a:hover,
.creative_form_<?php echo $id_form;?> .ccf_popup_link:hover
 {
	color: <?php echo $styles[574];?> !important;
	text-shadow: <?php echo $styles[577];?>px <?php echo $styles[578];?>px <?php echo $styles[579];?>px <?php echo $styles[576];?> !important;
	border-bottom: <?php echo $styles[567];?>px <?php echo $styles[568];?> <?php echo $styles[575];?> !important;

	font-style: <?php echo $styles[566];?> !important;
	font-weight: <?php echo $styles[565];?> !important;
	text-decoration: <?php echo $styles[595];?> !important;
}

.creative_form_<?php echo $id_form;?> .ccf_content_styling {
	color: <?php echo $styles[580];?> !important;
	font-style: <?php echo $styles[582];?> !important;
	font-weight: <?php echo $styles[581];?> !important;
	text-shadow: <?php echo $styles[584];?>px <?php echo $styles[585];?>px <?php echo $styles[586];?>px <?php echo $styles[583];?> !important;
	text-decoration: <?php echo $styles[593];?> !important;
}

/*Custom Temaple Styles*/
<?php 
$custom_styles = str_replace('ccf_img_path','./assets/images/bg_images',$styles[599]);
$custom_styles = str_replace('FORM_ID',$id_form,$custom_styles);
echo $custom_styles;

?>
<?php }?>
