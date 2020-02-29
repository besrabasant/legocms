<?php

namespace LegoCMS\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use LegoCMS\Http\View\Composers\CurrentUser;
use LegoCMS\Services\View\PageService;
use LegoCMS\Services\View\MenuService;
use LegoCMS\Services\View\FormService;
use BladeSvg\BladeSvgServiceProvider;
use LegoCMS\Services\LegoSet;
use LegoCMS\Services\View\ListingsService;
use LegoCMS\Support\Facades\LegoCMS;
use Illuminate\Support\Facades\Blade;

/**
 * Class ViewServiceProvider
 *
 * @category ServiceProviders
 * @package  LegoCMS\Providers
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Providers/ViewServiceProvider.php
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Registers application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->registerBladeSvg();

        $this->app->singleton(MenuService::class);
        $this->app->singleton(PageService::class);
        $this->app->singleton(FormService::class);
        $this->app->singleton(ListingsService::class);

        $this->app->alias(MenuService::class, 'legocms::services.menu');
        $this->app->alias(PageService::class, 'legocms::services.page');
        $this->app->alias(FormService::class, 'legocms::services.forms');
        $this->app->alias(ListingsService::class, 'legocms::services.listings');
    }


    /**
     * Boots application services.
     *
     * @return  void
     */
    public function boot()
    {
        $this->registerViews();

        $this->registerLegoSetsViews();

        $this->registerBladeDirectives();

        $this->registerViewComposers();
    }

    /**
     * Register Blade Svg.
     *
     * @return  void
     */
    private function registerBladeSvg()
    {
        \config(['blade-svg.svg_path' => 'resources/icons']);
        \config(['blade-svg.spritesheet_path' => 'public/assets/admin/icons/sprite.svg']);
        \config(['blade-svg.sprite_prefix' => 'symbol--']);
        \config(['blade-svg.class' => 'symbol']);
        \config(['blade-svg.inline' => false]);

        $this->app->register(BladeSvgServiceProvider::class);
    }

    /**
     * Registers views.
     *
     * @return  void
     */
    protected function registerViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'legocms');
    }


    /**
     * Register Lego sets views.
     *
     * @return  void
     */
    protected function registerLegoSetsViews()
    {
        $legoSets = LegoCMS::all();

        $legoSets->each(function (LegoSet $legoSet, string $legoSetKey) {

            $views_path = $legoSet->hasViewsPath() ? $legoSet->getViewsPath() :
                $legoSet->getPackageRoot() . "resources/views";

            $this->loadViewsFrom($views_path, $legoSetKey);
        });
    }

    /**
     * Registes View Composers.
     *
     * @return void
     */
    protected function registerViewComposers()
    {
        View::composer(['legocms::*'], CurrentUser::class);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('formField', function ($expression) {
            return $this->includeView('partials.form.', $expression);
        });
    }

    /**
     * @param string $view
     * @param string $expression
     * @return string
     */
    private function includeView($view, $expression)
    {
        list($name) = str_getcsv($expression, ',', '\'');

        if (\view()->exists('admin.' . $view . $name)) {
            $partialNamespace  = 'admin.' . $view;
        } else {
            $partialNamespace = 'legocms::admin.form.';
        }

        $view = $partialNamespace . $name;

        if (!\view()->exists($view)) {

            $legoSets = LegoCMS::all();

            foreach ($legoSets as $legoSetKey => $legoSet) {
                if (\view()->exists($legoSetKey . '::admin.form.' . $name)) {
                    $view = $legoSetKey . '::admin.form.' . $name;
                }
            }
        }

        $expression = explode(',', $expression);
        array_shift($expression);
        $expression = "(" . implode(',', $expression) . ")";
        if ($expression === "()") {
            $expression = '([])';
        }

        return "<?php echo \$__env->make('{$view}', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->with{$expression}->render(); ?>";
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            MenuService::class,
            PageService::class,
            FormService::class,
            ListingsService::class
        ];
    }
}
