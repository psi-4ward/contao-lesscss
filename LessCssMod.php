<?php

/**
 * @copyright 4ward.media 2014 <http://www.4wardmedia.de>
 * @author Christoph Wiechert <wio@psitrax.de>
 */
 
class LessCssMod
{

	public function injectFe($objPage, $objLayout, $objPageRegular)
	{
		$ids = deserialize($objLayout->lesscss, true);
		if(!count($ids)) return;

		$objMetas = \Database::getInstance()->prepare('SELECT * FROM tl_lesscss WHERE FIND_IN_SET(id,?)')->execute(implode(',', $ids));
		while($objMetas->next())
		{
			if($GLOBALS['TL_CONFIG']['cacheMode'] == 'none' || $GLOBALS['TL_CONFIG']['cacheMode'] == 'browser' || $GLOBALS['TL_CONFIG']['bypassCache'])
			{
				$objFile = \FilesModel::findByUuid($objMetas->source);
				if($objFile)
				{
					self::compile($objFile->path, $objMetas->target);
				}
			}

			$GLOBALS['TL_HEAD'][] = '<link rel="stylesheet" href="'.$objMetas->target.'">';
		}

	}


	/**
	 * Compile a less file or string
	 * @param string $source	Source file path (content is ignored if $less is not empty)
	 * @param string $target	Target file path
	 * @param mixed [$less]		LESS code to compile
	 */
	public static function compile($source, $target, $less=false)
	{
		try
		{
			$parser = new Less_Parser();
			if($less !== false)
			{
				$parser->parse($less);
			}
			else
			{
				$parser->parseFile(TL_ROOT.'/'.$source);
			}
			$objTarget = new \File($target);
			$objTarget->write($parser->getCss());
			if(TL_MODE == 'BE') \Message::addInfo("{less} file $source compiled to $target");
		}
		catch(Exception $e)
		{
			if(TL_MODE == 'BE') \Message::addError($e->getMessage());
		}
	}


	/**
	 * compile from tl_lesscss DCA opartion
	 * @param $dc
	 */
	public function compileFromTlLesscss($dc) {
		$objMeta = \Database::getInstance()->prepare('SELECT * FROM tl_lesscss WHERE id=?')->execute($dc->id);
		if(!$objMeta->numRows) {
			\Message::addError("tl_lesscss.id = {$dc->id} not found!");
			return;
		}

		$objFile = \FilesModel::findByUuid($objMeta->source);
		if(!$objFile)
		{
			\Message::addError("File for tl_lesscss.id = {$dc->id} not found!");
			return;
		}

		self::compile($objFile->path, $objMeta->target);
		\Controller::redirect(\System::getReferer());
	}


	/**
	 * compile from File-Manager source-edit save
	 */
	public function compileFromSave()
	{
		if(\Input::get('act') == 'source' && \Input::post('FORM_SUBMIT') == 'tl_files' && substr(\Input::get('id'),-4) == 'less')
		{
			// find file in tl_lesscss
			$objFile = \FilesModel::findByPath(\Input::get('id'));
			if(!$objFile) return;

			$objMeta = \Database::getInstance()->prepare('SELECT * FROM tl_lesscss WHERE source=?')->execute($objFile->uuid);
			if(!$objMeta->numRows) return;


			self::compile($objFile->path, $objMeta->target, \Input::postRaw('source'));
		}

	}
}