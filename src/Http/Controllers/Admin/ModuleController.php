<?php

namespace LegoCMS\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\Support\View;
use LegoCMS\Http\Controllers\Controller;
use LegoCMS\Services\LegoSet;
use LegoCMS\Support\Facades\LegoCMS;

/**
 * Class ModuleController
 *
 * @category Controllers
 * @package  LegoCMS\Http\Controllers\Admin
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Http/Controllers/Admin/ModuleController.php
 */
abstract class ModuleController extends Controller
{
    use Behaviours\ProvidesReturnRoutes,
        Behaviours\HandlesRevisions,
        Behaviours\HandlesFlashNotifications;

    /**
     * $namespace
     *
     * @var string
     */
    protected $namespace = "";

    /**
     * $legoSet
     *
     * @var string
     */
    protected $legoSet = "";

    /**
     * $moduleName.
     *
     * @var null
     */
    protected $moduleName = null;

    /**
     * $modelName.
     *
     * @var null|string
     */
    protected $modelName = null;


    /**
     * $modelRepository
     *
     * @var \LegoCMS\Repositories\ModuleRepository
     */
    protected $modelRepository = null;

    /**
     * $filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * $listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * ModuleController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->namespace = $this->resolveNameSpace();

        $this->legoSet = $this->resolveSetNameFromLegoSetsRepository();

        // $this->modelRepository = \app($this->getRepositoryName(), [
        //     'model' => \app($this->getModelName())
        // ]);

        $this->shareModule();

        $this->sharePageService();

        $this->shareFormService();

        $this->shareListingsService();
    }

    /**
     * Returns PageService Defaults
     *
     * @return  array
     */
    protected function pageDefaults()
    {
        return [];
    }

    /**
     * Returns FormService Defaults
     *
     * @return  array
     */
    protected function formDefaults()
    {
        return [];
    }

    /**
     * Returns default columns
     *
     * @return void
     */
    protected function listingsDefaultColumns()
    {
        return [
            'name' => 'Name',
        ];
    }

    /**
     * Returns ListingsService Defaults
     *
     * @return  array
     */
    protected function listingsDefaults()
    {
        return [];
    }

    /**
     * Shares LegoCMS Page Service.
     *
     * @return  void
     */
    private function sharePageService()
    {
        $pageService = \app("legocms::services.page");

        $pageService->setDefaults($this->pageDefaults());

        ViewFacade::share("page", $pageService);
    }

    /**
     * Shares LegoCMS Form Service.
     *
     * @return  void
     */
    private function shareFormService()
    {
        $formService = \app("legocms::services.forms");

        $formService->setDefaults($this->formDefaults());

        ViewFacade::share("forms", $formService);
    }

    /**
     * Shares LegoCMS Listings Service.
     *
     * @return  void
     */
    private function shareListingsService()
    {
        $listingsService = \app("legocms::services.listings");

        $defaultColumns = $this->listingsDefaultColumns();

        /** @var \LegoCMS\Models\BaseModel */
        $model = \app($this->getModelName());

        if ($model->isTranslatable()) {
            $defaultColumns['translations'] = 'Translations';
        }

        $listingsService->setDefaults(
            \array_replace_recursive(
                ['columns' => $defaultColumns],
                $this->listingsDefaults()
            )
        );

        ViewFacade::share("listings", $listingsService);
    }

    /**
     * Shares Module
     *
     * @return  void
     */
    private function shareModule()
    {
        ViewFacade::share("module", $this->getModuleName());
        ViewFacade::share("module_singular", $this->getSingularModuleName());
    }

    /**
     * Controller index method.
     *
     * @return void
     */
    public function index()
    {
        return \view()->first(
            [
                "{$this->getModuleName()}.index",
                "{$this->getLegoSet()}::{$this->getModuleName()}.index",
                "legocms::admin.layouts.listings"
            ],
            $this->getIndexViewData()
        );
    }

    /**
     * Controller create method.
     *
     * @return View
     */
    public function create()
    {
        return \view()->first(
            [
                "{$this->getModuleName()}.create",
                "{$this->getModuleName()}.form",
                "{$this->getLegoSet()}::{$this->getModuleName()}.create",
                "{$this->getLegoSet()}::{$this->getModuleName()}.form",
                "legocms::admin.layouts.form"
            ],
            \array_merge(
                [$this->getCreateViewDataKey() => \app($this->getModelName())],
                $this->getCreateViewAdditionalData()
            )
        );
    }

    /**
     * Controller store method.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        /** @var \LegoCMS\Http\Requests\Admin\FormRequest */
        $request = $this->validateFormRequest('create');

        /** @var \LegoCMS\Models\BaseModel */
        $model = \app($this->getModelName());

        $data = \array_replace(
            $request->all($model->getFillable()),
            $this->prepareDataForStore($request, $model)
        );

        $model->fill($data);

        $model->save();

        $this->notifySuccess($this->resolveModelNameFromController() . " created successfully.");

        return $this->returnToIndexRoute();
    }


    /**
     * Controller show method.
     *
     * @param  mixed  $id
     *
     * @return  View
     */
    public function show($id)
    {
        /** @var \LegoCMS\Models\BaseModel */
        $model = $this->getModelName()::find($id);

        return \view()->first(
            [
                "{$this->getModuleName()}.show",
                "{$this->getLegoSet()}::{$this->getModuleName()}.show",
                "legocms::admin.layouts.single"
            ],
            \array_merge(
                [$this->getSingleViewDataKey() => $model],
                $this->getSingleViewAdditionalData()
            )
        );
    }


    /**
     * Controller edit method.
     *
     * @param mixed $id
     *
     * @return View
     */
    public function edit($id)
    {
        /** @var \LegoCMS\Models\BaseModel */
        $model = $this->getModelName()::find($id);

        return \view()->first(
            [
                "{$this->getModuleName()}.edit",
                "{$this->getModuleName()}.form",
                "{$this->getLegoSet()}::{$this->getModuleName()}.edit",
                "{$this->getLegoSet()}::{$this->getModuleName()}.form",
                "legocms::admin.layouts.form",
            ],
            \array_merge(
                [$this->getEditViewDataKey() => $model],
                $this->getEditViewAdditionalData()
            )
        );
    }

    /**
     * Controller update method.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function update($id)
    {
        /** @var \LegoCMS\Http\Requests\Admin\FormRequest */
        $request = $this->validateFormRequest('update');

        /** @var \LegoCMS\Models\BaseModel */
        $model = $this->getModelName()::firstWhere('id', $id);

        $data = \array_replace(
            $request->all($model->getFillable()),
            $this->prepareDataForUpdate($request, $model)
        );

        $model->fill($data);

        $model->save();

        $this->notifySuccess($this->resolveModelNameFromController() . " updated successfully.");

        return $this->returnToIndexRoute();
    }

    /**
     * Controller destroy method.
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $this->getModelName()::destroy($id);

        $this->notifySuccess($this->resolveModelNameFromController() . " deleted successfully.");

        return $this->returnToIndexRoute();
    }


    /**
     * Returns data for the index view.
     *
     * @return array
     */
    public function getIndexViewData()
    {
        return [
            $this->getIndexViewDataKey() => $this->getModelName()::all(),
        ];
    }

    /**
     * Returns additional data for the create view.
     *
     * @return array
     */
    public function getCreateViewAdditionalData()
    {
        return [];
    }

    /**
     * Returns data for the single view.
     *
     * @return array
     */
    public function getSingleViewAdditionalData()
    {
        return [];
    }

    /**
     * Returns additional data for the edit view.
     *
     * @return array
     */
    public function getEditViewAdditionalData()
    {
        return [];
    }

    /**
     * Prepares data for storage.
     *
     * @param  Request $request
     * @param  Model|null  $model
     *
     * @return array
     */
    protected function prepareDataForStore($request, $model = null)
    {
        return [];
    }

    /**
     * Prepares Data for Update.
     *
     * @param  Request $request
     * @param  Model|null  $model
     *
     * @return array
     */
    protected function prepareDataForUpdate($request, $model = null)
    {
        return [];
    }

    /**
     * Returns the name of the key for index view data.
     *
     * @return string|null
     */
    public function getIndexViewDataKey()
    {
        return $this->getModuleName();
    }

    /**
     * Returns the key name for the create view data.
     *
     * @return string
     */
    public function getCreateViewDataKey()
    {
        return $this->getSingularModuleName();
    }

    /**
     * Returns the key name for the single view data.
     *
     * @return string
     */
    public function getSingleViewDataKey()
    {
        return $this->getSingularModuleName();
    }

    /**
     * Returns the key name for the edit view data.
     *
     * @return string
     */
    public function getEditViewDataKey()
    {
        return $this->getSingularModuleName();
    }


    /**
     * Returns module name.
     *
     * @return string|null
     */
    public function getModuleName()
    {
        return $this->moduleName ?? $this->resolveModuleNameFromController();
    }

    /**
     * Returns singular module name.
     *
     * @return string
     */
    public function getSingularModuleName()
    {
        return Str::singular($this->getModuleName());
    }

    /**
     * Returns Model name.
     *
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName ?? "{$this->getNamespace()}Models\\{$this->resolveModelNameFromController()}";
    }

    /**
     * Returns Repository name.
     *
     * @return string
     */
    public function getRepositoryName()
    {
        return "{$this->getNamespace()}Repositories\\{$this->resolveModelNameFromController()}Repository";
    }

    /**
     * Returns FormRequest instance.
     *
     * @param  string $action
     *
     * @return  FormRequest
     */
    public function validateFormRequest(string $action)
    {
        $requestClass = $this->getNamespace() . "Http\Requests\Admin\\" . Str::ucfirst($action) . $this->resolveModelNameFromController() . "Request";

        if (!class_exists($requestClass)) {
            $requestClass = $this->getNamespace() . "Http\Requests\Admin\\" . $this->resolveModelNameFromController() . "FormRequest";
        }

        if (!class_exists($requestClass)) {
            $requestClass = $this->getNamespace() . "Http\Requests\Admin\\" . $this->resolveModelNameFromController() . "Request";
        }

        return \app($requestClass);
    }

    /**
     * Resolves module name from controller.
     *
     * @return string
     */
    protected function resolveModuleNameFromController()
    {
        return Str::snake(Str::plural(str_replace('Controller', '', \class_basename(static::class))));
    }

    /**
     * Resolves model name from controller.
     *
     * @return string
     */
    protected function resolveModelNameFromController()
    {
        return \str_replace('Controller', '', \class_basename(static::class));
    }

    /**
     * Returns Lego set key.
     *
     * @return string
     */
    protected function getLegoSet()
    {
        return $this->legoSet ? $this->legoSet : ($this->legoSet = $this->resolveSetNameFromLegoSetsRepository()) ? $this->legoSet :
            'legocms';
    }

    /**
     * Resolves Lego set Key.
     *
     * @return string
     */
    private function resolveSetNameFromLegoSetsRepository()
    {
        return LegoCMS::all()->search(function (LegoSet $legoSet) {
            return $legoSet->getNamespace() == $this->getNamespace();
        });
    }

    /**
     * Returns Namespace.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return $this->namespace ? $this->namespace : $this->resolveNameSpace();
    }

    /**
     * Resolves Namespace.
     *
     * @return string
     */
    protected function resolveNameSpace()
    {
        return \str_replace("Http\Controllers\Admin\\" . \class_basename(static::class), "", static::class);
    }
}
