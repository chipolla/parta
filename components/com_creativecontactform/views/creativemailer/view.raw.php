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

// Import Joomla! libraries
jimport( 'joomla.application.component.view');


class CreativeContactFormViewCreativemailer extends JViewLegacy {
	function display($tpl = null) {
        // parent::display($tpl);
	}
}

require_once JPATH_COMPONENT . '/helpers/mailer.php';

exit;

// $ccf_mailer = new CreativecontactformMailer;
// $ccf_mailer->set_vars();

// $ccf_class->type = 'component';
// $ccf_class->class_suffix = '';
// $ccf_class->module_id = 0;
// echo $ccf_class->render_html();
?>