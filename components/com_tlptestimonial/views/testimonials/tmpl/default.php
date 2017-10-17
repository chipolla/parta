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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canCreate = $user->authorise('core.create', 'com_tlptestimonial');
$canEdit = $user->authorise('core.edit', 'com_tlptestimonial');
$canCheckin = $user->authorise('core.manage', 'com_tlptestimonial');
$canChange = $user->authorise('core.edit.state', 'com_tlptestimonial');
$canDelete = $user->authorise('core.delete', 'com_tlptestimonial');

$setting = TlptestimonialFrontendHelper::config();
$image_storiage_path = $setting->imagepath.'/';
$display_no=$setting->display_no;
$image_grid=$setting->detailpage_image_grid;
$content_grid=12-$image_grid;
$readmore=$setting->enable_read_more;
$character_limit=$setting->character_limit;
?>

<form action="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonials'); ?>" method="post" name="adminForm" id="adminForm">
    <?php echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); ?>
	   <?php if (isset($this->items[0]->state)): ?>
            <?php echo JHtml::_('grid.sort', '', 'a.state', $listDirn, $listOrder); ?>
        <?php endif; ?>
<section class="inner testimonial pb30 signle-list">
<?php
if($display_no==1){
 $i=2; foreach ($this->items as $i => $item) : ?>
          <?php 
			if($i%2==0){?>
           <div class="row-fluid">
            <div class="span12 pb30">
                <div class="span<?php echo $image_grid;?>">
                 <?php   if (!empty($item->profile_image)){ 
                    if($readmore==1){
                ?>
                  <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $item->id) ?>">
                      <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$item->profile_image;?>" class="author-img-3" alt="<?php echo $item->name;?>"/>
                      </a>
                      <?php }else{?>
                  <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$item->profile_image;?>" class="author-img-3" alt="<?php echo $item->name;?>"/>
                <?php  }                  
                }else{ ?>
                    <img src="<?php echo JURI::root().$image_storiage_path?>noimage.jpg" alt="noimage" />
                <?php }?>
                   <h3><?php if($readmore==1){?> 
                  <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $item->id) ?>"><?php echo $this->escape($item->name); ?></a> <?php }else{ echo $this->escape($item->name);}?></h3>
                    <h4><?php echo $item->designation; ?>, <?php echo $item->company; ?> <?php echo $item->location; ?></h4>
                </div>
				<div class="span<?php echo $content_grid;?>">
                <blockquote class="left-arrow">
                   <?php if($readmore==1){?>
                   <?php echo substr($item->testimonial,0,$character_limit).' ...'; 
					}else{?>
						 <?php echo $item->testimonial; ?>
					<?php }?>
                </blockquote>
                </div>
             </div>
            </div>
                <?php }else{?>
           <div class="row-fluid">
            <div class="span12 pb30"> 
				<div class="span<?php echo $content_grid;?>">
                <blockquote class="right-arrow">
                   <?php if($readmore==1){?>
                   <?php echo substr($item->testimonial,0,$character_limit).' ...'; 
				}else{?>
                	 <?php echo $item->testimonial; ?>
                <?php }?>
                </blockquote>
                </div>
                 <div class="span<?php echo $image_grid;?>">
                  <?php   if (!empty($item->profile_image)){ 
                    if($readmore==1){
                ?>
                  <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $item->id) ?>">
                      <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$item->profile_image;?>" class="author-img-3" alt="<?php echo $item->name;?>"/>
                      </a>
                      <?php }else{?>
                  <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$item->profile_image;?>" class="author-img-3" alt="<?php echo $item->name;?>"/>
                <?php  }                  
                }else{ ?>
                    <img src="<?php echo JURI::root().$image_storiage_path?>noimage.jpg" alt="noimage" />
                <?php }?>
                     <h3><?php if($readmore==1){?> 
                  <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $item->id) ?>"><?php echo $this->escape($item->name); ?></a> <?php }else{ echo $this->escape($item->name);}?></h3>
                    <h4><?php echo $item->designation; ?>, <?php echo $item->company; ?> <?php echo $item->location; ?></h4>
                </div>
               </div>
             </div>                 
                <?php }?>
		 <?php $i++; endforeach; 
        }else{?>
            <?php  $i=0; foreach ($this->items as $i => $item) : $i++;
            if($i%$display_no == 1){echo '<div class="row-fluid">'; }  ?>
				<div class="span6">
                <blockquote>
				<?php if($readmore==1){?>
                   <?php echo substr($item->testimonial,0,$character_limit).' ...'; 
				}else{?>
                	 <?php echo $item->testimonial; ?>
                <?php }?>
                </blockquote>
                <div class="wrapper">
                    <p class="test-content-2"></p>
                 <?php if (!empty($item->profile_image)){ 
                    if($readmore==1){
                ?>
                  <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $item->id) ?>">
                      <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$item->profile_image;?>" class="author-img-3" alt="<?php echo $item->name;?>"/>
                      </a>
                      <?php }else{?>
                  <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$item->profile_image;?>" class="author-img-3" alt="<?php echo $item->name;?>"/>
                <?php  }                  
                }else{ ?>
                    <img src="<?php echo JURI::root().$image_storiage_path?>noimage.jpg" alt="noimage" />
                <?php }?>
                     <h3><?php if($readmore==1){?> 
                  <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $item->id) ?>"><?php echo $this->escape($item->name); ?></a> <?php }else{ echo $this->escape($item->name);}?></h3>
                    <h4><?php echo $item->designation; ?>, <?php echo $item->company; ?> <?php echo $item->location; ?></h4>
                </div>
                <div class="cb"></div>
            </div>
			 <?php if($i%$display_no == 0){ echo '</div>';} ?>
 <?php endforeach;
   }?>
</section>
     <?php echo $this->pagination->getListFooter(); ?>
 
    <?php if ($canCreate): ?>
        <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&task=testimonialform.edit&id=0', false, 2); ?>"
           class="btn btn-success btn-small"><i
                class="icon-plus"></i> <?php echo JText::_('COM_TLPTESTIMONIAL_ADD_ITEM'); ?></a>
    <?php endif; ?>

    <input type="hidden" name="task" value=""/>
    <input type="hidden" name="boxchecked" value="0"/>
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
    <?php echo JHtml::_('form.token'); ?>
</form>

<script type="text/javascript">

    jQuery(document).ready(function () {
        jQuery('.delete-button').click(deleteItem);
    });

    function deleteItem() {
        var item_id = jQuery(this).attr('data-item-id');
        if (confirm("<?php echo JText::_('COM_TLPTESTIMONIAL_DELETE_MESSAGE'); ?>")) {
            window.location.href = '<?php echo JRoute::_('index.php?option=com_tlptestimonial&task=testimonialform.remove&id=', false, 2) ?>' + item_id;
        }
    }
</script>
