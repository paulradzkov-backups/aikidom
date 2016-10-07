<?php

// No direct access.
defined('_JEXEC') or die;

// function used to modify module displaying
// usage: <jdoc:include type="modules" name="....." style="custom"/>

function modChrome_custom($module, &$params, &$attribs)
{
 
    //$suffx = substr($params->get('moduleclass_sfx'),0,3); //takes first 3 chars from moduleclass_sfx
    //$badge = preg_match ('/badge/', $params->get('moduleclass_sfx'))?"<span class=\"badge\">&nbsp;</span>\n":""; //gets badge-class. Use " badge-hot", " badge-new" etc. in moduleclass_sfx
    //switch ($suffx) {

    //default :
	?>
		<div class="tpl-module<?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?> <?php echo $module->module; ?>" id="Mod<?php echo $module->id; ?>">
			<?php //echo $badge; ?>
			<?php if ($module->showtitle != 0) : ?>
				<div class="mod-title-wrapper"><h2 class="mod-title"><?php echo $module->title; ?></h2></div>
			<?php endif; ?>
			<div class="mod-content">
				<?php echo $module->content;?>
			</div>
		</div>
	<?php
    //break;}	
    
    
    
}

