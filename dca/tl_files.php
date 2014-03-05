<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */

$GLOBALS['TL_DCA']['tl_files']['config']['onload_callback'][] = array('LessCssMod', 'compileFromSave');