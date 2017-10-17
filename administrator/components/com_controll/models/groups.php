<?php

/**
 * @version     1.0.0
 * @package     com_controll
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Group records.
 */
class ControllModelGroups extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {



        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'group_name', 'a.group_name',
                'ordering', 'a.ordering',
                'state', 'a.state',
                'created_by', 'a.created_by',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        //Filter (dropdown) teacher
        $teacher= $app->getUserStateFromRequest($this->context.'.filter.teacher', 'filter_teacher', '', 'string');
        $this->setState('filter.teacher', $teacher);

        $subject= $app->getUserStateFromRequest($this->context.'.filter.subject', 'filter_subject', '', 'string');
        $this->setState('filter.subject', $subject);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_controll');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.group_name', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
    // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

    // Select the required fields from the table.
      $query->select(
        $this->getState(
          'list.select', 'DISTINCT a.*'
        )
      );
      $query->from('`#__controll_groups` AS a');
		// Join over the users for the checked out user
      $query->select("uc.name AS editor");
      $query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
      $query->select('created_by.name AS created_by');
      $query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the users for the checked out user
      $query->select("tc.teacher AS teacher");
      $query->join("LEFT", "#__controll_teachers AS tc ON tc.id=a.teacher");

    //Filter Teachers
      $teacher = $this->getState('filter.teacher');
      if (!empty($teacher)) {
          $query->where('a.teacher = ' . $teacher);
      }

    // Join over the users for the checked out user
      $query->select("sb.subject AS subject");
      $query->join("LEFT", "#__controll_subjects AS sb ON sb.id=a.subject");

    //Filter Subjects
      $subject = $this->getState('filter.subject');
      if (!empty($subject)) {
        $query->where('a.subject = ' . $subject);
      }

		// Filter by published state
      $published = $this->getState('filter.state');
      if (is_numeric($published)) {
        $query->where('a.state = ' . (int) $published);
      } else if ($published === '') {
        $query->where('(a.state IN (0, 1))');
      }

    // Filter by search in title
      $search = $this->getState('filter.search');
      if (!empty($search)) {
        if (stripos($search, 'id:') === 0) {
          $query->where('a.id = ' . (int) substr($search, 3));
        } else {
          $search = $db->Quote('%' . $db->escape($search, true) . '%');
          $query->where('( a.group_name LIKE '.$search.')');
        }
      }

    // Add the list ordering clause.
      $orderCol = $this->state->get('list.ordering');
      $orderDirn = $this->state->get('list.direction');
      if ($orderCol && $orderDirn) {
        $query->order($db->escape($orderCol . ' ' . $orderDirn));
      }

      return $query;
    }

    public function getItems() {
      $items = parent::getItems();

      return $items;
    }

}
