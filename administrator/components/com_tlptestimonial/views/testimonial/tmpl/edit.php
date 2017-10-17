<?php
/**
 * @version     1.0.0
 * @package     com_tlptestimonial
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Techlabpro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_tlptestimonial/assets/css/tlptestimonial.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'testimonial.cancel') {
            Joomla.submitform(task, document.getElementById('testimonial-form'));
        }
        else {
            
				js = jQuery.noConflict();
				if(js('#jform_photo').val() != ''){
					js('#jform_photo_hidden').val(js('#jform_photo').val());
				}
            if (task != 'testimonial.cancel' && document.formvalidator.isValid(document.id('testimonial-form'))) {
                
                Joomla.submitform(task, document.getElementById('testimonial-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_tlptestimonial&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="testimonial-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_TLPTESTIMONIAL_TITLE_TESTIMONIAL', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('category'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('category'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('profile_image'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('profile_image'); ?></div>
			</div>

				<input type="hidden" name="jform[profile_image]" id="jform_profile_image_hidden" value="<?php echo $this->item->profile_image ?>" />													        	
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('designation'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('designation'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('company'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('company'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('location'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('location'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('testimonial'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('testimonial'); ?></div>
			</div>
            <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('state'); ?></div>
			</div>
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />

				<?php } 
				else{ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />

				<?php } ?>

                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>