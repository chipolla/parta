<?php
/*------------------------------------------------------------------------

# TZ Guestbook Extension

# ------------------------------------------------------------------------

# author    TuanNguyenTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/
defined('JPATH_BASE') or die;
tzguestbookimport('/cms/layout/file');

/**
 * Utility class to render a list view sidebar
 *
 * @package     Joomla.Libraries
 * @subpackage  HTML
 * @since       3.0
 */
abstract class JHtmlSidebar
{
	/**
	 * Menu entries
	 *
	 * @var    array
	 * @since  3.0
	 */
	protected static $entries = array();

	/**
	 * Filters
	 *
	 * @var    array
	 * @since  3.0
	 */
	protected static $filters = array();

	/**
	 * Value for the action attribute of the form.
	 *
	 * @var    string
	 * @since  3.0
	 */
	protected static $action = '';

	/**
	 * Render the sidebar.
	 *
	 * @return  string  The necessary HTML to display the sidebar
	 *
	 * @since   3.0
	 */
	public static function render()
	{
		// Collect display data
		$data                 = new stdClass;
		$data->list           = self::getEntries();
		$data->filters        = self::getFilters();
		$data->action         = self::getAction();
		$data->displayMenu    = count($data->list);
		$data->displayFilters = count($data->filters);
		$data->hide           = JFactory::getApplication()->input->getBool('hidemainmenu',null);

		// Create a layout object and ask it to render the sidebar
		$layout      = new JLayoutFile('joomla.sidebars.submenu',COM_TZ_GUESTBOOK_LIBRARIES.'/layouts');
		$sidebarHtml = $layout->render($data);

		return $sidebarHtml;
	}

	/**
	 * Method to add a menu item to submenu.
	 *
	 * @param   string  $name    Name of the menu item.
	 * @param   string  $link    URL of the menu item.
	 * @param   bool    $active  True if the item is active, false otherwise.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function addEntry($name, $link = '', $active = false)
	{
		array_push(self::$entries, array($name, $link, $active));
	}

	/**
	 * Returns an array of all submenu entries
	 *
	 * @return  array
	 *
	 * @since   3.0
	 */
	public static function getEntries()
	{
		return self::$entries;
	}

	/**
	 * Method to add a filter to the submenu
	 *
	 * @param   string  $label      Label for the menu item.
	 * @param   string  $name       Name for the filter. Also used as id.
	 * @param   string  $options    Options for the select field.
	 * @param   bool    $noDefault  Don't the label as the empty option
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function addFilter($label, $name, $options, $noDefault = false)
	{
		array_push(self::$filters, array('label' => $label, 'name' => $name, 'options' => $options, 'noDefault' => $noDefault));
	}

	/**
	 * Returns an array of all filters
	 *
	 * @return  array
	 *
	 * @since   3.0
	 */
	public static function getFilters()
	{
		return self::$filters;
	}

	/**
	 * Set value for the action attribute of the filter form
	 *
	 * @param   string  $action  Value for the action attribute of the form
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function setAction($action)
	{
		self::$action = $action;
	}

	/**
	 * Get value for the action attribute of the filter form
	 *
	 * @return  string
	 *
	 * @since   3.0
	 */
	public static function getAction()
	{
		return self::$action;
	}
}
