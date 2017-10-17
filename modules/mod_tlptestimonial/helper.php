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

require_once JPATH_SITE . '/components/com_tlptestimonial/helpers/tlptestimonial.php';
 
 //Add database instance
$db= JFactory::getDBO();

//Pass query Limit by count parameter (Check XML)
if($category>0){
	$query="SELECT * FROM #__tlptestimonial_testimonial  WHERE category=$category AND state=1 ORDER BY $ordering LIMIT 0,$testimonialcount";
}else{
	$query="SELECT * FROM #__tlptestimonial_testimonial  WHERE state=1 ORDER BY $ordering LIMIT 0,$testimonialcount";
}
 //Run The query
$db->setQuery($query);

//Load it as an Object into the variable "$rows
$rows = $db->loadObjectList();