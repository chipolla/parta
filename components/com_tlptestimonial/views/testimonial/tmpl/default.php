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

$setting = TlptestimonialFrontendHelper::config();
$image_storiage_path = $setting->imagepath.'/';
$display_no=$setting->display_no;
$image_grid=$setting->detailpage_image_grid;
$content_grid=12-$image_grid;
?>
<?php if ($this->item) : ?>

<section class="inner testimonial pb30 signle-list">
<div class="row-fluid">
            <div class="span12 pb30">
                <div class="image-area">
                 <?php   if (!empty($this->item->profile_image)){ ?>
                    <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$this->item->profile_image;?>"  class="author-img-3" alt="<?php echo $this->item->name; ?>" />
                    <?php
                }else{ ?>
                    <img src="<?php echo JURI::root().$image_storiage_path?>noimage.jpg" alt="noimage" />
                <?php }?>
                    <h3><?php echo $this->item->name; ?></h3>
                    <h4><?php echo $this->item->designation; ?>, <?php echo $this->item->company; ?> <?php echo $this->item->location; ?></h4>
                </div>
				<div >
                <blockquote class="top-arrow">
                   <?php echo $this->item->testimonial; ?>
                </blockquote>
                </div>
             </div>
            </div>
   </section>         
    
    
    <?php
else:
    echo JText::_('COM_TLPTESTIMONIAL_ITEM_NOT_LOADED');
endif;
?>
