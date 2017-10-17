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

class EasybookReloadedViewEntry extends JViewLegacy
{
	protected $entry;
	protected $guestbooks;
	protected $params;
	protected $donation_code_message;

	function display($tpl = null)
	{
		JHtml::_('stylesheet', 'easybookreloaded.css', array('relative' => 'administrator/components/com_easybookreloaded/css/'));

		$this->entry = $this->get('Data');
		$isNew = ($this->entry->id < 1);

		$text = $isNew ? JText::_('COM_EASYBOOKRELOADED_NEWENTRY') : JText::_('COM_EASYBOOKRELOADED_EDITENTRY');
		JToolbarHelper::title(JText::_('COM_EASYBOOKRELOADED_EASYBOOKRELOADED').' - '.$text, 'easybookreloaded');
		JToolbarHelper::apply('apply');
		JToolbarHelper::save();

		if($isNew)
		{
			JToolbarHelper::cancel();
		}
		else
		{
			JToolbarHelper::cancel('cancel', 'Close');
		}

		JHtml::_('behavior.calendar');

		$config = JFactory::getConfig();
		$offset = $config->get('config.offset');
		$date = JFactory::getDate($this->entry->gbdate, $offset);
		$this->entry->gbdate = $date->format($date);

		// Get Guestbooks for selection list
		$this->guestbooks = $this->get('Data', 'gb');

		// Params of component for rating field
		$this->params = JComponentHelper::getParams('com_easybookreloaded');

		// Get donation code message
		require_once JPATH_COMPONENT.'/helpers/easybookreloaded.php';
		$this->donation_code_message = EasybookReloadedHelper::getDonationCodeMessage();

		parent::display($tpl);
	}
}
