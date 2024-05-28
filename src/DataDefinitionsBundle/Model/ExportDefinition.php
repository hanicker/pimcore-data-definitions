<?php
/**
 * Data Definitions.
 *
 * LICENSE
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md and gpl-3.0.txt
 * files that are distributed with this source code.
 *
 * @copyright 2024 instride AG (https://instride.ch)
 * @license   https://github.com/instride-ch/DataDefinitions/blob/5.0/gpl-3.0.txt GNU General Public License version 3 (GPLv3)
 */

declare(strict_types=1);

namespace Instride\Bundle\DataDefinitionsBundle\Model;

use League\Flysystem\FilesystemException;

/**
 * @method ExportDefinition\Dao getDao()
 */
class ExportDefinition extends AbstractDataDefinition implements ExportDefinitionInterface
{
    use IdGenerator;

    /**
     * @var string
     */
    public $fetcher;

    /**
     * @var array
     */
    public $fetcherConfig;

    /**
     * @var bool
     */
    public $fetchUnpublished = false;

    public static function getById($id)
    {
        $definitionEntry = new ExportDefinition();
        $definitionEntry->setId((int)$id);

        $dao = $definitionEntry->getDao();
        $dao->getById($id);
        return $definitionEntry;
    }

    /**
     * @throws FilesystemException
     * @throws FilesystemException
     */
    public function setId($id)
    {
        $this->id = $id  ?: $this->getSuggestedId('export-definitions') ;
    }

    public function setName($name)
    {
        $this->name = $name;
        if(!$this->id) {
            $this->setId($this->getSuggestedId('export-definitions'));
        }
    }

    public static function getByName($id)
    {
        $definitionEntry = new ExportDefinition();
        $definitionEntry->setId((int)$id);
        /**
         * @var \Instride\Bundle\DataDefinitionsBundle\Model\ExportDefinition\Dao|\Instride\Bundle\DataDefinitionsBundle\Model\ImportDefinition\Dao
         */
        $dao = $definitionEntry->getDao();
        $dao->getById($id);

        return $definitionEntry;
    }

    public function getFetcher()
    {
        return $this->fetcher;
    }

    public function setFetcher($fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function getFetcherConfig()
    {
        return $this->fetcherConfig;
    }

    public function setFetcherConfig($fetcherConfig)
    {
        $this->fetcherConfig = $fetcherConfig;
    }

    /**
     * @param bool $fetchUnpublushed
     */
    public function setFetchUnpublished(bool $fetchUnpublushed): void
    {
        $this->fetchUnpublished = $fetchUnpublushed;
    }

    /**
     * @return bool
     */
    public function isFetchUnpublished(): bool
    {
        return $this->fetchUnpublished;
    }
}
