<?php
/**
 * EBR - Easybook Reloaded for Joomla! 3.x
 * License: GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * Author: Viktor Vogel
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
defined('_JEXEC') OR die('Restricted access');

class EasybookReloadedViewEasybookReloaded extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $guestbooks;
	protected $donation_code_message;
	protected $sidebar;

	function display($tpl = null)
	{
		JToolbarHelper::title(JText::_('COM_EASYBOOKRELOADED_EASYBOOKRELOADED')." - ".JText::_('COM_EASYBOOKRELOADED_SUBMENU_ENTRIES'), 'easybookreloaded');
		JToolbarHelper::addNew();
		JToolbarHelper::publishList();
		JToolbarHelper::unpublishList();
		JToolbarHelper::deleteList();
		JToolbarHelper::editList();
		JToolbarHelper::preferences('com_easybookreloaded', '500');
		JHtml::_('stylesheet', 'easybookreloaded.css', array('relative' => 'administrator/components/com_easybookreloaded/css/'));

		$this->items = $this->get('Data');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');

		// Get Guestbooks for selection list
		$this->guestbooks = $this->get('Data', 'gb');

		// Get donation code message
		require_once JPATH_COMPONENT.'/helpers/easybookreloaded.php';
		$this->donation_code_message = EasybookReloadedHelper::getDonationCodeMessage();

		$this->sidebar = JHtmlSidebar::render();

		parent::display($tpl);
	}
}
