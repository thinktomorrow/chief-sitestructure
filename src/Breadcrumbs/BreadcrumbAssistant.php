<?php  declare(strict_types = 1);

namespace Thinktomorrow\ChiefSitestructure\Breadcrumbs;

use Illuminate\Http\Request;
use Thinktomorrow\Chief\Fields\Fields;
use Thinktomorrow\Chief\Urls\UrlHelper;
use Thinktomorrow\Chief\Management\Manager;
use Thinktomorrow\Chief\Fields\Types\SelectField;
use Thinktomorrow\ChiefSitestructure\SiteStructure;
use Thinktomorrow\Chief\Management\Assistants\Assistant;
use Thinktomorrow\ChiefSitestructure\Breadcrumbs\Breadcrumbs;

class BreadcrumbAssistant implements Assistant
{
    private $manager;

    private $model;

    public function manager(Manager $manager)
    {
        $this->manager  = $manager;

        $this->model = $manager->model();
    }

    public static function key(): string
    {
        return 'breadcrumbs';
    }

    public function route($verb): ?string
    {
        return null;
    }

    public function fields(): Fields
    {
        return new Fields([
            SelectField::make('parent_page')
                ->options(UrlHelper::allModelsWithoutSelf($this->model))
                ->selected(app(Breadcrumbs::class)->getParentForPage($this->model))
                ->grouped()
                ->label('De pagina waar deze pagina onder hoort.'),
        ]);
    }

    public function saveParentPageField($field, Request $request)
    {
        if ($request->has('parent_page')) {
            app(SiteStructure::class)->save($this->model->flatreference()->get(), $request->input('parent_page'));
        }
    }

    public function can($verb): bool
    {
        return true;
    }

    public function guard($verb): Assistant
    {
        return $this;
    }
}
