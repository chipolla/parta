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

class EasybookReloadedControllerBadwords extends JControllerLegacy
{
	protected $input;

	public function __construct()
	{
		parent::__construct();
		$this->registerTask('add', 'edit');
		$this->registerTask('apply', 'save');
		$this->input = JFactory::getApplication()->input;
	}

	public function display($cachable = false, $urlparams = false)
	{
		$this->input->set('view', 'badwords');

		require_once JPATH_COMPONENT.'/helpers/easybookreloaded.php';
		EasybookReloadedHelper::addSubmenu($this->input->getCmd('view', 'easybookreloaded'));

		parent::display();
	}

	public function edit()
	{
		$this->input->set('view', 'badword');
		$this->input->set('layout', 'form');
		$this->input->set('hidemainmenu', 1);

		parent::display();
	}

	public function save()
	{
		JSession::checkToken() OR jexit('Invalid Token');

		$msg = JText::_('COM_EASYBOOKRELOADED_BADWORDSAVEDFAIL');
		$type = 'error';

		$model = $this->getModel('badword');

		if($model->store())
		{
			$msg = JText::_('COM_EASYBOOKRELOADED_BADWORDSAVEDSUCCESS');
			$type = 'message';
		}

		if($this->task == 'apply')
		{
			$this->setRedirect('index.php?'.$this->input->getString('url_current'), $msg, $type);

			return;
		}

		$this->setRedirect('index.php?option=com_easybookreloaded&controller=badwords', $msg, $type);
	}

	public function remove()
	{
		JSession::checkToken() OR jexit('Invalid Token');

		$msg = JText::_('COM_EASYBOOKRELOADED_BADWORDDELETEFAIL');
		$type = 'error';

		$model = $this->getModel('badword');

		if($model->delete())
		{
			$msg = JText::_('COM_EASYBOOKRELOADED_BADWORDDELETESUCCESS');
			$type = 'message';
		}

		$this->setRedirect(JRoute::_('index.php?option=com_easybookreloaded&controller=badwords', false), $msg, $type);
	}

	public function cancel()
	{
		$msg = JText::_('COM_EASYBOOKRELOADED_OPERATION_CANCELLED');
		$this->setRedirect('index.php?option=com_easybookreloaded&controller=badwords', $msg, 'notice');
	}
}
