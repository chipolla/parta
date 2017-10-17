<?php 
/**
 * @version     1.0.0
 * @package     mod_tlptestimonial
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      TechLabPro <techlabpro@gmail.com> - http://www.techlabpro.com
 */
// no direct access
defined('_JEXEC') or die; 
JHtml::_('bootstrap.framework');
$setting = TlptestimonialFrontendHelper::config();
$image_storiage_path = $setting->imagepath.'/';
?>
<?php $backgroundimage;?>
<div id="mod-tlp-testimonial-main" <?php if($backgroundimage!=''){?> style=" background: url(<?php echo $backgroundimage;?>) no-repeat center center;" <?php }?>>
    <div id="mod-tlp-testimonial" class="owl-carousel owl-theme">
			 <?php $i=0;
                    foreach ($rows as $row){ $i++;
                    ?>
                          <div class="item">
							<p class="img-ara">
                             <?php
								if (!empty($row->profile_image)){ 
									if($readmore==1){
								?>
                                <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $row->id.'&Itemid='.$testimonialmenuid); ?>">
                                <img src="<?php echo JURI::root().$image_storiage_path.'m_'.$row->profile_image;?>" class="author-img " style="border:<?php echo $imgborder;?>px solid <?php echo $imgbordercolor;?> ; text-align:center;" alt="<?php echo $row->name;?>"/>
                                </a>
                                <?php }else{?>
									<img src="<?php echo JURI::root().$image_storiage_path.'m_'.$row->profile_image;?>" class="author-img " style="border:<?php echo $imgborder;?>px solid <?php echo $imgbordercolor;?> ; text-align:center;" alt="<?php echo $row->name;?>"/>
                                    
									<?php }
								}else{ ?>
									<img class="hwllow" src="<?php echo JURI::root().$image_storiage_path?>noimage.jpg" alt="noimage" />
							<?php }?>
                            </p>
                                <h3 style="font-size:<?php echo $namefontsize;?>px; color:<?php echo $namecolor;?>;"><?php echo $row->name; ?></h3>
                                <h4 style="font-size:<?php echo $designfontsize;?>px; color:<?php echo $designcolor;?>"><?php echo $row->designation;?><?php if($row->company!==''){ echo ', '.$row->company;}?><?php if($row->location!=''){echo ', '.$row->location;}?></h5>
                                <p class="test-content" style="font-size:<?php echo $mainfontsize;?>px; color:<?php echo $maincolor;?>;">
                               <?php if($readmore==1){?>								
									<?php echo substr($row->testimonial,0,$character_limit).' ...';?>
                                <?php }else{ echo $row->testimonial;}?>
                                </p> 
								<?php if($readmore==1){?>
                                <div class="read-more">
                                 <a href="<?php echo JRoute::_('index.php?option=com_tlptestimonial&view=testimonial&id='.(int) $row->id.'&Itemid='.$testimonialmenuid); ?>"> <?php echo $readmore_text; ?></a>
                                 </div>
                                <?php }?>
                          </div>
     		<?php } ?>
      </div>
    </div>
    <div class="cb"></div>
    
 <script>
//var jq = jQuery.noConflict();           
jQuery(document).ready(function() { 
  jQuery("#mod-tlp-testimonial").owlCarousel({
    items : <?php echo $showno;?>,
    itemsCustom : false,
    itemsDesktop : [1199,<?php echo $showno;?>],
    itemsDesktopSmall : [980,<?php echo $showno;?>],
    itemsTablet: [768,<?php echo $showno;?>],
    itemsTabletSmall: false,
    itemsMobile : [479,1],
    singleItem : false,
    itemsScaleUp : false,
 
    //Basic Speeds
    slideSpeed : <?php echo $speed;?>,
    paginationSpeed : 800,
    rewindSpeed : 800,
 
    //Autoplay
    autoPlay : <?php echo $autoplay;?>,
    stopOnHover : false,
 
    // Navigation
    navigation : <?php echo $navigation;?>,
    navigationText : ["prev","next"],
    rewindNav : true,
    scrollPerPage : false,
 
    //Pagination
    pagination : <?php echo $pagination;?>,
    paginationNumbers: false,
 
    // Responsive 
    responsive: <?php echo $responsive;?>,
    responsiveRefreshRate : 200,
    responsiveBaseWidth: window,
 
    // CSS Styles
    baseClass : "owl-carousel",
    theme : "owl-theme",
 
    //Lazy load
    lazyLoad : <?php echo $lazyload;?>,
    lazyFollow : true,
    lazyEffect : "fade",
 
    //Auto height
    autoHeight : true
  });
  
});
/*$(function() {
    $('.item').matchHeight();
});*/
  
 </script>