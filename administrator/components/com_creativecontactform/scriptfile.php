<?php
/**
 * Joomla! component Creative Contact Form
 *
 * @version $Id: 2012-04-05 14:30:25 svn $
 * @author creative-solutions.net
 * @package Creative Contact Form
 * @subpackage com_creativecontactform
 * @license GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restircted access');

class com_creativecontactformInstallerScript {

    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent) {
        // installing module
        $module_installer = new JInstaller;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module'))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_SUCCESS').'</p>';
        else
           echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_FAILED').'</p>';

       // installing plugin
        $plugin_installer = new JInstaller;
        if($plugin_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin'))
             echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_SUCCESS').'</p>';
        else
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_FAILED').'</p>';
        
        // enabling plugin
        $db = JFactory::getDBO();
        $db->setQuery('UPDATE #__extensions SET enabled = 1 WHERE element = "creativecontactform" AND folder = "system"');
        $db->query();
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent) {
        // $parent is the class calling this method
        //echo '<p>' . JText::_('COM_HELLOWORLD_UNINSTALL_TEXT') . '</p>';

        $db = JFactory::getDBO();
        
        
        
        $sql = 'SELECT `extension_id` AS id, `name`, `element`, `folder` FROM #__extensions WHERE `type` = "module" AND ( (`element` = "mod_creativecontactform") ) ';
        $db->setQuery($sql);
        $creative_module = $db->loadObject();
        $module_uninstaller = new JInstaller;
        if($module_uninstaller->uninstall('module', $creative_module->id))
        	 echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_UNINSTALL_SUCCESS').'</p>';
        else
        	echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_UNINSTALL_FAILED').'</p>';

         // uninstalling creative image slider plugin
        $db->setQuery("select extension_id from #__extensions where type = 'plugin' and element = 'creativecontactform'");
        $creative_plugin = $db->loadObject();
        $plugin_uninstaller = new JInstaller;
        if($plugin_uninstaller->uninstall('plugin', $creative_plugin->extension_id))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_UNINSTALL_SUCCESS').'</p>';
        else
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_UNINSTALL_FAILED').'</p>';
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent) {
        $module_installer = new JInstaller;
        if(@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.'module'))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_SUCCESS').'</p>';
        else
           echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_MODULE_INSTALL_FAILED').'</p>';

        $plugin_uninstaller = new JInstaller;
        if(@$plugin_uninstaller->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'plugin'))
            echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_SUCCESS').'</p>';
        else
           echo '<p>'.JText::_('COM_CREATIVECONTACTFORM_PLUGIN_INSTALL_FAILED').'</p>';
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent) {
        // $parent is the class calling this method
        // $type is the type of change (install, update or discover_install)
        //echo '<p>' . JText::_('COM_HELLOWORLD_PREFLIGHT_' . $type . '_TEXT') . '</p>';
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent) {
        $db = JFactory::getDBO();

       //2.0.1 -> 3.0.0 update/////////////////////////////////////////////////////////////////////////////////////////////
        $query = "SELECT * FROM `#__creative_fields` LIMIT 1";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();
        
        if(is_array($columns_data)) {
            $columns_titles = array_keys($columns_data);
            if(!in_array('datepicker_date_format',$columns_titles)) {
                //add required columns to __creative_fields
                $query_update = "
                                    ALTER TABLE  `#__creative_fields`   
                                        ADD `tooltip_text` text not null after `name`,
                                        ADD `field_margin_top` text not null after `width`,
                                        ADD `column_type` tinyint not null DEFAULT  '0',
                                        ADD `datepicker_date_format` text not null,
                                        ADD `datepicker_animation` text not null,
                                        ADD `datepicker_style` SMALLINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `datepicker_icon_style` SMALLINT NOT NULL DEFAULT  '1',
                                        ADD `datepicker_show_icon` SMALLINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `datepicker_input_readonly` SMALLINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `datepicker_number_months` SMALLINT UNSIGNED NOT NULL DEFAULT  '1',
                                        ADD `datepicker_mindate` text not null,
                                        ADD `datepicker_maxdate` text not null,
                                        ADD `datepicker_changemonths` SMALLINT UNSIGNED NOT NULL DEFAULT  '0',
                                        ADD `datepicker_changeyears` SMALLINT UNSIGNED NOT NULL DEFAULT  '0',
                                        ADD `custom_html` text not null,
                                        ADD `heading` text not null,
                                        ADD `google_maps` text not null,
                                        ADD `recaptcha_site_key` text not null,
                                        ADD `recaptcha_security_key` text not null,
                                        ADD `recaptcha_wrong_message` text not null,
                                        ADD `recaptcha_theme` text not null,
                                        ADD `recaptcha_type` text not null,
                                        ADD `contact_data` text not null,
                                        ADD `contact_data_width` SMALLINT UNSIGNED NOT NULL DEFAULT '120',
                                        ADD `creative_popup` text not null,
                                        ADD `creative_popup_embed` text not null
                                    ";
                $db->setQuery($query_update);
                $db->query();

                //add required columns to __creative_forms
                $query_update = "
                                    ALTER TABLE  `#__creative_forms`   
                                        ADD `email_info_show_referrer` tinyint not null DEFAULT  '1',
                                        ADD `email_info_show_ip` tinyint not null DEFAULT  '1',
                                        ADD `email_info_show_browser` tinyint not null DEFAULT  '1',
                                        ADD `email_info_show_os` tinyint not null DEFAULT  '1',
                                        ADD `email_info_show_sc_res` tinyint not null DEFAULT  '1',
                                        ADD `custom_css` text not null
                                    ";
                $db->setQuery($query_update);
                $db->query();


                //add new field types
                $query_update = "INSERT INTO  `#__creative_field_types`(`id`, `name`) VALUES (NULL, 'Datepicker'),(NULL, 'Custom Html'),(NULL, 'Heading'),(NULL, 'Google Maps'),(NULL, 'Google reCAPTCHA'),(NULL, 'Contact Data'),(NULL, 'Creative Popup')";
                $db->setQuery($query_update);
                $db->query();


                //update templates
                $query = "SELECT `id`,`styles` FROM `#__contact_templates`";
                $db->setQuery($query);
                $styles = $db->LoadAssocList();
                $addon_styles = '587~#111111|588~13|589~1|627~1|517~50|518~50|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~15|606~15|607~0|608~solid|609~#ffffff|610~0|611~#ffffff|612~#ffffff|613~5|614~15|615~10|616~15|617~0|618~#ffffff|619~#ffffff|620~15|621~15|622~15|623~15|624~0|625~solid|626~#ffffff|506~inherit|510~ccf_font_effect_none|502~left|511~ccf_font_effect_none|507~inherit|512~ccf_font_effect_none|509~inherit|505~white|508~inherit|519~85|520~90|500~left|501~left|513~ccf_font_effect_none|514~ccf_font_effect_none|521~85|522~90|523~130|535~8|536~15|537~9|538~12|539~15|540~15|541~#e3e3e3|542~#e6e6e6|543~1|544~1|545~1|546~1|547~dotted|548~#b8b8b8|549~#b8b8b8|550~#b8b8b8|551~#b8b8b8|524~#525252|525~15|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#6b6b6b|532~0|533~0|534~0|515~ccf_font_effect_none|516~ccf_font_effect_none|552~1|553~#3d3d3d|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#fafafa|558~#ffffff|559~0|560~0|561~0|563~10|562~1|597~10|598~30|564~#0055cc|565~bold|566~normal|594~none|567~1|568~dotted|569~#ffffff|570~#ffffff|571~0|572~0|573~0|574~#b00023|595~none|575~#b50000|576~#ffffff|577~0|578~0|579~0|580~#008f00|581~normal|582~italic|593~none|583~#ffffff|584~0|585~0|586~0|599~|629~dark-thin|630~dark-thin|589~1|628~';
                if(is_array($styles)) {
                    foreach($styles as $val) {
                        $t_id = $val["id"];
                        $t_styles = $val["styles"];
                        $updates_styles = addslashes($t_styles) . '|' . addslashes($addon_styles);

                        $query_update_t = "UPDATE `#__contact_templates` SET `styles` = '".$updates_styles."' WHERE `id` = '".$t_id."'";
                        $db->setQuery($query_update_t);
                        $db->query();
                    }
                }
                //END update styles
                
            }

        }
        // END 2.0.1->3.0.0 update////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        // FREE TO PRO UPDATE////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $query_update = 
                            "
                                UPDATE `#__creative_field_types` SET `name` = CASE
                                    WHEN id = 13 THEN 'Captcha'
                                    WHEN id = 16 THEN 'Custom Html'
                                    WHEN id = 17 THEN 'Heading'
                                    WHEN id = 18 THEN 'Google Maps'
                                    WHEN id = 20 THEN 'Contact Data'
                                    ELSE `name`
                                    END 
                                WHERE id in (13,16,17,18,20)
                            ";
        $db->setQuery($query_update);
        $db->query();

        // INSTALL TEMPLATES////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $query = "SELECT `name` FROM `#__contact_templates`";
        $db->setQuery($query);
        $tmp_names_array = $db->LoadAssocList();

        $tmp_names = array();
        if(is_array($tmp_names_array)) {
            foreach($tmp_names_array as $k => $tmp_name) {
                $tmp_names[] = $tmp_name["name"];
            }
        }

        if(!in_array('Gray Template 1', $tmp_names)) {

            $ccf_templates_array  = array
                                            (
                                                'White Template 1' => '587~#111111|588~13|131~Arial, Helvetica, sans-serif|589~1|629~inset-2-dark|630~inset-2-dark|627~1|0~#ffffff|130~#ffffff|517~50|518~50|1~#dedede|2~1|3~solid|4~0|5~0|6~0|7~0|8~#ffffff|9~|10~0|11~0|12~0|13~0|14~#bababa|15~|16~0|17~0|18~7|19~0|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~15|606~15|607~0|608~solid|609~#ffffff|610~0|611~#ffffff|612~#ffffff|613~5|614~15|615~10|616~15|617~0|618~#ffffff|619~#ffffff|620~0|621~15|622~15|623~15|624~0|625~solid|626~#ffffff|20~#000000|21~28|22~normal|23~normal|24~none|25~left|506~inherit|510~ccf_font_effect_none|27~#ffffff|28~2|29~1|30~2|190~3|191~0|192~82|502~left|193~3|194~1|195~#a8a8a8|196~dotted|197~#000000|198~13|199~normal|200~normal|201~none|202~inherit|511~ccf_font_effect_none|203~#ffffff|204~0|205~0|206~0|215~0|216~0|217~1|218~3|31~#000000|32~13|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#ffffff|38~2|39~1|40~1|41~#ff0000|42~20|43~normal|44~normal|509~inherit|46~#ffffff|47~0|48~0|49~0|505~white|508~inherit|132~#ffffff|133~#ffffff|168~60|519~90|520~90|500~left|501~left|134~#cccccc|135~1|136~solid|137~0|138~0|139~0|140~0|141~#f5f5f5|142~|143~0|144~0|145~10|146~0|147~#000000|148~14|149~normal|150~normal|151~none|152~inherit|153~#ffffff|154~0|155~0|156~0|157~#ffffff|158~#ffffff|159~#1c1c1c|160~#ffffff|161~#cccccc|162~#d4d4d4|163~|164~0|165~0|166~10|167~2|513~ccf_font_effect_none|176~#ffdbdd|177~#ffdbdd|178~#ff9999|179~#363636|180~#ffffff|181~0|182~0|183~0|184~#ebaaaa|185~inset|186~0|187~0|188~19|189~0|171~#c70808|514~ccf_font_effect_none|172~#ffffff|173~2|174~1|175~1|169~95|521~90|522~90|170~150|523~130|535~8|536~15|537~9|538~12|539~15|540~15|541~#f4f6f7|542~#f4f6f7|543~1|544~1|545~1|546~1|547~solid|548~#d4d4d4|549~#d4d4d4|550~#d4d4d4|551~#d4d4d4|524~#525252|525~15|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#e0e0e0|532~0|533~0|534~0|91~#ffffff|50~#e0e0e0|212~right|92~12|93~26|209~95|100~#c2c2c2|101~1|127~solid|102~0|103~0|104~0|105~0|94~#525252|95~|96~0|97~0|98~0|99~0|106~#666666|107~14|108~bold|109~normal|110~none|112~inherit|515~ccf_font_effect_none|113~#ffffff|114~0|115~0|116~3|51~#ffffff|52~#e0e0e0|124~#6b6b6b|516~ccf_font_effect_none|125~#ffffff|126~#cfcfcf|117~#999999|118~|119~0|120~0|121~6|122~0|552~1|553~#3d3d3d|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#fafafa|558~#ffffff|559~0|560~0|561~0|563~10|562~1|597~10|598~30|564~#0055cc|565~bold|566~normal|594~none|567~1|568~dotted|569~#ffffff|570~#ffffff|571~0|572~0|573~0|574~#b00023|595~none|575~#b50000|576~#ffffff|577~0|578~0|579~0|580~#008f00|581~normal|582~italic|593~none|583~#ffffff|584~0|585~0|586~0|599~/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nbackground-color: #ddd;\ncolor: #333;\nborder-radius: 12px;\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.6);\nborder-top: 1px solid rgba(0,0,0,0.2);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #666;\nbackground: #fff;\nbackground: rgba(255,255,255,0.8);\n}|628~',
                                                'Black Template 2' => '587~#ffffff|588~13|131~ccf-googlewebfont-Actor|589~2|629~3d-dark|630~3d|627~1|0~#2e2d2e|130~#050505|517~50|518~50|1~#2b2b2b|2~1|3~solid|4~12|5~0|6~0|7~12|8~#202020|9~|10~0|11~0|12~7|13~0|14~#000000|15~|16~0|17~0|18~10|19~1|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~15|606~15|607~0|608~solid|609~#ffffff|610~0|611~#ffffff|612~#ffffff|613~5|614~15|615~10|616~15|617~0|618~#ffffff|619~#ffffff|620~15|621~15|622~15|623~15|624~0|625~solid|626~#ffffff|20~#ffffff|21~30|22~normal|23~normal|24~none|25~left|506~ccf-googlewebfont-Antic Slab|510~ccf_font_effect_none|27~#000000|28~1|29~1|30~3|190~2|191~0|192~90|502~left|193~6|194~1|195~#808080|196~dotted|197~#fafafa|198~13|199~normal|200~italic|201~none|202~inherit|511~ccf_font_effect_none|203~#000000|204~-1|205~2|206~2|215~10|216~0|217~2|218~1|31~#ffffff|32~14|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#000000|38~1|39~1|40~1|41~#d60000|42~21|43~normal|44~normal|509~inherit|46~#000000|47~0|48~0|49~0|505~carrot-orange|508~inherit|132~#202020|133~#383838|168~60|519~85|520~90|500~left|501~left|134~#949494|135~1|136~solid|137~4|138~4|139~4|140~4|141~#ffffff|142~|143~0|144~0|145~0|146~0|147~#fafafa|148~14|149~normal|150~normal|151~none|152~inherit|153~#fcfcfc|154~0|155~0|156~0|157~#454545|158~#0a0a0a|159~#ffffff|160~#ff0000|161~#6b6b6b|162~#fcffc2|163~|164~0|165~0|166~20|167~-1|513~ccf_font_effect_none|176~#f0b400|177~#701a00|178~#e6cfcf|179~#ffffff|180~#000000|181~-1|182~-1|183~1|184~#ffffff|185~|186~0|187~0|188~15|189~-2|171~#e03c00|514~ccf_font_effect_none|172~#000000|173~0|174~1|175~2|169~95|521~85|522~90|170~150|523~130|535~8|536~15|537~9|538~12|539~15|540~15|541~#666666|542~#242424|543~1|544~1|545~1|546~1|547~solid|548~#808080|549~#6b6b6b|550~#424242|551~#6b6b6b|524~#ffffff|525~15|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#000000|532~-1|533~-1|534~2|91~#616161|50~#000000|212~left|92~9|93~33|209~90|100~#383038|101~1|127~solid|102~8|103~0|104~0|105~8|94~#ffffff|95~|96~0|97~2|98~12|99~-2|106~#d1d1d1|107~15|108~bold|109~normal|110~none|112~ccf-googlewebfont-Antic Slab|515~ccf_font_effect_none|113~#000103|114~1|115~-1|116~1|51~#000000|52~#696969|124~#fafafa|516~ccf_font_effect_none|125~#000000|126~#383038|117~#ffffff|118~|119~1|120~-1|121~12|122~-2|552~2|553~#d1d1d1|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#fafafa|558~#000000|559~-1|560~-1|561~2|563~21|562~2|597~10|598~30|564~#639cff|565~normal|566~normal|594~none|567~0|568~dotted|569~#ffffff|570~#000000|571~1|572~1|573~2|574~#db002c|595~underline|575~#b50000|576~#000000|577~1|578~1|579~2|580~#008f00|581~normal|582~italic|593~none|583~#000000|584~-1|585~-1|586~1|599~.creative_form_FORM_ID .ccf_content_icon {\n/*background-color: #545454;*/\n}\n/*popup styles*********************************************/\n.creative_form_FORM_ID.ccf_popup_inner_wrapper  .creativecontactform_heading {\nbackground: rgba(44, 44, 44, 1) !important;\n}\n/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nbackground-color: rgba(132, 132, 132, 0.25);\ncolor: #ddd;\ntext-shadow: -1px 2px 2px #000;\nborder-radius: 12px;\n}\n.creative_form_FORM_ID .creative_content_scrollbar h1 {\ncolor: #fff;\ntext-shadow: -1px 2px 2px #000;\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.08);\nborder-top: 1px solid rgba(0,0,0,0.7);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #c2c2c2;\nbackground:rgba(27, 27, 27, 1);\n}|628~',
                                                'Gray Template 1' => '587~#000819|588~13|131~ccf-googlewebfont-Actor|589~1|629~inset-dark|630~inset-dark|627~0|0~#121212|130~#0f0f0f|517~50|518~50|1~#707070|2~1|3~solid|4~0|5~0|6~0|7~0|8~#ffffff|9~|10~0|11~0|12~1|13~0|14~#000000|15~|16~0|17~0|18~3|19~0|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~15|606~15|607~5|608~solid|609~#000000|610~1|611~#ebebeb|612~#c7c7c7|613~25|614~15|615~15|616~15|617~0|618~#ffffff|619~#ffffff|620~15|621~21|622~20|623~15|624~3|625~solid|626~#000000|20~#ffffff|21~28|22~normal|23~normal|24~none|25~left|506~inherit|510~ccf_font_effect_none|27~#000000|28~2|29~1|30~4|190~3|191~0|192~82|502~left|193~3|194~1|195~#a8a8a8|196~dotted|197~#dbdbdb|198~13|199~normal|200~normal|201~none|202~inherit|511~ccf_font_effect_none|203~#000000|204~0|205~0|206~0|215~0|216~0|217~1|218~3|31~#000000|32~13|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#ffffff|38~2|39~1|40~1|41~#d40808|42~22|43~normal|44~normal|509~inherit|46~#ffffff|47~0|48~0|49~0|505~black|508~inherit|132~#ffffff|133~#ffffff|168~60|519~85|520~90|500~left|501~left|134~#8a8a8a|135~1|136~solid|137~0|138~0|139~0|140~0|141~#000819|142~inset|143~0|144~0|145~0|146~0|147~#000819|148~14|149~normal|150~normal|151~none|152~inherit|153~#ffffff|154~0|155~0|156~0|157~#ffffff|158~#ffffff|159~#000819|160~#ffffff|161~#8a8a8a|162~#878787|163~inset|164~0|165~0|166~10|167~0|513~ccf_font_effect_none|176~#ffdbdd|177~#ffdbdd|178~#f27777|179~#000819|180~#ffffff|181~-1|182~1|183~1|184~#ebaaaa|185~inset|186~0|187~0|188~18|189~0|171~#b30000|514~ccf_font_effect_none|172~#ffffff|173~2|174~1|175~1|169~95|521~85|522~90|170~150|523~167|535~7|536~15|537~8|538~12|539~15|540~15|541~#999999|542~#a6a6a6|543~1|544~1|545~1|546~1|547~solid|548~#8f8f8f|549~#9c9c9c|550~#949494|551~#9c9c9c|524~#ffffff|525~15|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#000000|532~-1|533~-1|534~1|91~#ffffff|50~#b0b0b0|212~right|92~10|93~20|209~99|100~#000819|101~1|127~solid|102~12|103~12|104~12|105~12|94~#696969|95~|96~0|97~0|98~4|99~0|106~#000819|107~15|108~bold|109~normal|110~none|112~inherit|515~ccf_font_effect_none|113~#ffffff|114~0|115~0|116~3|51~#ffffff|52~#8f8f8f|124~#000819|516~ccf_font_effect_none|125~#ffffff|126~#000000|117~#9c9fa6|118~|119~0|120~0|121~7|122~1|552~4|553~#000000|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#ffffff|558~#ffffff|559~0|560~0|561~0|563~10|562~1|597~10|598~30|564~#003bb0|565~bold|566~normal|594~none|567~0|568~dotted|569~#ffffff|570~#808080|571~0|572~0|573~0|574~#b00023|595~none|575~#b50000|576~#ffffff|577~0|578~0|579~0|580~#008f00|581~normal|582~italic|593~none|583~#ffffff|584~0|585~0|586~0|599~/*bg images************************************************/\n.creative_form_FORM_ID .creativecontactform_header {\nbackground-image: url("ccf_img_path/bg_header.jpg") !important;\nbackground-repeat: repeat !important;\nbackground-size: auto auto !important;\nbackground-color: #161616 !important;\n}\n.creative_form_FORM_ID .creativecontactform_footer {\nbackground-image: url("ccf_img_path/bg_footer.png") !important;\nbackground-repeat: repeat-x !important;\nbackground-size: auto auto !important;\n}\n/*contact data icons styles******************************/\n.creative_form_FORM_ID .ccf_content_icon {\nbackground-color: rgba(165, 165, 165, 1);\n/*border-radius: 100%;*/\nbox-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.33);\n}\n/*header link**********************************************/\n.creative_form_FORM_ID .creativecontactform_header a {\ncolor: #689AFF !important; \ntext-shadow: none !important;\nborder-bottom: none !important;\n}\n.creative_form_FORM_ID .creativecontactform_header a:hover{\ncolor: #D31E1E !important;\ntext-shadow: none !important;\nborder-bottom: none !important;\n}\n\n/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nbackground-color: #ececec;\ncolor: #333;\nborder-radius: 12px;\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.6);\nborder-top: 1px solid rgba(0,0,0,0.2);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #666;\nbackground: #fff;\nbackground: rgba(255,255,255,0.8);\n}\n|628~',
                                                'Blue Template 3' => '587~#ffffff|588~13|131~ccf-googlewebfont-Antic|589~1|629~3d-thick-dark|630~3d-thick|627~1|0~#0036bd|130~#0036bd|517~50|518~50|1~#001445|2~1|3~solid|4~10|5~10|6~10|7~10|8~#001445|9~inset|10~0|11~0|12~49|13~10|14~#001445|15~inset|16~0|17~0|18~50|19~15|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~10|606~15|607~0|608~solid|609~#ffffff|610~0|611~#ffffff|612~#ffffff|613~5|614~15|615~5|616~15|617~0|618~#ffffff|619~#ffffff|620~5|621~15|622~15|623~15|624~0|625~solid|626~#ffffff|20~#ffffff|21~30|22~normal|23~normal|24~none|25~left|506~inherit|510~ccf_font_effect_none|27~#000000|28~2|29~1|30~2|190~6|191~-2|192~90|502~left|193~3|194~1|195~#ffffff|196~dotted|197~#ffffff|198~13|199~normal|200~italic|201~none|202~inherit|511~ccf_font_effect_none|203~#000000|204~2|205~1|206~1|215~0|216~0|217~1|218~3|31~#ffffff|32~13|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#000000|38~2|39~1|40~1|41~#ff0000|42~18|43~bold|44~normal|509~inherit|46~#000000|47~2|48~1|49~1|505~dark-midnight-blue|508~inherit|132~#8389fc|133~#ffffff|168~63|519~85|520~90|500~left|501~left|134~#b6c9f5|135~1|136~solid|137~7|138~7|139~7|140~7|141~#89a100|142~inset|143~0|144~0|145~0|146~0|147~#000000|148~13|149~normal|150~normal|151~none|152~inherit|153~#0036bd|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|513~ccf_font_effect_none|176~#ff0022|177~#380000|178~#52000b|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#000000|185~inset|186~1|187~1|188~10|189~0|171~#f70021|514~ccf_font_effect_none|172~#000000|173~2|174~1|175~1|169~93|521~85|522~90|170~150|523~130|535~8|536~15|537~9|538~12|539~15|540~15|541~#002582|542~#001f66|543~1|544~1|545~1|546~1|547~solid|548~#0e3c9e|549~#0d2c75|550~#003cc7|551~#0d2c75|524~#fafafa|525~15|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#000000|532~-1|533~1|534~2|91~#e30000|50~#330000|212~right|92~6|93~25|209~93|100~#780000|101~1|127~solid|102~7|103~7|104~7|105~7|94~#000899|95~|96~0|97~0|98~16|99~4|106~#ffffff|107~14|108~bold|109~normal|110~none|112~inherit|515~ccf_font_effect_none|113~#000000|114~1|115~-1|116~1|51~#b80404|52~#1f0000|124~#fafafa|516~ccf_font_effect_none|125~#000000|126~#780000|117~#000899|118~|119~0|120~0|121~18|122~7|552~4|553~#ededed|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#fafafa|558~#000000|559~1|560~1|561~2|563~10|562~1|597~10|598~30|564~#8fbeff|565~bold|566~normal|594~none|567~0|568~dotted|569~#ffffff|570~#000000|571~1|572~1|573~1|574~#ff476c|595~underline|575~#b50000|576~#000000|577~-1|578~-1|579~1|580~#00d600|581~normal|582~italic|593~none|583~#000000|584~1|585~1|586~1|599~/*contact data icons styles*/\n.creative_form_FORM_ID .ccf_content_icon {\nbackground-color: rgba(9, 36, 105, 0.51);\nborder-radius: 100%;\nbox-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.33);\n}\n/*header link**********************************************/\n.creative_form_FORM_ID .creativecontactform_header a {\ncolor: #46A7E2 !important; \ntext-shadow: -1px 1px 2px #000 !important;\nborder-bottom: none !important;\n}\n.creative_form_FORM_ID .creativecontactform_header a:hover{\ncolor: #D31E1E !important;\ntext-shadow: -1px 1px 2px #000 !important;\nborder-bottom: none !important;\n}\n\n/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nborder: 1px solid rgb(26, 26, 26);\nbackground-color: rgba(46, 64, 105, 1);\ncolor: #ddd;\ntext-shadow: -1px 2px 2px #000;\nborder-radius: 12px;\n}\n.creative_form_FORM_ID .creative_content_scrollbar h1 {\ncolor: #fff;\ntext-shadow: -1px 2px 2px #000;\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.08);\nborder-top: 1px solid rgba(0,0,0,0.7);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #c2c2c2;\nbackground: rgba(28, 46, 87, 1);\n}|628~',
                                                'Green Template 1' => '587~#052b1e|588~13|131~ccf-googlewebfont-Cuprum|589~1|629~3d-thick-dark|630~3d-thick-dark|627~0|0~#114159|130~#ffffff|517~50|518~50|1~#063629|2~1|3~solid|4~12|5~12|6~12|7~12|8~#ffffff|9~|10~0|11~0|12~0|13~0|14~#021f16|15~|16~0|17~0|18~5|19~0|600~1|601~#15614b|602~#063326|603~10|604~15|605~10|606~15|607~1|608~solid|609~#ffffff|610~1|611~#d4e6d4|612~#9bc7a4|613~25|614~15|615~15|616~15|617~1|618~#15614b|619~#063326|620~10|621~21|622~12|623~15|624~1|625~solid|626~#c3e0d8|20~#ffffff|21~28|22~normal|23~normal|24~none|25~left|506~inherit|510~ccf_font_effect_none|27~#000000|28~2|29~1|30~4|190~3|191~0|192~82|502~left|193~3|194~1|195~#f5f5f5|196~dotted|197~#f5f5f5|198~13|199~normal|200~normal|201~none|202~inherit|511~ccf_font_effect_none|203~#000000|204~0|205~0|206~0|215~0|216~0|217~1|218~3|31~#000f0a|32~14|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#cfe6df|38~1|39~1|40~10|41~#b30000|42~20|43~normal|44~normal|509~inherit|46~#dbdbdb|47~0|48~0|49~15|505~forest-green|508~inherit|132~#ffffff|133~#ffffff|168~60|519~85|520~90|500~left|501~left|134~#063629|135~1|136~solid|137~0|138~0|139~0|140~0|141~#063629|142~|143~0|144~0|145~0|146~0|147~#063b2d|148~14|149~normal|150~normal|151~none|152~inherit|153~#ffffff|154~0|155~0|156~0|157~#ffffff|158~#ffffff|159~#02241a|160~#ffffff|161~#063629|162~#063629|163~|164~0|165~0|166~12|167~0|513~ccf_font_effect_none|176~#ffffff|177~#ffffff|178~#b32424|179~#9e0808|180~#ffffff|181~-1|182~1|183~1|184~#944141|185~|186~0|187~0|188~9|189~0|171~#8c0000|514~ccf_font_effect_none|172~#ffffff|173~0|174~0|175~10|169~93|521~85|522~90|170~150|523~167|535~10|536~15|537~10|538~12|539~15|540~15|541~#999999|542~#5c5c5c|543~1|544~1|545~1|546~1|547~solid|548~#74a89b|549~#6aad9c|550~#569e8b|551~#6aad9c|524~#ffffff|525~16|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#03241b|532~-1|533~-1|534~1|91~#ffffff|50~#6b9e90|212~right|92~10|93~20|209~99|100~#063629|101~1|127~solid|102~12|103~12|104~12|105~12|94~#27705b|95~|96~0|97~0|98~4|99~0|106~#063629|107~15|108~bold|109~normal|110~none|112~inherit|515~ccf_font_effect_none|113~#ffffff|114~0|115~0|116~3|51~#ffffff|52~#6b9e90|124~#042e22|516~ccf_font_effect_none|125~#ffffff|126~#043326|117~#033325|118~|119~0|120~0|121~7|122~1|552~4|553~#093828|554~15|555~normal|556~normal|596~none|590~0|591~dotted|592~#ffffff|558~#97b8ad|559~0|560~0|561~0|563~25|562~5|597~10|598~30|564~#0a4a35|565~bold|566~normal|594~none|567~1|568~dotted|569~#00354d|570~#90bdae|571~0|572~0|573~0|574~#b00023|595~none|575~#b50000|576~#f5dcdf|577~0|578~0|579~0|580~#085c12|581~bold|582~italic|593~none|583~#cccccc|584~0|585~0|586~0|599~.creative_form_FORM_ID .creativecontactform_heading {\nbackground: rgba(11, 66, 50, 0.33) !important\n}\n.creative_form_FORM_ID.creativecontactform_wrapper {\nbackground-color: transparent !important;\n}\n\n/*contact data icons styles*/\n.creative_form_FORM_ID .ccf_content_icon {\nbackground-color: rgba(11, 77, 58, 0.42);\nborder-radius: 100%;\nbox-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.33);\n}\n\n/*header link**********************************************/\n.creative_form_FORM_ID .creativecontactform_header a {\ncolor: #3AC037 !important; \ntext-shadow: -1px 1px 2px #000 !important;\nborder-bottom: none !important;\n}\n.creative_form_FORM_ID .creativecontactform_header a:hover{\ncolor: #D31E1E !important;\ntext-shadow: -1px 1px 2px #000 !important;\nborder-bottom: none !important;\n}\n\n/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nborder: 1px solid rgba(117, 173, 127, 1);\nbackground-color: rgba(198, 223, 203, 1);\ncolor: #333;\nborder-radius: 12px;\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.6);\nborder-top: 1px solid rgba(0,0,0,0.2);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #666;\nbackground: #fff;\nbackground: rgba(255,255,255,0.8);\n}|628~',
                                                'Orange Template 1' => '587~#111111|588~13|131~ccf-googlewebfont-Karma|589~1|629~inset-dark|630~inset-dark|627~1|0~#fca000|130~#ff9900|517~50|518~50|1~#cc4100|2~1|3~solid|4~10|5~10|6~10|7~10|8~#cc4100|9~inset|10~10|11~10|12~45|13~2|14~#cc4100|15~inset|16~12|17~12|18~50|19~6|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~15|606~15|607~0|608~solid|609~#ffffff|610~0|611~#ffffff|612~#ffffff|613~5|614~15|615~5|616~15|617~0|618~#ffffff|619~#ffffff|620~5|621~15|622~15|623~15|624~0|625~solid|626~#ffffff|20~#ffffff|21~28|22~normal|23~normal|24~none|25~left|506~inherit|510~ccf_font_effect_none|27~#000000|28~-1|29~-1|30~2|190~-1|191~-2|192~90|502~left|193~5|194~1|195~#ffffff|196~dotted|197~#000000|198~13|199~normal|200~italic|201~none|202~inherit|511~ccf_font_effect_none|203~#ffd500|204~0|205~0|206~1|215~0|216~0|217~1|218~3|31~#000000|32~14|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#ffd500|38~0|39~0|40~1|41~#d9001d|42~18|43~bold|44~normal|509~inherit|46~#ffffff|47~0|48~0|49~0|505~sunset|508~inherit|132~#b0b0b0|133~#ffffff|168~63|519~85|520~90|500~left|501~left|134~#ffffff|135~1|136~solid|137~7|138~7|139~7|140~7|141~#262524|142~inset|143~0|144~0|145~25|146~-2|147~#000000|148~14|149~normal|150~normal|151~none|152~inherit|153~#fafafa|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|513~ccf_font_effect_none|176~#b5b5b5|177~#616161|178~#000000|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#1f1f1f|185~inset|186~8|187~10|188~27|189~1|171~#c40a0a|514~ccf_font_effect_none|172~#000000|173~0|174~0|175~0|169~93|521~85|522~90|170~150|523~130|535~10|536~15|537~7|538~12|539~15|540~15|541~#c77920|542~#bf792a|543~0|544~0|545~0|546~0|547~dotted|548~#b8b8b8|549~#b8b8b8|550~#b8b8b8|551~#b8b8b8|524~#ffffff|525~15|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#0f0f0f|532~-1|533~-1|534~2|91~#ff0000|50~#630000|212~right|92~6|93~25|209~93|100~#610000|101~1|127~solid|102~7|103~7|104~7|105~7|94~#300000|95~inset|96~0|97~0|98~0|99~0|106~#ffffff|107~14|108~bold|109~normal|110~none|112~inherit|515~ccf_font_effect_none|113~#000000|114~1|115~-1|116~1|51~#ff0000|52~#520000|124~#fafafa|516~ccf_font_effect_none|125~#000000|126~#610000|117~#300000|118~inset|119~2|120~3|121~9|122~-2|552~4|553~#3d3d3d|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#fafafa|558~#000000|559~0|560~0|561~0|563~2|562~1|597~10|598~30|564~#006aff|565~bold|566~normal|594~none|567~0|568~dotted|569~#ffffff|570~#f7f7f7|571~1|572~1|573~3|574~#ffffff|595~underline|575~#b50000|576~#050005|577~1|578~1|579~2|580~#008f00|581~normal|582~italic|593~none|583~#ffffff|584~1|585~1|586~2|599~/*contact data icons styles*/\n.creative_form_FORM_ID .ccf_content_icon {\nbackground-color: rgba(184, 113, 0, 1);\nborder-radius: 100%;\nbox-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.33);\n}\n\n/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nbackground-color: rgba(221, 164, 75, 1);\ncolor: #333;\nborder-radius: 12px;\nborder: 1px solid rgb(152, 92, 0);\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.6);\nborder-top: 1px solid rgba(0,0,0,0.2);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #666;\nbackground: #fff;\nbackground: rgba(255, 255, 255, 0.53);\n}\n|628~',
                                                'Red Template 1' => '587~#ffffff|588~12|131~ccf-googlewebfont-Dosis|589~2|629~inset-2-dark|630~inset-2|627~1|0~#b0000f|130~#700009|517~50|518~50|1~#470006|2~1|3~solid|4~10|5~10|6~10|7~10|8~#470006|9~inset|10~0|11~0|12~49|13~10|14~#470006|15~inset|16~0|17~0|18~50|19~15|600~0|601~#ffffff|602~#ffffff|603~15|604~15|605~15|606~15|607~0|608~solid|609~#ffffff|610~0|611~#ffffff|612~#ffffff|613~5|614~15|615~5|616~15|617~0|618~#ffffff|619~#ffffff|620~5|621~15|622~15|623~15|624~0|625~solid|626~#ffffff|20~#ffffff|21~30|22~normal|23~normal|24~none|25~left|506~inherit|510~ccf_font_effect_none|27~#000000|28~2|29~1|30~2|190~6|191~-2|192~90|502~left|193~3|194~1|195~#ffffff|196~dotted|197~#ffffff|198~14|199~normal|200~italic|201~none|202~inherit|511~ccf_font_effect_none|203~#000000|204~2|205~1|206~1|215~0|216~0|217~1|218~3|31~#ffffff|32~14|33~normal|34~normal|35~none|36~left|507~inherit|512~ccf_font_effect_none|37~#000000|38~2|39~1|40~1|41~#ffffff|42~18|43~bold|44~normal|509~inherit|46~#ffffff|47~0|48~0|49~0|505~black|508~inherit|132~#ffffff|133~#ffffff|168~63|519~85|520~90|500~left|501~left|134~#540000|135~1|136~solid|137~7|138~7|139~7|140~7|141~#000000|142~inset|143~0|144~0|145~25|146~1|147~#000000|148~13|149~normal|150~normal|151~none|152~inherit|153~#fafafa|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|513~ccf_font_effect_none|176~#7a7a7a|177~#030303|178~#000000|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#1f1f1f|185~inset|186~8|187~10|188~27|189~2|171~#f7ff05|514~ccf_font_effect_none|172~#000000|173~0|174~0|175~0|169~93|521~85|522~90|170~150|523~130|535~8|536~15|537~9|538~12|539~15|540~15|541~#d64655|542~#e08f97|543~0|544~0|545~0|546~0|547~dotted|548~#b8b8b8|549~#b8b8b8|550~#b8b8b8|551~#b8b8b8|524~#141414|525~14|526~normal|527~normal|528~none|529~inherit|530~ccf_font_effect_none|531~#6b6b6b|532~0|533~0|534~0|91~#4f4f4f|50~#000000|212~right|92~10|93~25|209~93|100~#2e0606|101~1|127~solid|102~7|103~7|104~7|105~7|94~#a10000|95~|96~0|97~0|98~16|99~4|106~#ffffff|107~14|108~bold|109~normal|110~none|112~inherit|515~ccf_font_effect_none|113~#000000|114~1|115~-1|116~1|51~#424242|52~#000000|124~#fafafa|516~ccf_font_effect_none|125~#000000|126~#2e0606|117~#a10000|118~|119~0|120~0|121~18|122~7|552~4|553~#ffffff|554~14|555~normal|556~normal|596~none|590~0|591~dotted|592~#fafafa|558~#000000|559~-1|560~-1|561~1|563~22|562~6|597~10|598~30|564~#ffffff|565~bold|566~normal|594~none|567~1|568~dashed|569~#ffffff|570~#000000|571~0|572~0|573~0|574~#bdbdbd|595~none|575~#a3a3a3|576~#000000|577~1|578~1|579~2|580~#97a8fc|581~normal|582~italic|593~none|583~#000000|584~1|585~1|586~2|599~/*Creative Scrollbar***************************************/\n.creative_form_FORM_ID .creative_content_scrollbar {\nborder: 1px solid rgb(42, 0, 3);\nbackground-color: rgba(18, 18, 18, 0.5);\ncolor: #ddd;\ntext-shadow: -1px 2px 2px #000;\nborder-radius: 12px;\n}\n.creative_form_FORM_ID .creative_content_scrollbar h1 {\ncolor: #fff;\ntext-shadow: -1px 2px 2px #000;\n}\n.creative_form_FORM_ID .creative_content_scrollbar hr {\nborder-bottom: 1px solid rgba(255,255,255,0.08);\nborder-top: 1px solid rgba(0,0,0,0.7);\n}\n.creative_form_FORM_ID p.scrollbar_light {\npadding: 5px 10px;\nborder-radius: 6px;\ncolor: #c2c2c2;\nbackground:rgba(119, 119, 119, 0.2);\n}\n|628~'
                                            );
            $query_insert = "INSERT IGNORE INTO `#__contact_templates` (`id`, `name`, `created`, `date_start`, `date_end`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `styles`) VALUES ";
            $k = 1;
            foreach($ccf_templates_array as $tmp_name => $tmp_row) {
                $query_last_symbol = $k == sizeof($ccf_templates_array) ? ';' : ',';
                if(!in_array($tmp_name,$tmp_names))
                    $query_insert .= "(NULL, '".$tmp_name."', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '".$tmp_row."')". $query_last_symbol;
                $k ++;
            }
                            
            $db->setQuery($query_insert);
            $db->query();

        }


        // INSTALL FORMS ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $query = 'SELECT COUNT(id) AS count_id FROM #__creative_forms';
        $db->setQuery($query);
        $count_forms = $db->loadResult();

        $countries_array = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua and Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia and Herzegowina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D","Croatia","Cuba","Cyprus","Czech Republic","Democratic Republic of Congo","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands (Malvinas)","Faroe Islands","Fiji","Finland","France","France, Metropolitan","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-bissau","Guyana","Haiti","Heard and Mc Donald Islands","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Korea","Kuwait","Kyrgyzstan","Lao People","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Kitts and Nevis","Saint Lucia","Saint Vincent and the Grenadines","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Seychelles","Sierra Leone","Singapore","Slovak Republic","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia &amp; South Sandwich Islands","Spain","Sri Lanka","St. Helena","St. Pierre and Miquelon","Sudan","Suriname","Svalbard and Jan Mayen Islands","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad and Tobago","Tunisia","Turkey","Turkmenistan","Turks and Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","United States Minor Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Vatican City State (Holy See)","Venezuela","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis and Futuna Islands","Western Sahara","Yemen","Yugoslavia","Zambia","Zimbabwe");

        if($count_forms == 0) {

            // insert form 1 ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_forms` (`id`, `email_to`, `email_bcc`, `email_subject`, `email_from`, `email_from_name`, `email_replyto`, `email_replyto_name`, `shake_count`, `shake_distanse`, `shake_duration`, `id_template`, `name`, `top_text`, `pre_text`, `thank_you_text`, `send_text`, `send_new_text`, `close_alert_text`, `form_width`, `alias`, `created`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `redirect`, `redirect_itemid`, `redirect_url`, `redirect_delay`, `send_copy_enable`, `send_copy_text`) VALUES
                                (NULL, '', '', '', '', '', '', '', 2, 10, 300, 1, 'Basic Contact Form', 'Contact Us', 'Feel free to contact us if you have any questions', 'Message successfully sent', 'Send', 'New email', 'OK', '100%', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, '', '0', 103, '', 0, '1', 'Send me a copy');
                            ";
            $db->setQuery($query_insert);
            $db->query();
            $form_id = $db->insertid();

            // insert fields
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_fields` (`id`, `id_user`, `id_form`, `name`, `tooltip_text`, `id_type`, `alias`, `created`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `required`, `width`, `field_margin_top`, `select_show_scroll_after`, `select_show_search_after`, `message_required`, `message_invalid`, `ordering_field`, `show_parent_label`, `select_default_text`, `select_no_match_text`, `upload_button_text`, `upload_minfilesize`, `upload_maxfilesize`, `upload_acceptfiletypes`, `upload_minfilesize_message`, `upload_maxfilesize_message`, `upload_acceptfiletypes_message`, `captcha_wrong_message`, `datepicker_date_format`, `datepicker_animation`, `datepicker_style`, `datepicker_icon_style`, `datepicker_show_icon`, `datepicker_input_readonly`, `datepicker_number_months`, `datepicker_mindate`, `datepicker_maxdate`, `datepicker_changemonths`, `datepicker_changeyears`, `column_type`, `custom_html`, `google_maps`, `heading`, `recaptcha_site_key`, `recaptcha_security_key`, `recaptcha_wrong_message`, `recaptcha_theme`, `recaptcha_type`, `contact_data`, `contact_data_width`, `creative_popup`, `creative_popup_embed`) VALUES
                                (NULL, 0, ".$form_id.", 'Name', 'Please enter your name!', 3, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Email', 'Please enter your email!', 4, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 2, '', '1', '', '', 10, 10, '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Country', '', 9, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 3, '', '1', '', '', 10, 10, '', '', '0', '1', 'Select country', 'No results match', '', '', '', '', '', '', '', '', '', '', 1, 1, 1, 1, 1, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'How did you find us?', '', 12, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 4, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', 1, 1, 1, 1, 1, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Message', 'Write your message!', 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 5, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 0, '', '', '', '', '', '', '', '', '', 120, '', '');

                            ";
            $db->setQuery($query_insert);
            $db->query();
            $field_id_first = $db->insertid();

            // insert options
            $field_id = $field_id_first + 2;
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_form_options` (`id`, `id_parent`, `name`, `value`, `ordering`, `showrow`, `selected`) VALUES 

                            ";
            foreach($countries_array as $k => $country_val) {
                 $query_insert .= "(NULL, ".$field_id.", '".$country_val."', '".$country_val."', ".$k.", '1', '0')";
                 if($k != sizeof($countries_array) - 1)
                    $query_insert .= ',';
            }
            $db->setQuery($query_insert);
            $db->query();

            // insert options
            $field_id = $field_id_first + 3;
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_form_options` (`id`, `id_parent`, `name`, `value`, `ordering`, `showrow`, `selected`) VALUES 
                                (NULL, ".$field_id.", 'Web search', 'Web search', 2, '1', '0'),
                                (NULL, ".$field_id.", 'Social networks', 'Social networks', 1, '1', '0'),
                                (NULL, ".$field_id.", 'Recommended by a friend', 'Recommended by a friend', 3, '1', '0');
                            ";
            $db->setQuery($query_insert);
            $db->query();
            // end insert form 1
        }

        // get forms names
        $query = "SELECT `name` FROM `#__creative_forms`";
        $db->setQuery($query);
        $contact_form_names_array = $db->LoadAssocList();

        $form_names = array();
        if(is_array($contact_form_names_array)) {
            foreach($contact_form_names_array as $k => $form_name) {
                $form_names[] = $form_name["name"];
            }
        }

        if(!in_array('Contact Form With Captcha', $form_names)) {
            // insert form : Contact Form With Captcha ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_forms` (`id`, `email_to`, `email_bcc`, `email_subject`, `email_from`, `email_from_name`, `email_replyto`, `email_replyto_name`, `shake_count`, `shake_distanse`, `shake_duration`, `id_template`, `name`, `top_text`, `pre_text`, `thank_you_text`, `send_text`, `send_new_text`, `close_alert_text`, `form_width`, `alias`, `created`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `redirect`, `redirect_itemid`, `redirect_url`, `redirect_delay`, `send_copy_enable`, `send_copy_text`) VALUES
                                (NULL, '', '', '', '', '', '', '', 2, 10, 300, 1, 'Contact Form With Captcha', 'Contact Us', 'Feel free to contact us if you have any questions', 'Message successfully sent', 'Send', 'New email', 'OK', '100%', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, '', '0', 103, '', 0, '1', 'Send me a copy');
                            ";
            $db->setQuery($query_insert);
            $db->query();
            $form_id = $db->insertid();
            
            // insert fields
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_fields` (`id`, `id_user`, `id_form`, `name`, `tooltip_text`, `id_type`, `alias`, `created`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `required`, `width`, `field_margin_top`, `select_show_scroll_after`, `select_show_search_after`, `message_required`, `message_invalid`, `ordering_field`, `show_parent_label`, `select_default_text`, `select_no_match_text`, `upload_button_text`, `upload_minfilesize`, `upload_maxfilesize`, `upload_acceptfiletypes`, `upload_minfilesize_message`, `upload_maxfilesize_message`, `upload_acceptfiletypes_message`, `captcha_wrong_message`, `datepicker_date_format`, `datepicker_animation`, `datepicker_style`, `datepicker_icon_style`, `datepicker_show_icon`, `datepicker_input_readonly`, `datepicker_number_months`, `datepicker_mindate`, `datepicker_maxdate`, `datepicker_changemonths`, `datepicker_changeyears`, `column_type`, `custom_html`, `google_maps`, `heading`, `recaptcha_site_key`, `recaptcha_security_key`, `recaptcha_wrong_message`, `recaptcha_theme`, `recaptcha_type`, `contact_data`, `contact_data_width`, `creative_popup`, `creative_popup_embed`) VALUES
                                (NULL, 0, ".$form_id.", 'Name', 'Please enter your name!', 3, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 1, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Email', 'Please enter your email!', 4, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 2, '', '1', '', '', 10, 10, '', '', '', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 1, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Website', 'Please enter your website!', 8, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 3, '', '0', '', '', 10, 10, '', '', '0', '1', 'Select country', 'No results match', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 1, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Where did you hear about us?', '', 12, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 5, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 2, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Message', 'Write your message!', 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 6, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 2, '', '', '', '', '', '', '', '', '', 120, '', ''),
                                (NULL, 0, ".$form_id.", 'Security Code', '', 13, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 4, '', '1', '', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', 'Security code is not correct', '', '', 0, 0, 1, 0, 1, '', '', 0, 0, 1, '', '', '', '', '', '', '', '', '', 120, '', '');
                            ";
            $db->setQuery($query_insert);
            $db->query();
            $field_id_first = $db->insertid();

            // insert options
            $field_id = $field_id_first + 3;
            $query_insert = 
                            "
                                INSERT IGNORE INTO `#__creative_form_options` (`id`, `id_parent`, `name`, `value`, `ordering`, `showrow`, `selected`) VALUES 
                                (NULL, ".$field_id.", 'A Friend or colleauge', 'A Friend or colleauge', 0, '1', '0'),
                                (NULL, ".$field_id.", 'Web search', 'Web search', 1, '1', '0'),
                                (NULL, ".$field_id.", 'Social networks', 'Social networks', 2, '1', '0');
                            ";
            $db->setQuery($query_insert);
            $db->query();

            // END insert contact form with captcha///


        }
        // END INSTALL PRO FORMS ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        
         // 3.x to 3.5.0 update ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        
        $query_create = 
                            "
                                CREATE TABLE IF NOT EXISTS `#__creative_submissions` (
                                  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                                  `id_form` int(10) UNSIGNED NOT NULL,
                                  `date` datetime NOT NULL,
                                  `email` text NOT NULL,
                                  `message` text NOT NULL,
                                  `ip` text NOT NULL,
                                  `browser` text NOT NULL,
                                  `op_s` text NOT NULL,
                                  `sc_res` text NOT NULL,
                                  `name` text NOT NULL,
                                  `viewed` enum('0','1') NOT NULL DEFAULT '0',
                                  `country` text NOT NULL,
                                  `city` text NOT NULL,
                                  `page_title` text NOT NULL,
                                  `page_url` text NOT NULL,
                                  `star_index` tinyint(3) UNSIGNED NOT NULL,
                                  `imp_index` tinyint(3) UNSIGNED NOT NULL,
                                  `uploads` text NOT NULL,
                                    PRIMARY KEY (`id`)
                                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
                            ";
        $db->setQuery($query_create);
        $db->query();

                // 3.5 to 4.0 update ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        $query = "SELECT * FROM `#__creative_forms` LIMIT 1";
        $db->setQuery($query);
        $columns_data = $db->LoadAssoc();

        if(is_array($columns_data)) {
            $columns_titles = array_keys($columns_data);
            if(!in_array('render_type',$columns_titles)) {

                $query_update = 
                                    "
                                         ALTER TABLE 
                                            `#__creative_forms` 
                                        ADD 
                                            `render_type` TINYINT UNSIGNED NOT NULL,
                                        ADD 
                                            `popup_button_text` TEXT NOT NULL,
                                        ADD 
                                            `static_button_position` TINYINT UNSIGNED NOT NULL, 
                                        ADD 
                                            `static_button_offset` TEXT NOT NULL, 
                                        ADD 
                                            `appear_animation_type` TINYINT UNSIGNED NOT NULL DEFAULT '1', 
                                        ADD 
                                            `check_token` TINYINT UNSIGNED NOT NULL,
                                        ADD 
                                            `next_button_text` TEXT NOT NULL, 
                                        ADD 
                                            `prev_button_text` TEXT NOT NULL
                                    ";
                $db->setQuery($query_update);
                $db->query();

            }
        }
        // END 3.5 to 4.0 update ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    }
}