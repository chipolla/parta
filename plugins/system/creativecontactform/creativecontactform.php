<?php
/**
 * Joomla! component creativecontactform
 *
 * @version $Id: default.php 2012-04-05 14:30:25 svn $
 * @author Creative-Solutions.net
 * @package Creative Image Slider
 * @subpackage com_creativecontactform
 * @license GNU/GPL
 *
 */

defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.plugin.plugin');
jimport('joomla.event.plugin');

class plgSystemCreativecontactform extends JPlugin {

    function __construct( &$subject ) {
        parent::__construct( $subject );

        // load plugin parameters and language file
        $this->_plugin = JPluginHelper::getPlugin( 'system', 'creativecontactform' );
        $this->_params = json_decode( $this->_plugin->params );
        JPlugin::loadLanguage('plg_system_creativecontactform', JPATH_ADMINISTRATOR);
    }

    function ccf_make_form($m) {
        $form_id = (int) $m[2];

        //include helper class
        require_once JPATH_SITE.'/components/com_creativecontactform/helpers/helper.php';

        $ccf_class = new CreativecontactformHelper;
        $ccf_class->form_id = $form_id;
        $ccf_class->type = 'plugin';
        $ccf_class->class_suffix = 'ccf_plg';
        $ccf_class->module_id = $this->plg_order;
        $this->plg_order ++;

        return  $ccf_class->render_html();
    }

    function render_ccf_recaptcha_scripts($content) {
        //recaptcha replace scripts/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        preg_match_all('/<script class=\"ccf_recaptcha_script\" type=\"text\/javascript\"\>(.*?)<\/script>/s', $content, $rcp_matched);
        if(is_array($rcp_matched[1])) {
            $rcp_verify_functions = '';
            $rcp_onload_functions = '';
            $content = preg_replace('/<script class=\"ccf_recaptcha_script\" type=\"text\/javascript\"\>.*?<\/script>/s', '', $content);
            foreach($rcp_matched[1] as $rcp_script) {
                $rcp_script = trim(preg_replace('/\s\s+/', ' ', $rcp_script));

                preg_match('/^(.*)var ccf_recaptcha_onload = function\(\) \{(.*)\}$/u', $rcp_script, $rcp_final_matches);
                $rcp_verify_functions .= $rcp_final_matches[1];
                $rcp_onload_functions .= $rcp_final_matches[2];
            }
        }

        //generate recaptcha script
        $scripts = '';
        if($rcp_verify_functions != '') {
            $rcp_verify_functions = trim(preg_replace('/\s\s+/', ' ', $rcp_verify_functions));
            $rcp_onload_functions = trim(preg_replace('/\s\s+/', ' ', $rcp_onload_functions));

            $scripts = '<script type="text/javascript">'.$rcp_verify_functions.'var ccf_recaptcha_onload = function() {'.$rcp_onload_functions.'}</script>' . "\n";
        }
        //END generate recaptcha script

        $content = str_replace('</head>', $scripts . '</head>', $content);
        return $content;
    }

    function render_styles_scripts() {
        $document = JFactory::getDocument();
        $content = JResponse::getBody();
        $db = JFactory::getDBO();

        $version = '3.2.0';
        $scripts = '';

        //check if component or module loaded CCF scripts already, if no, load them
        if (strpos($content,'components/com_creativecontactform/assets/css/main.css') === false) {

            $cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/main.css?version='.$version;
            $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

            $cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creativecss-ui.css';
            $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

            $cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creative-scroll.css';
            $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

            $cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creative-tooltip.css';
            $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

            $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creativelib.js';
            $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

            $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creativelib-ui.js';
            $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

            $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creative-mousewheel.js';
            $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

            $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creative-scroll.js';
            $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

        }

        // check if upload script included
        $upload_scripts_included = strpos($content,'/components/com_creativecontactform/assets/css/creative-upload.css') === false ? false : true;

        // check if datepicker included
        $datepicker_scripts_included = strpos($content,'/components/com_creativecontactform/assets/css/creative-datepicker.css') === false ? false : true;

        // check if google recaptcha script included
        $rcp_scripts_included = strpos($content,'https://www.google.com/recaptcha/api.js?onload=ccf_recaptcha_onload&render=explicit') === false ? false : true;

        preg_match_all('/(\[creativecontactform id="([0-9]+)"\])/s',$content,$m);

        if(is_array($m[2])) {

            $module_id = 10000;
            $plg_order_index = 0;
            $forms_ids = array();


            foreach($m[2] as $form_id) {

                //get types array
                $types_array = $this->ccf_get_types_array($form_id);


                //check if style script not loaded, then add it
                if(!in_array($form_id,$forms_ids) && strpos($content,'view=creativestyles&format=raw'.$form_id) === false) {
                    $cssFilesrc = JURI::base(true).'/index.php?option=com_creativecontactform&view=creativestyles&format=raw&id_form='.$form_id.'&module_id=0';
                    $scripts .= '<link rel="stylesheet" href="'.$cssFilesrc.'" type="text/css" />'."\n";
                }


                //upload script/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (!$upload_scripts_included) {

                    if(in_array('file-upload',$types_array)) {
                        $cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creative-upload.css';
                        $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

                        $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.iframe-transport.js';
                        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

                        $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.fileupload.js';
                        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

                        $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.fileupload-process.js';
                        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

                        $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/jquery.fileupload-validate.js';
                        $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";

                        // if one of forms require file-upload sripts, and other CCF scripts have been loaded, make appropriate scripts order
                        if (strpos($content,'components/com_creativecontactform/assets/css/main.css') !== false) {
                            $content = preg_replace('/(<script.*?creativecontactform\.js.*?><\/script>)/',$scripts . "$1", $content);
                            $scripts = '';
                        }

                        $upload_scripts_included = true;
                    }
                }
                //end upload script/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                //recaptcha script/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (!$rcp_scripts_included) {
                    $jsFile = 'https://www.google.com/recaptcha/api.js?onload=ccf_recaptcha_onload&render=explicit';
                    $scripts .= '<script src="'.$jsFile.'" async defer></script>'."\n";

                    $rcp_scripts_included = true;
                }

                //datepicker css/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                if (in_array('datepicker',$types_array) && !$datepicker_scripts_included) {
                    $cssFile = JURI::base(true).'/components/com_creativecontactform/assets/css/creative-datepicker.css';
                    $scripts .= '<link rel="stylesheet" href="'.$cssFile.'" type="text/css" />'."\n";

                    $datepicker_scripts_included = true;
                }

                $forms_ids[] = $form_id;
                $plg_order_index ++;
                $module_id += $plg_order_index;
            }

        }

        //check if component ot module loaded CCF scripts already, if no, load them
        if (strpos($content,'components/com_creativecontactform/assets/css/main.css') === false) {
            $jsFile = JURI::base(true).'/components/com_creativecontactform/assets/js/creativecontactform.js?version='.$version;
            $scripts .= '<script src="'.$jsFile.'" type="text/javascript"></script>'."\n";
        }


        $content = str_replace('</head>', $scripts . '</head>', $content);
        return $content;
    }

    function ccf_get_types_array($form_id) {
        $db = JFactory::getDBO();

        //get field types array/////////////////////////////////////////////////////////////////////////////////////////////////
        $query = "
              SELECT
              sp.id,
              st.name as type
              FROM
              `#__creative_fields` sp
              JOIN `#__creative_field_types` st ON st.id = sp.id_type
              WHERE sp.published = '1'
              AND sp.id_form = '".$form_id."'
              ORDER BY sp.ordering,sp.id
            ";
        $db->setQuery($query);
        $types_array_data = $db->loadAssocList();
        $types_array_index = 1;
        $types_array = array();
        if(is_array($types_array_data)) {
          foreach($types_array_data as $type) {
            $types_array[$types_array_index] = strtolower(str_replace(' ','-',str_replace('-','',$type['type'])));
            $types_array_index ++;
          }
        }
        return $types_array;
    }
    
    function onAfterRender() {
        $mainframe = JFactory::getApplication();
        if($mainframe->isAdmin())
            return;

        $plugin = JPluginHelper::getPlugin('system', 'creativecontactform');
        $pluginParams = json_decode( $plugin->params );

        $content = JResponse::getBody();

        //If shortcode found, then add scripts
        if(preg_match('/(\[creativecontactform id="([0-9]+)"\])/s',$content))
            $content = $this->render_styles_scripts();

        //check if any ccf render recaptha script
        $rcp_scripts_included = strpos($content,'https://www.google.com/recaptcha/api.js?onload=ccf_recaptcha_onload&render=explicit') === false ? false : true;

        // if there is no shortcode, and module or component does not load CCF as well, then return
        if(!preg_match('/(\[creativecontactform id="([0-9]+)"\])/s',$content) && !$rcp_scripts_included)
            return;
      
        //if shortcode found, render form
        if(preg_match('/(\[creativecontactform id="([0-9]+)"\])/s',$content)) {
            $this->plg_order = 10000;
            //plugin 
            $content = preg_replace_callback('/(\[creativecontactform id="([0-9]+)"\])/s',array($this, 'ccf_make_form'),$content);
        }

        //if any ccf script have rendered recaptcha, then make js corrections
        if($rcp_scripts_included)
            $content = $this->render_ccf_recaptcha_scripts($content);
      
        JResponse::setBody($content);
    }

}