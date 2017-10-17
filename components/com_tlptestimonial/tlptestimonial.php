<?php
/**
 * @version     1.0.0
 * @package     com_tlptestimonial
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');
$document = JFactory::getDocument();

$document->addStyleSheet('components/com_tlptestimonial/assets/css/tlptestimonial.css');
//if($bscss==1){
$document->addStyleSheet('media/jui/css/bootstrap.css');
//}
// Execute the task.
$controller	= JControllerLegacy::getInstance('Tlptestimonial');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
