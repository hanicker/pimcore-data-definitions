<?php

declare(strict_types=1);

/*
 * This source file is available under two different licenses:
 *  - GNU General Public License version 3 (GPLv3)
 *  - Data Definitions Commercial License (DDCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) CORS GmbH (https://www.cors.gmbh) in combination with instride AG (https://instride.ch)
 * @license    GPLv3 and DDCL
 */

namespace Instride\Bundle\DataDefinitionsBundle\Interpreter;

use Instride\Bundle\DataDefinitionsBundle\Context\InterpreterContext;
use Instride\Bundle\DataDefinitionsBundle\Context\InterpreterContextInterface;

class AssetsUrlInterpreter extends AssetUrlInterpreter
{
    public function interpret(InterpreterContextInterface $context): mixed
    {
		$val = $context->getValue();
		if(!is_array($val)){
			$val = explode(',',$val);
		}
		$val = (array)$val;
        $assets = [];
        foreach ($val as $item) {
			if(!$item){
				continue;
			}
            $childContext = new InterpreterContext(
                $context->getDefinition(),
                $context->getParams(),
                $context->getConfiguration(),
                $context->getDataRow(),
                $context->getDataSet(),
                $context->getObject(),
                $item,
                $context->getMapping(),
            );
            $asset = parent::interpret($childContext);

            if ($asset) {
                $assets[] = $asset;
            }
        }
		if(!count($assets)){
			return null;
		}
		if($context->getMapping()->toColumn == 'galleria_img'){
			$items = [];
			foreach($assets as $img){

			   $advancedImage = new \Pimcore\Model\DataObject\Data\Hotspotimage();
			   $advancedImage->setImage($img);
			   $items[] = $advancedImage;
			}
			return new \Pimcore\Model\DataObject\Data\ImageGallery($items);
		}


        return $assets ?: null;
    }
}
