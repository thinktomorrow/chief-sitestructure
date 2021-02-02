<?php declare(strict_types = 1);

namespace Thinktomorrow\ChiefSitestructure\Breadcrumbs;

use Vine\NodeCollection;
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
        return collect(static::getFor($page->flatreference()->get())->flatten()->all())->reject(function ($node) {
            return !$node->online;
        });
    }

    public static function getGrandParentForPage(Page $page)
    {
        /** @var NodeCollection $tree */
        $tree = static::getFor($page->flatreference()->get());

        if ($tree->first()) {
            return $tree->first()->reference;
        }

        return null;
    }

    public static function getParentForPage(Page $page)
    {
        /** @var NodeCollection $tree */
        $tree = static::getFor($page->flatreference()->get());

        $page = $tree->find('reference', $page->flatreference()->get());

        if(($page) && $parent = $page->parent()) {
            return $parent->reference;
        }

        return null;
    }
}
