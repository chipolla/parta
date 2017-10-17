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

class EasybookReloadedModelBadword extends JModelLegacy
{
	protected $data = null;
	protected $id = null;
	protected $input;

	public function __construct()
	{
		parent::__construct();

		$this->input = JFactory::getApplication()->input;
		$array = $this->input->get('cid', 0, 'ARRAY');
		$this->setId((int)$array[0]);
	}

	public function setId($id)
	{
		$this->id = $id;
		$this->data = null;
	}

	public function getData()
	{
		if(empty($this->data))
		{
			$query = "SELECT * FROM ".$this->_db->quoteName('#__easybook_badwords')." WHERE ".$this->_db->quoteName('id')." = ".$this->_db->quote($this->id);
			$this->_db->setQuery($query);
			$this->data = $this->_db->loadObject();
		}

		if(!$this->data)
		{
			$this->data = $this->getTable('badword', 'EasybookReloadedTable');
			$this->data->id = 0;
		}

		return $this->data;
	}

	public function store()
	{
		$row = $this->getTable('badword', 'EasybookReloadedTable');

		// Load all request variable - because JInput doesn't allow to load the whole data at once, a workaround
		//is used. This was easily possible with the deprecated JRequest (e.g. JRequest::get('post');)
		// Another possible call with the API would be: unserialize($this->input->serialize())
		$data = $_REQUEST;
		array_walk($data, create_function('&$data', '$data = htmlspecialchars(strip_tags(trim($data)));'));

		if(!$row->save($data))
		{
			throw new Exception(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 404);
		}

		return true;
	}

	public function delete()
	{
		$cids = $this->input->get('cid', array(0), 'ARRAY');
		$row = $this->getTable('badword', 'EasybookReloadedTable');

		foreach($cids as $cid)
		{
			if(!$row->delete($cid))
			{
				throw new Exception(JText::_('JERROR_AN_ERROR_HAS_OCCURRED'), 404);
			}
		}

		return true;
	}
}
