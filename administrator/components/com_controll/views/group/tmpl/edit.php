<?php
/**
 * @version     1.0.0
 * @package     com_controll
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
$document->addStyleSheet('components/com_controll/assets/css/controll.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {

    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'group.cancel') {
            Joomla.submitform(task, document.getElementById('group-form'));
        }
        else {

				js = jQuery.noConflict();
				if(js('#jform_photo').val() != ''){
					js('#jform_photo_hidden').val(js('#jform_photo').val());
				}
            if (task != 'group.cancel' && document.formvalidator.isValid(document.id('group-form'))) {

                Joomla.submitform(task, document.getElementById('group-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_controll&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="group-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CONTROLL_TITLE_CONTROLL', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

      <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

      <div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('group'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('group'); ?></div>
			</div>
      <div class="control-group">
        <div class="control-label"><?php echo $this->form->getLabel('subject'); ?></div>
        <div class="controls"><?php echo $this->form->getInput('subject'); ?></div>
      </div>
      <div class="control-group">
        <div class="control-label"><?php echo $this->form->getLabel('teacher'); ?></div>
        <div class="controls"><?php echo $this->form->getInput('teacher'); ?></div>
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
