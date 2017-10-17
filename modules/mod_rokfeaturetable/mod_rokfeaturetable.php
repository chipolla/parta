<?php
/**
 * @version   $Id: mod_rokfeaturetable.php 8649 2013-03-21 02:25:16Z steph $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the syndicate functions only once
require_once (dirname(__FILE__) . '/helper.php');

//modRokFeatureTableHelper::loadScripts($params);
JHtml::_('behavior.framework', true);
$doc = JFactory::getDocument();
$doc->addScript(JURI::Root(true) . '/modules/mod_rokfeaturetable/tmpl/js/rokfeaturetable.js');
if ($params->get('builtin_css', 1)) $doc->addStyleSheet(JURI::Root(true) . '/modules/mod_rokfeaturetable/tmpl/css/rokfeaturetable.css');

$document = JFactory::getDocument();

// Cache this basd on access level
$conf = JFactory::getConfig();
if ($conf->get('caching') && $params->get('module_cache')) {
	$user  = JFactory::getUser();
	$cache = JFactory::getCache('mod_rokfeaturetable');
	$cache->setCaching(true);
	$args     = array(&$params);
	$checksum = md5($args[0]->_raw);
	$data     = $cache->get(array(
	                             'modRokFeatureTableHelper',
	                             'getData'
	                        ), $args, 'mod_rokfeaturetable-' . $user->get('aid', 0) . '-' . $checksum);
} else {
	$helper = new modRokFeatureTableHelper();
	$data   = $helper->getData($params);
}
$counter = 0;
require(JModuleHelper::getLayoutPath('mod_rokfeaturetable'));