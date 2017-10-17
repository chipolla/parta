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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_controll', JPATH_ADMINISTRATOR);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/components/com_controll/assets/js/form.js');


?>
</style>
<script type="text/javascript">
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function() {
        jQuery(document).ready(function() {
            jQuery('#form-controll').submit(function(event) {

		if(jQuery('#jform_photo').val() != ''){
			jQuery('#jform_photo_hidden').val(jQuery('#jform_photo').val());
		}
            });


        });
    });

</script>

<div class="controll-edit front-end-edit">
    <?php if (!empty($this->item->id)): ?>
        <h3><?php echo JText::_('COM_CONTROLL_EDIT_ITEM'); ?> <?php echo $this->item->id; ?></h3>
    <?php else: ?>
        <h3><?php echo JText::_('COM_CONTROLL_ADD_ITEM'); ?></h3>
    <?php endif; ?>

    <form id="form-controll" action="<?php echo JRoute::_('index.php?option=com_controll&task=controll.save'); ?>" method="post" class="form-validate form-horizontal" enctype="multipart/form-data">

	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

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
		<div class="control-label"><?php echo $this->form->getLabel('controll'); ?></div>
		<div class="controls"><?php echo $this->form->getInput('controll'); ?></div>
	</div>
	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

	<?php if(empty($this->item->created_by)): ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
	<?php else: ?>
		<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
	<?php endif; ?>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="validate btn btn-primary"><?php echo JText::_('JSUBMIT'); ?></button>
                <a class="btn" href="<?php echo JRoute::_('index.php?option=com_controll&task=controllform.cancel'); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
            </div>
        </div>

        <input type="hidden" name="option" value="com_controll" />
        <input type="hidden" name="task" value="controllform.save" />
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>
