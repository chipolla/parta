<?php
/**
 * @version     1.0.0
 * @package     com_controll
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_controll'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

require_once JPATH_COMPONENT . '/helpers/controll.php';

$controller	= JControllerLegacy::getInstance('Controll');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
