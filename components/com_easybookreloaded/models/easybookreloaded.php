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

class EasybookReloadedModelEasybookReloaded extends JModelLegacy
{
	protected $gbid;
	protected $data;
	protected $total;
	protected $input;
	protected $params;
	protected $pagination;

	public function __construct()
	{
		parent::__construct();

		$this->input = JFactory::getApplication()->input;
		$this->params = JComponentHelper::getParams('com_easybookreloaded');

		// Get guestbook ID
		$this->gbid = $this->input->getInt('gbid', false);
		JFactory::getSession()->set('gbid', $this->gbid, 'easybookreloaded');
	}

	/**
	 * Gets all entries
	 *
	 * @return object[]
	 */
	public function getData()
	{
		if(empty($this->data))
		{
			$query = $this->buildQuery();
			$this->data = $this->_getList($query);
		}

		return $this->data;
	}

	/**
	 * Builds correct query to retrieve all needed entries
	 *
	 * @return string
	 */
	private function buildQuery()
	{
		$query = $this->_db->getQuery(true);
		$query->select('*');
		$query->from($this->_db->quoteName('#__easybook'));

		if(!empty($this->gbid) AND is_int($this->gbid))
		{
			$query->where($this->_db->quoteName('gbid')." = ".$this->gbid);
		}

		if(!EASYBOOK_CANEDIT)
		{
			$query->where($this->_db->quoteName('published')." = 1");
		}

		$order = $this->params->get('entries_order', 'DESC');

		// If type is feed, then the order has to be DESC to get the latest entries in the feed reader
		if(JFactory::getDocument()->getType() == 'feed')
		{
			$order = 'DESC';
		}

		// Check whether limit is already set - e.g. from feed function
		$limit = $this->input->getInt('limit', 0);

		if(empty($limit))
		{
			$limit = (int)$this->params->get('entries_perpage', 5);
		}

		$query->order($this->_db->quoteName('gbdate')." ".$order." LIMIT ".$this->input->getInt('limitstart', 0).", ".$limit);

		return $query;
	}

	/**
	 * Loads the guestbook data for a specific ID
	 *
	 * @return bool|object[]
	 */
	public function getGBData()
	{
		$query = $this->_db->getQuery(true);
		$query->select('*');
		$query->from($this->_db->quoteName('#__easybook_gb'));

		if(!empty($this->gbid) AND is_int($this->gbid))
		{
			$query->where($this->_db->quoteName('id')." = ".$this->gbid);
		}

		$gb_data = $this->_getList($query);

		if(!empty($gb_data))
		{
			if(!empty($this->gbid) AND is_int($this->gbid))
			{
				return $gb_data[0];
			}

			$gb_items = array();

			foreach($gb_data as $gb_item)
			{
				$gb_items[$gb_item->id] = $gb_item->title;
			}

			return $gb_items;
		}

		return false;
	}

	/**
	 * Creates pagination object
	 *
	 * @return JPagination
	 */
	public function getPagination()
	{
		if(empty($this->pagination))
		{
			// Check whether limit is already set - e.g. from feed function
			$limit = $this->input->getInt('limit', 0);

			if(empty($limit))
			{
				$limit = (int)$this->params->get('entries_perpage', 5);
			}

			jimport('joomla.html.pagination');
			$total = $this->getTotal();
			$this->pagination = new JPagination($total, $this->input->getInt('limitstart', 0), $limit);
		}

		return $this->pagination;
	}

	/**
	 * Gets the total number of entries
	 *
	 * @return int
	 */
	public function getTotal()
	{
		if(empty($this->total))
		{
			$query = $this->buildCountQuery();
			$this->total = $this->_getListCount($query);
		}

		return $this->total;
	}

	/**
	 * Builds the count query
	 *
	 * @return JDatabaseQuery
	 */
	private function buildCountQuery()
	{
		$query = $this->_db->getQuery(true);
		$query->select('*');
		$query->from($this->_db->quoteName('#__easybook'));

		if(!empty($this->gbid) AND is_int($this->gbid))
		{
			$query->where($this->_db->quoteName('gbid')." = ".$this->gbid);
		}

		if(!EASYBOOK_CANEDIT)
		{
			$query->where($this->_db->quoteName('published')." = 1");
		}

		return $query;
	}

	/**
	 * Gets the guestbook ID
	 *
	 * @return int
	 */
	public function getGbid()
	{
		if(!is_null($this->gbid) AND is_int($this->gbid))
		{
			return $this->gbid;
		}

		return false;
	}
}
