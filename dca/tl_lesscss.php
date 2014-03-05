<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 

/**
 * Table tl_lesscss
 */
$GLOBALS['TL_DCA']['tl_lesscss'] = array
(
 	// Config
 	'config' => array
 	(
 		'dataContainer'					=> 'Table',
 		'enableVersioning'				=> true,
 		'ptable'						=> 'tl_theme',
 		'sql' => array
 		(
 			'keys' => array
 			(
 				'id' => 'primary',
 				'pid' => 'index'
 			)
 		)
 	),

 	// List
 	'list' => array
 	(
 		'sorting' => array
 		(
 			'mode'						=> 1,
 			'fields'					=> array('name'),
 			'flag'						=> 1,
 			'panelLayout'				=> 'filter;search,limit',
 		),
 		'label' => array
 		(
 			'fields'					=> array('name'),
 			'format'					=> '%s',
 		),
 		'global_operations' => array
 		(
 			'all' => array
 			(
 				'label'					=> &$GLOBALS['TL_LANG']['MSC']['all'],
 				'href'					=> 'act=select',
 				'class'					=> 'header_edit_all',
 				'attributes'			=> 'onclick="Backend.getScrollOffset();" accesskey="e"'
 			),
 		),
 		'operations' => array
 		(
 			'edit' => array
 			(
 				'label'					=> &$GLOBALS['TL_LANG']['tl_lesscss']['edit'],
 				'href'					=> 'act=edit',
 				'icon'					=> 'edit.gif'
 			),
			'editSource' => array
			(
				'label'           		=> &$GLOBALS['TL_LANG']['tl_lesscss']['editSource'],
				'icon'            		=> 'editor.gif',
				'button_callback' 		=> array('tl_lesscss', 'editSourceButton')

			),
			'compile' => array
			(
				'label'           		=> &$GLOBALS['TL_LANG']['tl_lesscss']['compile'],
				'href'            		=> 'key=lesscss_compile',
				'icon'            		=> 'system/modules/lesscss/assets/icon.png',
			),
 			'copy' => array
 			(
 				'label'					=> &$GLOBALS['TL_LANG']['tl_lesscss']['copy'],
 				'href'					=> 'act=copy',
 				'icon'					=> 'copy.gif'
 			),
 			'delete' => array
 			(
 				'label'					=> &$GLOBALS['TL_LANG']['tl_lesscss']['delete'],
 				'href'					=> 'act=delete',
 				'icon'					=> 'delete.gif',
 				'attributes'			=> 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
 			),
 			'show' => array
 			(
 				'label'					=> &$GLOBALS['TL_LANG']['tl_lesscss']['show'],
 				'href'					=> 'act=show',
 				'icon'					=> 'show.gif'
 			),
 		)
 	),

 	// Palettes
 	'palettes' => array
 	(
 		'default'						=> '{name_legend},name;{file_legend},source,target;{publish_legend},published,start,stop',
 	),

 	// Fields
 	'fields' => array
 	(
 		'id' => array
 		(
 			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
 		),
 		'pid' => array
 		(
 			'sql'                     	=> "int(10) unsigned NOT NULL default '0'"
 		),
 		'tstamp' => array
 		(
 			'sql'                     	=> "int(10) unsigned NOT NULL default '0'"
 		),
 		'name' => array
 		(
 			'label'						=> &$GLOBALS['TL_LANG']['tl_lesscss']['name'],
 			'exclude'					=> true,
 			'inputType'					=> 'text',
 			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'tl_class'=>'w50'),
 			'sql'                     	=> "varchar(255) NOT NULL default ''"
 		),
 		'source' => array
 		(
 			'label'						=> &$GLOBALS['TL_LANG']['tl_lesscss']['source'],
 			'exclude'					=> true,
			'inputType'               	=> 'fileTree',
			'eval'                    	=> array('filesOnly'=>true, 'extensions'=>'less', 'fieldType'=>'radio'),
 			'sql'                     	=> "binary(16) NULL"
 		),
 		'target' => array
 		(
 			'label'						=> &$GLOBALS['TL_LANG']['tl_lesscss']['target'],
 			'exclude'					=> true,
 			'inputType'					=> 'text',
			'load_callback'				=> array(array('tl_lesscss', 'generateTargetFilename')),
 			'eval'						=> array('mandatory'=>true, 'maxlength'=>255, 'unique'=>true, 'tl_class'=>'w50'),
 			'sql'                     	=> "varchar(255) NOT NULL default ''"
 		),
 	)
);

class tl_lesscss
{

	public function generateTargetFilename($varValue, $dc)
	{
		if($varValue) return $varValue;
		return 'assets/css/less-'.$dc->id.'.css';
	}

	/**
	 * Return the edit file source button
	 *
	 * @param array
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	public function editSourceButton($row, $href, $label, $title, $icon, $attributes)
	{
		$file = \FilesModel::findByUuid($row['source']);

		if(!$file || !file_exists(TL_ROOT.'/'.$file->path))
		{
			return '';
		}

		return '<a href="contao/main.php?do=files&act=source&id='.$file->path.'&rt='.\RequestToken::get().'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label).'</a> ';
	}
}