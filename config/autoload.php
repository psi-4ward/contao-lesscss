<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */


// Register the classes
ClassLoader::addClasses(array
(
	'LessCssMod' 	=> 'system/modules/lesscss/LessCssMod.php',
));

// Register the templates
TemplateLoader::addFiles(array
(
//	'mod_' 					=> 'system/modules/lesscss/templates',
));
