<?php

namespace LegoCMS\Core\View;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Factory;
use LegoCMS\Listings\ListingsBuilder;

class ListingsView implements Renderable
{
    /** @var \Illuminate\View\Factory */
    protected $view;

    /** @var \LegoCMS\Core\ViewBuilder */
    protected $builder;

    /** @var \LegoCMS\Core\Module */
    protected $module;

    protected $renderable;

    public function __construct(Factory $view)
    {
        $this->view = $view;

        $this->renderable = new AppShell();
    }

    public function make(ListingsBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    protected function build()
    {
        $this->builder->build();

        $this->renderable
            ->setSlot($this->builder->renderable());
    }

    /**
     * render
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->build();

        return $this->view->make("legocms::admin.layout", ['content' => $this->renderable]);
    }
}
