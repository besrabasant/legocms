<?php

namespace LegoCMS\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LegoCMS\Core\Actions\CreateAction;
use LegoCMS\Core\Actions\DeleteAction;
use LegoCMS\Core\Actions\InbuiltActions;
use LegoCMS\Core\Actions\StoreAction;
use LegoCMS\Core\Actions\UpdateAction;
use LegoCMS\Core\DefaultSkleton;
use LegoCMS\Forms\FormBuilder;
use LegoCMS\Listings\ListingsBuilder;
use LegoCMS\Support\Behaviors\ResolvesLegoSetName;

abstract class Module
{
    use ResolvesLegoSetName;

    /** @var string */
    protected $skeltonDefinition = DefaultSkleton::class;

    /** @var \LegoCMS\Core\Contracts\Skleton|\LegoCMS\Core\Support\BaseSkleton */
    protected $moduleSkeleton;

    /** @var string */
    protected $moduleName;

    /** @var string */
    protected $legoSetName;

    /** @var string */
    protected $model;

    /** @var string */
    protected $controller;

    /** @var bool */
    protected $translatable = false;

    /** @var string */
    protected $formBuilder = FormBuilder::class;

    /** @var string */
    protected $listingsBuilder = ListingsBuilder::class;

    /**
     * __construct()
     */
    private function __construct()
    {
        $this->moduleSkeleton = new $this->skeltonDefinition();
    }

    /**
     * make
     *
     * @return self
     */
    public static function make(): self
    {
        return new static();
    }

    /**
     * getModuleName(): Returns module name.
     *
     * @return string
     */
    public function getModuleName(): string
    {
        if (!$this->moduleName) {
            $this->moduleName = $this->resolveModuleName();
        }

        return $this->moduleName;
    }

    /**
     * getModuleNamePlural() : Returns plural module name.
     *
     * @return string
     */
    public function getModuleNamePlural(): string
    {
        return Str::plural($this->getModuleName());
    }

    /**
     * getLegoSetName(): Returns lego set name of the module.
     *
     * @return string
     */
    public function getLegoSetName(): string
    {
        if (!$this->legoSetName) {
            $this->legoSetName = $this->resolveLegoSetName();
        }

        return $this->legoSetName;
    }

    /**
     * getModel(): Returns corresponding model name.
     *
     * @return string
     */
    public function getModel(): string
    {
        if (!$this->model) {
            $this->model = $this->resolveNameSpace(
                $this->moduleSkeleton->modelsFolder()
            ) . \class_basename(static::class);
        }

        return $this->model;
    }

    /**
     * getModelInstance(): Returns corresponding model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModelInstance()
    {
        return optional($this->getModel(), function ($model) {
            return new $model();
        });
    }

    /**
     * getModelInstance(): Returns corresponding model query instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getModelQueryInstance()
    {
        return optional($this->getModel(), function ($model) {
            return $model::query();
        });
    }

    /**
     * getController(): Returns corresponding controller name.
     *
     * @return string
     */
    public function getController(): string
    {
        if (!$this->controller) {
            $this->controller = $this->resolveNameSpace(
                $this->moduleSkeleton->controllersFolder()
            ) . \class_basename(static::class) . "Controller";
        }

        return $this->controller;
    }

    /**
     * isTranslatable(): Returns if the module is translatable.
     *
     * @return boolean
     */
    public function isTranslatable(): bool
    {
        return $this->translatable;
    }

    /**
     * fields(): Returns module fields.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request): array
    {
        return [];
    }

    protected function defaultActions(): array
    {
        return [
            CreateAction::make($this),
            StoreAction::make($this),
            UpdateAction::make($this),
            DeleteAction::make($this)
        ];
    }

    /**
     * getFormBuilder(): Returns module form builder instance.
     *
     * @return FormBuilder
     */
    public function getFormBuilder(): FormBuilder
    {
        return $this->formBuilder::make($this);
    }

    /**
     * getListingsBuilder: Return module listings builder instance.
     *
     * @return ListingsBuilder
     */
    public function getListingsBuilder(): ListingsBuilder
    {
        return $this->listingsBuilder::make($this);
    }

    public function showListings()
    {
    }

    /**
     * resolveActionFromRequest(): Resolves action from request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \LegoCMS\Core\Action
     */
    public function resolveActionFromRequest(Request $request)
    {
        $routename = $request->route()->getName();
        $routeAction = last(explode('.', $routename));
        $inbuiltActions = InbuiltActions::make($this->defaultActions());

        return $inbuiltActions->get($routeAction);
    }

    public function getRoute($action = "", $options = [], $namespace = "legocms")
    {
        return \route($namespace . "." . $this->getModuleNamePlural() . "." . $action, $options);
    }


    protected function resolveNameSpace(string $location): string
    {
        return $this->getLegoSetName() . $this->moduleSkeleton->resolveNameSpace($location);
    }

    protected function resolveModuleName()
    {
        return Str::snake(class_basename(static::class));
    }
}
