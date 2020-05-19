<?php

namespace LegoCMS\Core\View;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\HtmlString;
use Illuminate\View\Factory;
use LegoCMS\Listings\ListingsBuilder;

class ListingsView implements Renderable
{
    protected $view;

    protected $builder;

    protected $module;

    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    public function make(ListingsBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * render
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function render()
    {
        $this->builder->build();

        return $this->view->make("legocms::admin.layout", ['content' => new HtmlString($this->builder->result())]);
    }
}
