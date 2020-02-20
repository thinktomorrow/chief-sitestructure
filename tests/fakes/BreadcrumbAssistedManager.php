<?php declare(strict_types = 1);

namespace Thinktomorrow\ChiefSitestructure\Tests\Fakes;

use Thinktomorrow\Chief\Pages\PageManager;
use Thinktomorrow\Chief\Management\Assistants\UrlAssistant;
use Thinktomorrow\Chief\Management\Assistants\ArchiveAssistant;
use Thinktomorrow\Chief\Management\Assistants\PublishAssistant;
use Thinktomorrow\ChiefSitestructure\Breadcrumbs\BreadcrumbAssistant;

class BreadcrumbAssistedManager extends PageManager
{
    protected $assistants = [
        UrlAssistant::class,
        ArchiveAssistant::class,
        PublishAssistant::class,
        BreadcrumbAssistant::class
    ];
}
