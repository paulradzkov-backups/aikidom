<?php
/**
 * @package		Joomla.Site
 * @subpackage	Template
 * @copyright	Copyright (C) 2012
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// check modules
$showPrimaryColumn		= ($this->countModules('left'));
$showSecondaryColumn	= ($this->countModules('right'));
$showbottom			    = ($this->countModules('bottom'));

if ($showSecondaryColumn==0 and $showPrimaryColumn==0) {
	$showno = 0;
}

JHtml::_('behavior.framework', true);

// get params
$color			= $this->params->get('templatecolor');
$logo			= $this->params->get('logo');
$app			= JFactory::getApplication();
$doc			= JFactory::getDocument();
$templateparams	= $app->getTemplate(true)->params;
$gacode         = $this->params->get('gacode');
$yacode         = $this->params->get('yacode');
$jsframework    = $this->params->get('jsframework');
$jqversion      = $this->params->get('jqversion');
$pluginsjs      = $this->params->get('pluginsjs');
$jqbottom       = $this->params->get('jqbottom');

$baseurl = $this->baseurl;
$templatepath = $this->baseurl . '/templates/' . $this->template . '/'; 

$layout="";
if($showPrimaryColumn)      {$layout .= 'l';}
if($showSecondaryColumn)    {$layout .= 'r';} 	// set layout class
if ( JURI::current() == JURI::base() or (JRequest::getVar('view') == 'featured')) 
{
	$main  = 'mp';
} else {
	$main  = 'not_mp';
}
//$main  = (!(JRequest::getVar('view') == 'frontpage')) ? 'not_mp' : 'mp'; //frontpage class

$option     = "";
$view       = "";
$task       = "";
$option     = JRequest::getVar('option');
$view       = JRequest::getVar('view');
$task       = JRequest::getVar('task');

$pageclass = "";
$pageclass .= $option;
if($view){$pageclass .= ' '. $view;}
if($task){$pageclass .= ' '. $task;}

// load Mootools (in head) or JQuery (in head or at the end)
// removes Mootools only if not logged in
// always loaded: /media/system/js/core.js
$user = JFactory::getUser();
if ($user->get('guest') == 1) {
    $head = $this->getHeadData();
	switch ($jsframework) {
		case 'moocm':
			//do nothing, load default Mootools Core+More + caption.js
			break;
		case 'mooc':
		case 'moocjq':
			reset($head['scripts']);
			unset($head['scripts'][$this->baseurl.'/media/system/js/mootools-more.js']);
			$head['script']['text/javascript'] = ''; // removes JTooltips depending on Tips in More
			$this->setHeadData($head);
			break;
		case 'none':
		case 'jq':
			JHtml::_('behavior.keepalive', false);
			reset($head['scripts']);
			unset($head['scripts'][$this->baseurl.'/media/system/js/mootools-core.js']);
			unset($head['scripts'][$this->baseurl.'/media/system/js/mootools-more.js']);
			unset($head['scripts'][$this->baseurl.'/media/system/js/caption.js']);
			$head['script']['text/javascript'] = ''; // removes JTooltips depending on Tips in More
			$this->setHeadData($head);
			break;
	}
}

if (!$jqbottom && ($jsframework == 'jq' || $jsframework == 'moocjq' || $jsframework == 'moocmjq')) {
	$doc = JFactory::getDocument();
	$doc->addScript('//ajax.googleapis.com/ajax/libs/jquery/'.$jqversion.'/jquery.min.js', 'text/javascript', false);
	$doc->addScriptDeclaration('window.jQuery || document.write(\'<script src="'.$this->baseurl.'/templates/'.$tpn.'/js/jquery-1.7.1.min.js"><\/script>\');');
	$doc->addScriptDeclaration('window.jQuery && jQuery.noConflict();');
	if ($pluginsjs)
		$doc->addScript($this->baseurl.'/templates/'.$tpn.'/js/plugins.js', 'text/javascript', false);
}

?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"> <!--<![endif]-->

<head>
    <jdoc:include type="head" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/boilerplate.css" type="text/css" media="all" />
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" media="all" />
<?php
$files = JHtml::_('stylesheet', 'templates/'.$this->template.'/css/general.css', null, false, true);
if ($files):
    if (!is_array($files)):
        $files = array($files);
    endif;
    foreach($files as $file):
?>
    <link rel="stylesheet" href="<?php echo $file;?>" type="text/css" />
<?php
    endforeach;
endif;
?>
    <?php if ($this->direction == 'rtl') : ?>
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_rtl.css" type="text/css" />
    <?php endif; ?>

    <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/js/libs/modernizr-2.5.3.min.js"></script>
</head>

<body class="<?php echo ($pageclass.' '.$layout.' '.$main); ?> no-sticky-footer">

<div id="allpage">
	<div class="tpl-paper">
        <header class="tpl-header">
            <div class="tpl-logoheader">
                <h1 class="tpl-logo">
                	<a href="<?php echo $this->baseurl ?>"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/aikidom_logo.png" alt="<?php echo htmlspecialchars($templateparams->get('sitetitle'));?>" /></a>
                </h1>
            </div><!-- end logoheader -->
            <nav class="tpl-mainmenu" id="nav">
                <jdoc:include type="modules" name="mainmenu" style="custom" />
            </nav><!-- end navi -->
            <h2 class="tpl-slogan">
                <?php if ($templateparams->get('sitedescription')) {
            	    echo htmlspecialchars($templateparams->get('sitedescription'));
            	} else { ?>AIKIDOM — Минский клуб Айкидо Айкикай
            	<?php } ?>
            </h2>
            <div class="tpl-headercontacts">
            	<jdoc:include type="modules" name="headercontacts" style="custom" />
            </div>
    
        </header><!-- end header -->
		<?php if ($main == 'not_mp') : {?>
		<div class="tpl-teaser">
			<?php if ($this->countModules('header')) { ?>
				<jdoc:include type="modules" name="header" style="custom" />
			<?php } else { ?>
				<img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/aikido-mix.jpg" alt=""/>
			<?php } ?>				
		</div>
		<?php } endif; ?>
		
        <nav class="tpl-mobileonly">
            <ul class="tpl-skiplinks">
                <li><a href="#main"><?php echo JText::_('TPL_BLANK_SKIP_TO_CONTENT'); ?></a></li>
                <li><a href="#nav"><?php echo JText::_('TPL_BLANK_JUMP_TO_NAV'); ?></a></li>
                <?php if($showSecondaryColumn ):?>
                <li><a href="#additional"><?php echo JText::_('TPL_BLANK_JUMP_TO_INFO'); ?></a></li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <?php if ($main == 'not_mp') : {?>
			<div class="tpl-breadcrumbs">
				<jdoc:include type="modules" name="breadcrumbs" style="custom" />
				<jdoc:include type="modules" name="search" style="custom" />
			</div>
		<?php } endif; ?>
    
        <div class="tpl-wrapper">
            <div id="main" role="main" class="tpl-content">
				<?php if ($main == 'mp') : {?>
					<div class="tpl-title">
						<?php if ($this->countModules('title')) { ?>
							<jdoc:include type="modules" name="title" style="custom" />
						<?php } else { ?>
							<img class="tpl-title-image" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/title-image.jpg" alt="Aйкидо - это не боевое искусство для борьбы с врагом, это не техника для уничтожения противника. Это путь, по которому мир придет к гармонии и человечество станет единым большим домом."/>
							<div class="tpl-title-caption">
								<p>&laquo;Aйкидо &mdash; это не боевое искусство для борьбы с врагом, это не техника для уничтожения противника. Это путь, по которому мир придет к гармонии и человечество станет единым большим домом.&raquo;</p>
							</div>
						<?php } ?>				
					</div>
				<?php } endif; ?>
                <jdoc:include type="message" />
                <jdoc:include type="component" />
            
            </div><!-- end main -->
        </div>
    
        <?php if ($showPrimaryColumn) : ?>
            <div class="tpl-primary-col">
                <jdoc:include type="modules" name="left" style="custom" />
            </div>	
        <?php endif; ?>
    
		<?php if ($showSecondaryColumn) : ?>
            <aside class="tpl-secondary-col" id="additional">
<!--			
<div class="read-book">
	<div class="brick">
		<a href="#"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/images/book.png" alt="Прочесть «ИСКУССТВО МИРА» Уэсиба Морихэй"/></a>
	</div>
	<div class="brick">
		<h5>&laquo;ИСКУССТВО МИРА&raquo;  <br/>
		<span>УЭСИБА МОРИХЭЙ</span></h5>    		
		<small>из бесед, стихов, каллиграфии О'Сенсея</small>
		<p><a href="#">Прочесть</a></p>
	</div>
</div>
-->
                <jdoc:include type="modules" name="right" style="custom"  />
            </aside>
        <?php endif; ?>
        
        <?php if ($showbottom) : ?>
            <div class="tpl-bottom">
                <jdoc:include type="modules" name="bottom" style="custom" />
            </div>
        <?php endif ; ?>
        <div class="tpl-pushfooter"><!-- footer placeholder --></div>
    </div>
</div><!-- allpage -->

<footer class="tpl-footer">

    <jdoc:include type="modules" name="footer" style="custom" />

</footer>

<jdoc:include type="modules" name="debug" />

<?php if ($jqbottom) { ?>
    <!-- JavaScript at the bottom for fast page loading -->
    <?php if ($jsframework == 'jq' || $jsframework == 'moocjq' || $jsframework == 'moocmjq') { ?>
    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/<?php echo $jqversion; ?>/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="<?php echo $templatepath; ?>/js/jquery-1.7.1.min.js"><\/script>');
    window.jQuery && jQuery.noConflict();
    </script>
    <?php } ?>

    <?php if ($pluginsjs) { ?>
    <!-- scripts concatenated and minified via ant build script-->
    <script src="<?php echo $templatepath; ?>/js/plugins.js"></script>
    <?php } ?>
    <!-- end scripts-->
<?php }
else
    echo '<!-- JavaScript loaded at the top of the page -->';
?>

<?php if ($gacode) :?>
<script>
    var _gaq=[['_setAccount','<?php echo $gacode;?>'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif ; ?>
<?php if ($yacode) :?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter<?php echo $yacode;?> = new Ya.Metrika({id:<?php echo $yacode;?>, enableAll: true, webvisor:true});
        } catch(e) { }
    });
    
    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<!-- noscript><div><img src="//mc.yandex.ru/watch/<?php echo $yacode;?>" style="position:absolute; left:-9999px;" alt="" /></div></noscript -->
<!-- /Yandex.Metrika counter -->
<?php endif ; ?>

</body>
</html>
