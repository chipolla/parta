<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.protostar
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

if ($task === 'edit' || $layout === 'form')
{
	$fullWidth = 1;
}
else
{
	$fullWidth = 0;
}

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add template js
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add html5 shiv
JHtml::_('script', 'jui/html5.js', array('version' => 'auto', 'relative' => true, 'conditional' => 'lt IE 9'));

// Add Stylesheets
JHtml::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));

// Use of Google Font
if ($this->params->get('googleFont'))
{
	JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $this->params->get('googleFontName'));
	$this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . str_replace('+', ' ', $this->params->get('googleFontName')) . "', sans-serif;
	}");
}

// Template color
if ($this->params->get('templateColor'))
{
	$this->addStyleDeclaration('
	body.site {
		border-top: 3px solid ' . $this->params->get('templateColor') . ';
		background-color: ' . $this->params->get('templateBackgroundColor') . ';
	}
	a {
		color: ' . $this->params->get('templateColor') . ';
	}
	.nav-list > .active > a,
	.nav-list > .active > a:hover,
	.dropdown-menu li > a:hover,
	.dropdown-menu .active > a,
	.dropdown-menu .active > a:hover,
	.nav-pills > .active > a,
	.nav-pills > .active > a:hover,
	.btn-primary {
		background: ' . $this->params->get('templateColor') . ';
	}');
}

// Check for a custom CSS file
JHtml::_('stylesheet', 'user.css', array('version' => 'auto', 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'user.js', array('version' => 'auto', 'relative' => true));

// Load optional RTL Bootstrap CSS
JHtml::_('bootstrap.loadCss', false, $this->direction);

// Adjusting content width
if ($this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = 'col-lg-6 col-md-4 col-sm-12';
}
elseif ($this->countModules('position-7') && !$this->countModules('position-8'))
{
	$span = 'col-lg-8 col-md-8 col-sm-12';
}
elseif (!$this->countModules('position-7') && $this->countModules('position-8'))
{
	$span = 'col-lg-8 col-md-8 col-sm-12';
}
else
{
	$span = 'col-sm-12';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
	$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
  <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-51253604-2"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments)};
      gtag('js', new Date());

      gtag('config', 'UA-51253604-2');
    </script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  	<meta name="yandex-verification" content="11ae594d84367b9c" />
	<jdoc:include type="head" />
    <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
 	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  	<script src="https://use.fontawesome.com/fe057fef35.js"></script>
    <script type="application/ld+json">
    {
      "@context" : "http://schema.org",
      "@type" : "LocalBusiness",
      "name" : "PARTA",
      "description": "Центр довузовской подготовки",
      "telephone" : "+375 (44) 548-79-29",
      "email" : "mail@parta.of.by",
      "address" : {
        "@type" : "PostalAddress",
        "streetAddress" : "Ул. Е. Полоцкой 3"
      },
      "review" : {
        "@type" : "Review",
        "author" : {
          "@type" : "Person",
          "name" : "Мішаня"
        },
        "reviewBody" : "Спадабаўся настаўнік па гісторыі, Менск</H4>\n                                <P class=\"test-content\" style=\"font-size:16px; color:#ffffff;\">\n                               Заняткі былі на самой спарве цікавыя! Дзякуй!"
      }
    }
</script>
</head>
<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
	echo ($this->direction === 'rtl' ? ' rtl' : '');
?>">
  	<?php include_once("analyticstracking.php") ?>
	<!-- Body -->
	<div class="body" id="top" itemscope itemtype="http://schema.org/LocalBusiness">
			<?php if ($this->countModules('position-1')) : ?>
				<nav class="navigation" role="navigation">
                  <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
					<div class="navbar pull-left">
						<a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
							<span class="element-invisible"><?php echo JTEXT::_('TPL_PROTOSTAR_TOGGLE_MENU'); ?></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</a>
					</div>
					<div class="nav-collapse">
						<jdoc:include type="modules" name="position-1" style="none" />
					</div>
                  </div>
				</nav>
			<?php endif; ?>
			<!-- Header -->
			<header class="header" role="banner">
              
				<div class="header-inner clearfix">
					<a class="brand" href="<?php echo $this->baseurl; ?>/">
						<?php echo $logo; ?>
						<?php if ($this->params->get('sitedescription')) : ?>
							<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription'), ENT_COMPAT, 'UTF-8') . '</div>'; ?>
						<?php endif; ?>
					</a>
					<div class="header-search pull-right">
						<jdoc:include type="modules" name="position-0" style="none" />
					</div>
				</div>
              
			</header>
			
			<jdoc:include type="modules" name="banner" style="xhtml" />
      
      		<?php if ($this->countModules('position-001')) : ?>
                <div class="clearfix" style="background-color: rgb(245, 245, 245);">
                	<jdoc:include type="modules" name="position-001" style="none" />
                </div>
            <?php endif; ?>
            <?php if ($this->countModules('position-002')) : ?>
                <div class="clearfix">
                  <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
                		<jdoc:include type="modules" name="position-002" style="none" />
                  </div>
                </div>
            <?php endif; ?>
            <?php if ($this->countModules('position-003')) : ?>
                <div class="clearfix">
                	<jdoc:include type="modules" name="position-003" style="none" />
                 </div>
            <?php endif; ?>
			<div class="row-fluid">
              <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
				<?php if ($this->countModules('position-8')) : ?>
					<!-- Begin Sidebar -->
					<div id="sidebar" class="col-lg-3 col-md-4 col-sm-12">
						<div class="sidebar-nav">
							<jdoc:include type="modules" name="position-8" style="xhtml" />
						</div>
					</div>
					<!-- End Sidebar -->
				<?php endif; ?>
                
                
                
				<main id="content" role="main" class="<?php echo $span; ?>">
					<!-- Begin Content -->
                  	<jdoc:include type="modules" name="position-01" style="none" />
                  
                  	<jdoc:include type="modules" name="position-02" style="none" />
                  
                  	<jdoc:include type="modules" name="position-03" style="none" />
                  
                  	<jdoc:include type="modules" name="position-04" style="none" />
                  
                  	<jdoc:include type="modules" name="position-05" style="none" />
                  
                  
					<jdoc:include type="modules" name="position-3" style="xhtml" />
					<jdoc:include type="message" />               
					<jdoc:include type="component"  style="xhtml"/>
                  
                  
                 
					<jdoc:include type="modules" name="position-2" style="none" />
                  	<jdoc:include type="modules" name="position-11" style="none" />
                  
                  	<jdoc:include type="modules" name="position-12" style="none" />
                  
                  	<jdoc:include type="modules" name="position-13" style="none" />
                  
                  	<jdoc:include type="modules" name="position-14" style="none" />
                  
                  	<jdoc:include type="modules" name="position-15" style="none" />
					<!-- End Content -->
				</main>
				<?php if ($this->countModules('position-7')) : ?>
					<div id="aside" class="span3">
						<!-- Begin Right Sidebar -->
						<jdoc:include type="modules" name="position-7" style="well" />
						<!-- End Right Sidebar -->
					</div>
				<?php endif; ?>
			  </div>
            </div>
		</div>
   <?php if ($this->countModules('position-21')) : ?>
  <section class="row-fluid bg-imgs relative" style="background: rgba(173, 117, 15, 0.87);" >
	<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
      <h2 class="page-header text-center" style="color:white;padding-top:70px;margin-bottom:0">
        Наши преподаватели
      </h2>
      <jdoc:include type="modules" name="position-21" style="none" />
    </div>
  </section>
  <?php endif; ?>
  <div class="row-fluid">

      <jdoc:include type="modules" name="position-22" style="none" />

  </div>
  <div class="row-fluid">
	<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
      <jdoc:include type="modules" name="position-23" style="none" />
    </div>
  </div>
   <?php if ($this->countModules('contact-main')) : ?>
  <!--contact-->
    <section class="row-fluid contact-section">
      <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">

		<div class="row-flex">
          <div class="span-flex8 col-lg-8 col-md-8 col-sm-12">
            <!-- Begin Content -->
            <jdoc:include type="modules" name="contact-main" style="none" />
            <!-- End Content -->
          </div>

          <!-- Begin Sidebar -->
          <div class="span-flex4 col-lg-4 col-md-4 col-sm-12">
              <jdoc:include type="modules" name="contact-side" style="xhtml" />
          </div>
        </div>
        <!-- End Sidebar -->
      </div>
	</section>
  <?php endif; ?>
  <!--contact end-->
  
  
	<!-- Footer -->
  	
	<footer class="footer bg-imgs" role="contentinfo">
      	<jdoc:include type="modules" name="position-footer" style="well" />
		
      	<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">    
          <div class="col-lg-9 col-md-8 col-sm-12">
      		<jdoc:include type="modules" name="position-bottom" style="none" />
          </div>
          <div class="col-lg-3 col-md-4 col-sm-12">
            <jdoc:include type="modules" name="position-bottom-right" style="none" />
          </div>
      	</div>
      	<div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
			<jdoc:include type="modules" name="footer" style="none" />
			<p class="pull-right">
				<a href="#top" id="back-top">
					<?php echo JText::_('TPL_PROTOSTAR_BACKTOTOP'); ?>
				</a>
			</p>
			<p>
				&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
			</p>
		</div>
	</footer>
	<jdoc:include type="modules" name="debug" style="none" />

</body>
</html>
