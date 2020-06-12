<?php

namespace LegoCMS\Forms\Support;

use Closure;
use Illuminate\Support\Str;
use LegoCMS\Core\Component;

abstract class BaseField extends Component
{
    /** @var string */
    protected $component;

    /** @var string */
    protected $name;

    /** @var string */
    protected $property;

    /** @var mixed */
    protected $value;

    /** @var bool */
    protected $isComputed = false;

    /** @var Closure */
    protected $computedValueCallback;

    /** @var array|string */
    protected $rules;

    /** @var array|string */
    protected $rulesForCreate;

    /** @var array|string */
    protected $rulesForUpdate;

    /** @var string */
    protected $helpText = "";

    /**
     * __contruct()
     */
    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Returns Field object.
     *
     * @param  string $name
     * @param  string|callable $property
     *
     * @return static
     */
    public static function make(string $name, callable $property = null)
    {
        $fieldInstance = new static($name);

        if ($property instanceof Closure || is_callable($property) && is_object($property)) {
            $fieldInstance->setComputed($property);
        } else {
            $fieldInstance->setProperty($property);
        }

        return $fieldInstance;
    }

    /**
     * Define rules for field.
     *
     * @param  array|string $rules
     *
     * @return static
     */
    public function rules($rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Define rules for field while creating.
     *
     * @param  array|string $rules
     *
     * @return static
     */
    public function rulesForCreate($rules): self
    {
        $this->rulesForCreate = $rules;

        return $this;
    }

    /**
     * Define rules for field while creating.
     *
     * @param  array|string $rules
     *
     * @return static
     */
    public function rulesForUpdate($rules): self
    {
        $this->rulesForUpdate = $rules;

        return $this;
    }

    /**
     * @param  Closure|callable $property
     * @return void
     */
    public function setComputed(callable $property): self
    {
        $this->isComputed = true;
        $this->computedValueCallback = $property;

        return $this;
    }

    /**
     * @param string $property
     * @return static
     */
    public function setProperty(string $property = null)
    {
        $this->property = $property ?? $this->resolvePropertyFromName();

        return $this;
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * getProperty
     *
     * @return string
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * setValue
     *
     * @param  mixed $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * getValue
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * helpText
     *
     * @param  string $text
     * @return static
     */
    public function helpText(string $text)
    {
        $this->helpText = $text;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function build(): void
    {
        $this->buildForComputedComponent();
    }

    /**
     * buildForComputed(): builds Field component value if Computed.
     *
     * @return void
     */
    protected function buildForComputedComponent(): void
    {
        if ($this->isComputed) {
            $this->setProperty($this->resolvePropertyFromName());
            $this->setValue(\app()->call($this->computedValueCallback));
        }
    }

    protected function resolvePropertyFromName(): string
    {
        return \str_replace(" ", "_", Str::lower($this->name));
    }

    /**
     * isPrimaryField
     *
     * @return bool
     */
    public function isPrimaryField()
    {
        return false;
    }
}
