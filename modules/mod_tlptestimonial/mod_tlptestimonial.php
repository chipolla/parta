<?php
/**
 * @version     1.0.0
 * @package     mod_tlptestimonial
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;
 
//This is the parameter we get from the XML file 
$category= $params->get('category'); 
$testimonialcount= $params->get('testimonialcount');
$showno= $params->get('showno');
$ordering= $params->get('ordering');
$readmore= $params->get('readmore'); 
$readmore_text= $params->get('readmore_text'); 
$character_limit= $params->get('character_limit'); 
$testimonialmenuid= $params->get('testimonialmenuid');  
$backgroundimage= $params->get('backgroundimage');
$imgborder= $params->get('imgborder');
$imgbordercolor= $params->get('imgbordercolor');
$namefontsize= $params->get('namefontsize');
$namecolor= $params->get('namecolor');
$designfontsize= $params->get('designfontsize');
$designcolor= $params->get('designcolor');
$mainfontsize= $params->get('mainfontsize');
$maincolor= $params->get('maincolor');
$namefontsize= $params->get('namefontsize');
$speed= $params->get('speed');
$autoplay= $params->get('autoplay');
$navigation= $params->get('navigation');
$pagination= $params->get('pagination');
$responsive= $params->get('responsive');
$lazyload= $params->get('lazyload');
$enablejq= $params->get('enablejq');


$document = JFactory::getDocument();

$document->addStyleSheet('components/com_tlptestimonial/assets/css/tlptestimonial.css');
$document->addStyleSheet('components/com_tlptestimonial/assets/owl-carousel/owl.carousel.css');
$document->addStyleSheet('components/com_tlptestimonial/assets/owl-carousel/owl.theme.css');
if($enablejq=='true'){
$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js');
}
$document->addScript('components/com_tlptestimonial/assets/owl-carousel/owl.carousel.min.js');
//$document->addScript('modules/com_tlptestimonial/js/jquery.matchHeight-min.js');

//Include syndicate function only once
require_once dirname(__FILE__).'/helper.php';
//Require the path of the layout file

require JModuleHelper::getLayoutPath('mod_tlptestimonial', $params->get('layout','default'));