<?php

namespace LegoCMS\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LegoCMS\Core\DefaultSkleton;
use LegoCMS\Forms\FormBuilder;

abstract class Module
{
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

    public function getModuleName(): string
    {
        if (!$this->moduleName) {
            $this->moduleName = $this->resolveModuleName();
        }

        return $this->moduleName;
    }

    public function getLegoSetName(): string
    {
        if (!$this->legoSetName) {
            $this->legoSetName = $this->resolveLegoSetName();
        }

        return $this->legoSetName;
    }

    public function getModel(): string
    {
        if (!$this->model) {
            $this->model = $this->resolveNameSpace(
                $this->moduleSkeleton->modelsFolder()
            ) . \class_basename(static::class);
        }

        return $this->model;
    }

    public function getController(): string
    {
        if (!$this->controller) {
            $this->controller = $this->resolveNameSpace(
                $this->moduleSkeleton->controllersFolder()
            ) . \class_basename(static::class) . "Controller";
        }

        return $this->controller;
    }

    public function isTranslatable()
    {
        return $this->translatable;
    }

    public function fields(Request $request): array
    {
        return [];
    }

    public function getFormBuilder(): FormBuilder
    {
        return $this->formBuilder::make($this);
    }

    public function getRoute($action = "", $options = [])
    {
        return \route($this->getModuleName() . "." . $action, $options);
    }

    private function resolveLegoSetName(): string
    {
        return \ltrim(\explode("\\", static::class)[0], "\\");
    }

    private function resolveNameSpace(string $location): string
    {
        return $this->getLegoSetName() . $this->moduleSkeleton->resolveNameSpace($location);
    }

    private function resolveModuleName()
    {
        return Str::snake(class_basename(static::class));
    }
}
