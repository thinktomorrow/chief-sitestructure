<?php declare(strict_types = 1);

namespace Thinktomorrow\ChiefSitestructure\Breadcrumbs;

use Thinktomorrow\Chief\Pages\Page;
use Thinktomorrow\ChiefSitestructure\SiteStructure;

class Breadcrumbs
{
    public static function getFor(string $flatreference)
    {
        return app(SiteStructure::class)->getForReference($flatreference);
    }

    public static function getForPage(Page $page)
    {
        return collect(static::getFor($page->flatreference()->get())->flatten()->all())->reject(function($node){
            return !$node->online;
        });
    }

    public static function getParentForPage(Page $page)
    {
        $structure = collect(static::getFor($page->flatreference()->get())->flatten()->all())->first();

        if($structure) return $structure->reference;

        return null;
    }
}
