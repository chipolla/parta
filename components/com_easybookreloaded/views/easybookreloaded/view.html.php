<?php
/**
 * EBR - Easybook Reloaded for Joomla! 3.x
 * License: GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * Author: Viktor Vogel <admin@kubik-rubik.de>
 * Project page: https://joomla-extensions.kubik-rubik.de/ebr-easybook-reloaded
 *
 * @license GNU/GPL
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class EasybookReloadedViewEasybookReloaded extends JViewLegacy
{
	protected $params;
	protected $entries;
	protected $gb_data;
	protected $count;
	protected $pagination;
	protected $heading;

	function display($tpl = null)
	{
		require_once(JPATH_COMPONENT.'/helpers/content.php');
		$this->params = JComponentHelper::getParams('com_easybookreloaded');

		// Check whether a guestbook ID is set in the request
		$gbid = $this->get('Gbid');

		if(is_null($gbid) OR !is_int($gbid))
		{
			return parent::display('error');
		}

		// Get the required data
		$this->entries = $this->get('Data');
		$this->gb_data = $this->get('GBData');
		$this->count = $this->get('Total');
		$this->pagination = $this->get('Pagination');

		// Set the head data
		$this->addHeadData();

		// Remove cache from Page Cache plugin if required
		EasybookReloadedHelperContent::cleanCache($gbid);

		if($gbid == 0)
		{
			parent::setLayout('all');

			return parent::display(null);
		}

		parent::display($tpl);
	}

	private function addHeadData()
	{
		$document = JFactory::getDocument();

		// Set CSS File
		$css_file = 'easybookreloaded';
		$template = $this->params->get('template', 0);

		if($template == 1)
		{
			$css_file .= 'dark';
		}
		elseif($template == 2)
		{
			$css_file .= 'transparent';
		}

		$document->addStyleSheet(JUri::root().'components/com_easybookreloaded/css/'.$css_file.'.css');

		// Show RSS Feed
		$link = '&format=feed&limitstart=';
		$attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
		$document->addHeadLink(JRoute::_($link.'&type=rss'), 'alternate', 'rel', $attribs);
		$attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
		$document->addHeadLink(JRoute::_($link.'&type=atom'), 'alternate', 'rel', $attribs);

		// Add meta data from menu link
		$menus = JMenu::getInstance('site');
		$menu = $menus->getActive();

		if(!empty($menu))
		{
			if($menu->params->get('menu-meta_description'))
			{
				$document->setDescription($menu->params->get('menu-meta_description'));
			}

			if($menu->params->get('menu-meta_keywords'))
			{
				$document->setMetaData('keywords', $menu->params->get('menu-meta_keywords'));
			}

			if($menu->params->get('robots'))
			{
				$document->setMetaData('robots', $menu->params->get('robots'));
			}
		}

		$this->heading = $document->getTitle();

		// Add HTML Head Link
		if(method_exists($document, 'addHeadLink'))
		{
			$paginationdata = $this->pagination->getData();

			if($paginationdata->start->link)
			{
				$document->addHeadLink($paginationdata->start->link, 'first');
			}

			if($paginationdata->previous->link)
			{
				$document->addHeadLink($paginationdata->previous->link, 'prev');
			}

			if($paginationdata->next->link)
			{
				$document->addHeadLink($paginationdata->next->link, 'next');
			}

			if($paginationdata->end->link)
			{
				$document->addHeadLink($paginationdata->end->link, 'last');
			}
		}
	}
}
