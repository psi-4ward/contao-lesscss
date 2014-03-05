<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */

// Add the theme-operation icon
array_insert($GLOBALS['TL_DCA']['tl_theme']['list']['operations'], 6,
	array(
		'lesscss' =>
			array
			(
				'label' => &$GLOBALS['TL_LANG']['tl_theme']['lesscss'],
				'href'  => 'table=tl_lesscss',
				'icon'  => 'system/modules/lesscss/assets/icon.png'
			)
	)
);
