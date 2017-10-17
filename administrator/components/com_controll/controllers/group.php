<?php
/**
 * @version     1.0.0
 * @package     com_controll
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Group controller class.
 */
class ControllControllerGroup extends JControllerForm
{

    function __construct() {
        $this->view_list = 'groups';
        parent::__construct();
    }

}
