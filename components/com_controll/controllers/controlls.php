<?php
/**
 * @version     1.0.0
 * @package     com_controll
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Controlls list controller class.
 */
class ControllControllerControlls extends ControllController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Controlls', $prefix = 'ControllModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}
