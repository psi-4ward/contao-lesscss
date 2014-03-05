<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */

if(TL_MODE == 'BE')
{
	$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_lesscss';
	$GLOBALS['BE_MOD']['design']['themes']['lesscss_edit'] = array('LessCssMod', 'edit');
	$GLOBALS['BE_MOD']['design']['themes']['lesscss_compile'] = array('LessCssMod', 'compileFromTlLesscss');
	$GLOBALS['TL_CONFIG']['editableFiles'] .= ',less';
} else {
	$GLOBALS['TL_HOOKS']['generatePage'][] = array('LessCssMod', 'injectFe');
}

