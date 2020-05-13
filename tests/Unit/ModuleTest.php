<?php

namespace LegoCMS\Tests\Unit;

use DemoSet1\Modules\DemoModule;
use Mockery;

class ModuleTest extends TestCase
{
    /** @var \LegoCMS\Core\Module */
    public $module;

    protected function setUp(): void
    {
        parent::setUp();

        $this->module = DemoModule::make();
    }
    /**
     * @test
     */
    public function test_module_name_is_snake_case_of_module_class_base_name()
    {
        $this->assertEquals(
            'demo_module',
            $this->module->getModuleName()
        );
    }

    /**
     * @test
     */
    public function test_module_lego_set_name()
    {
        $this->assertEquals(
            'DemoSet1',
            $this->module->getLegoSetName()
        );
    }

    public function test_module_model_name()
    {
        $this->assertEquals(
            "DemoSet1\\Models\\DemoModule",
            $this->module->getModel()
        );
    }

    public function test_module_controller_name()
    {
        $this->assertEquals(
            "DemoSet1\\Admin\\Http\\Controllers\\DemoModuleController",
            $this->module->getController()
        );
    }
}