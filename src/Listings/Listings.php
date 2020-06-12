<?php

namespace LegoCMS\Listings;

use LegoCMS\Core\Component;

class Listings extends Component
{
    /** @var string Name of the component */
    protected $name;

    /** @var \LegoCMS\Core\Module Module to which component refers to. */
    protected $module;

    /** @var string */
    protected $component = "legocms-listings";

    /**
     * __construct()
     *
     * @param  string $name
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * make()
     *
     * @param  string $name
     * @param  \LegoCMS\Core\Module $module
     *
     * @return static
     */
    public static function make(string $name, $module)
    {
        $instance = new static($name);

        $instance->setModule($module);

        return $instance;
    }

    /**
     * Undocumented function
     *
     * @param  \LegoCMS\Core\Module $module
     *
     * @return static
     */
    protected function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * setHeaders
     *
     * @param \LegoCMS\Listings\Support\ListingsHeaders $headers
     *
     * @return void
     */
    public function setHeaders($headers)
    {
        $headers->each(function ($header) {
            $this->setSlot($header, 'header');
        });
    }

    public function setActions()
    {
    }

    public function setListingsData()
    {
    }

    protected function prepareVueAttributes(): array
    {
        return [
            'name' => $this->name
        ];
    }
}
