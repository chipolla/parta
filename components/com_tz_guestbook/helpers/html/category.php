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

/**
 * Utility class for categories
 *
 * @package     Joomla.Libraries
 * @subpackage  HTML
 * @since       1.5
 */
abstract class JHtmlCategory
{
	/**
	 * Cached array of the category items.
	 *
	 * @var    array
	 * @since  1.5
	 */
	protected static $items = array();

	/**
	 * Returns an array of categories for the given extension.
	 *
	 * @param   string  $extension  The extension option e.g. com_something.
	 * @param   array   $config     An array of configuration options. By default, only
	 *                              published and unpublished categories are returned.
	 *
	 * @return  array
	 *
	 * @since   1.5
	 */
	public static function options($extension, $config = array('filter.published' => array(0, 1)))
	{
		$hash = md5($extension . '.' . serialize($config));

		if (!isset(self::$items[$hash]))
		{
			$config = (array) $config;
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query->select('a.id, a.title, a.level');
			$query->from('#__categories AS a');
			$query->where('a.parent_id > 0');

			// Filter on extension.
			$query->where('extension = ' . $db->quote($extension));

			// Filter on the published state
			if (isset($config['filter.published']))
			{
				if (is_numeric($config['filter.published']))
				{
					$query->where('a.published = ' . (int) $config['filter.published']);
				}
				elseif (is_array($config['filter.published']))
				{
					JArrayHelper::toInteger($config['filter.published']);
					$query->where('a.published IN (' . implode(',', $config['filter.published']) . ')');
				}
			}

			// Filter on the language
			if (isset($config['filter.language']))
			{
				if (is_string($config['filter.language']))
				{
					$query->where('a.language = ' . $db->quote($config['filter.language']));
				}
				elseif (is_array($config['filter.language']))
				{
					foreach ($config['filter.language'] as &$language)
					{
						$language = $db->quote($language);
					}
					$query->where('a.language IN (' . implode(',', $config['filter.language']) . ')');
				}
			}

			$query->order('a.lft');

			$db->setQuery($query);
			$items = $db->loadObjectList();

			// Assemble the list options.
			self::$items[$hash] = array();

			foreach ($items as &$item)
			{
				$repeat = ($item->level - 1 >= 0) ? $item->level - 1 : 0;
				$item->title = str_repeat('- ', $repeat) . $item->title;
				self::$items[$hash][] = JHtml::_('select.option', $item->id, $item->title);
			}
		}

		return self::$items[$hash];
	}

	/**
	 * Returns an array of categories for the given extension.
	 *
	 * @param   string  $extension  The extension option.
	 * @param   array   $config     An array of configuration options. By default, only published and unpublished categories are returned.
	 *
	 * @return  array   Categories for the extension
	 *
	 * @since   1.6
	 */
	public static function categories($extension, $config = array('filter.published' => array(0, 1)))
	{
		$hash = md5($extension . '.' . serialize($config));

		if (!isset(self::$items[$hash]))
		{
			$config = (array) $config;
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			$query->select('a.id, a.title, a.level, a.parent_id');
			$query->from('#__categories AS a');
			$query->where('a.parent_id > 0');

			// Filter on extension.
			$query->where('extension = ' . $db->quote($extension));

			// Filter on the published state
			if (isset($config['filter.published']))
			{
				if (is_numeric($config['filter.published']))
				{
					$query->where('a.published = ' . (int) $config['filter.published']);
				}
				elseif (is_array($config['filter.published']))
				{
					JArrayHelper::toInteger($config['filter.published']);
					$query->where('a.published IN (' . implode(',', $config['filter.published']) . ')');
				}
			}

			$query->order('a.lft');

			$db->setQuery($query);
			$items = $db->loadObjectList();

			// Assemble the list options.
			self::$items[$hash] = array();

			foreach ($items as &$item)
			{
				$repeat = ($item->level - 1 >= 0) ? $item->level - 1 : 0;
				$item->title = str_repeat('- ', $repeat) . $item->title;
				self::$items[$hash][] = JHtml::_('select.option', $item->id, $item->title);
			}
			// Special "Add to root" option:
			self::$items[$hash][] = JHtml::_('select.option', '1', JText::_('JLIB_HTML_ADD_TO_ROOT'));
		}

		return self::$items[$hash];
	}
}
