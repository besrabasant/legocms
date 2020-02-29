<?php

namespace LegoCMS\Services;

use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;

/**
 * class LegoCMS.
 *
 * @category Services
 * @package  LegoCMS\Services
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Services/LegoCMS.php
 *
 * TODO: Add support for LegoSet Skeleton.
 * A LegoSetSkeleton defines the structure of the package.
 * Each LegoSet with use the default skeleton by default,
 * but can define its own Skeleton and pass the Skeleton in the config.
 */
class LegoCMS
{
    /**
     * $app
     *
     * @var  \Illuminate\Foundation\Application
     */
    private $app;

    /**
     * Lego Sets Repository.
     *
     * @var  \LegoCMS\Services\LegoSetsRepository
     */
    private $legoSetsRepository;

    /**
     * Required Keys.
     *
     * @var  array
     */
    private $requiredKeys = [
        'namespace',
        'package_root'
    ];

    /**
     * __construct
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->legoSetsRepository = new LegoSetsRepository();
    }

    /**
     * Adds Lego Set to the repository.
     *
     * @param  string  $legoSetKey
     * @param  array  $legoSetConfig
     *
     * @return  void
     */
    public function addLegoSet(string $legoSetKey, array $legoSetConfig)
    {
        $this->checkConfigForRequiredItems($legoSetConfig);

        $this->legoSetsRepository->put($legoSetKey, new LegoSet($legoSetConfig));
    }

    /**
     * Returns the lego set config of the passed key.
     *
     * @param  string  $legoSetKey
     *
     * @return \LegoCMS\Services\LegoSet
     */
    public function get(string $legoSetKey)
    {
        return $this->legoSetsRepository->get($legoSetKey);
    }

    /**
     * Returns all registered lego sets.
     *
     * @return  \LegoCMS\Services\LegoSetsRepository
     */
    public function all()
    {
        return $this->legoSetsRepository;
    }

    /**
     * Check for required config items present in the config.
     *
     * @param  array  $config
     * @return  void
     */
    private function checkConfigForRequiredItems(array $config)
    {
        if (!Arr::has($config, $this->requiredKeys)) {
            throw new Exception("Missing required keys"); // TODO: Add Proper message.
        }
    }
}
