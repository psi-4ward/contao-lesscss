<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */

$GLOBALS['TL_DCA']['tl_layout']['fields']['lesscss'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_layout']['lesscss'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'checkboxWizard',
	'options_callback'        => array('tl_layout_lesscss', 'getLessFiles'),
	'eval'                    => array('multiple'=>true),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA']['tl_layout']['palettes']['default'] = str_replace(',stylesheet,', ',stylesheet,lesscss,', $GLOBALS['TL_DCA']['tl_layout']['palettes']['default']);

class tl_layout_lesscss
{

	public function getLessFiles(DataContainer $dc)
	{
		$return = array();

		$obj = \Database::getInstance()->execute("SELECT id,name,target FROM tl_lesscss");

		while($obj->next())
		{
			$return[$obj->id] = "{$obj->name} ({$obj->target})";
		}

		return $return;
	}

}