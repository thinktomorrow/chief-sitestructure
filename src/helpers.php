<?php

use Thinktomorrow\Chief\Pages\Page;
use Thinktomorrow\ChiefSitestructure\Breadcrumbs\Breadcrumbs;

if (!function_exists('breadcrumbs')) {
    function breadcrumbs(Page $page)
    {
        $breadcrumbs = app(Breadcrumbs::class)->getForPage($page);

        return $breadcrumbs;
    }
}
