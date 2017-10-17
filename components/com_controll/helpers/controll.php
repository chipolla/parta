<?php

/**
 * @version     1.0.0
 * @package     com_controll
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

class ControllFrontendHelper {

	public static function config()
	{
		$db =& JFactory::getDBO();
		$sql = 'SELECT * FROM #__controll_settings WHERE id = 1';
		$db->setQuery($sql);
		$config = $db->loadObject();

		return $config;
	}

}
