<?php
/**
 * @version   $Id: templates.php 6825 2013-01-28 06:18:42Z btowles $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2015 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die();
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
/**
 *
 */
class JFormFieldTemplates extends JFormField
{

    /**
     * @var string
     */
    public $type = 'Templates';

    private $_templates = '';

    private $_jtemplate = '';

    /**
     * @return string
     */
    public function getInput()
    {
        $this->_templates = JPATH_ROOT . '/modules/mod_rokfeaturetable/templates';
        $this->_jtemplate = $this->_getCurrentTemplatePath();
        $output = "";


        if (JFolder::exists($this->_templates)) {
            $files = JFolder::files($this->_templates, "\.txt", true, true);

            if (JFolder::exists($this->_jtemplate)) {
                $jfiles = JFolder::files($this->_jtemplate, "\.txt", true, true);
                if (count($jfiles)) $this->merge($files, $jfiles);
            }

            if (count($files)) {
                $output = "<select id='templates'>\n";
                $output .= "<option value='_select_' class='disabled' selected='selected'>Select a Template</option>";
                foreach ($files as $file) {
                    $title = JFile::stripExt(JFile::getName($file));
                    $title = str_replace("-", " ", str_replace("_", " ", $title));
                    $title = ucwords($title);
                    $output .= "<option value='" . JFile::read($file) . "'>" . $title . "</option>";
                }
                $output .= "</select>\n";

                $output .= "<span id='import-button' class='action-import'><span>import</span></span>\n";
            }
        } else {
            $output = "Templates folder was not found.";
        }

        return $output;
    }

    /**
     * @param $files
     * @param $jfiles
     *
     * @return array
     */
    function merge(&$files, $jfiles)
    {
        $clean_files = $this->getCleanArray($files);
        $clean_jfiles = $this->getCleanArray($jfiles);

        foreach ($clean_jfiles as $index => $jfile) {
            if (in_array($jfile, $clean_files)) $files[array_search($jfile, $clean_files)] = $jfiles[$index];
            else array_push($files, $jfiles[$index]);
        }

        sort($files);
        return $files;
    }

    /**
     * @param $array
     * @return array
     */
    function getCleanArray($array)
    {
        $newArray = array();

        foreach ($array as $value) array_push($newArray, JFile::stripExt(JFile::getName($value)));

        return $newArray;
    }

    /**
     * @return mixed
     */
    function _getCurrentTemplate()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('template');
        $query->from('#__template_styles');
        $query->where('home = 1');
        $query->where('client_id = 0');

        $myvar = (string)$query;

        $db->setQuery((string)$query);
        $template = $db->loadColumn();

        return $template[0];
    }

    /**
     * @return string
     */
    function _getCurrentTemplatePath()
    {
        $template = $this->_getCurrentTemplate();

        return JPATH_ROOT . '/templates/' . $template . '/admin/rft-templates';
    }
}