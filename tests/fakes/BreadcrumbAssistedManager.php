<?php

declare(strict_types = 1);

namespace Thinktomorrow\ChiefSitestructure\Tests\Fakes;

use Thinktomorrow\Chief\Fields\Fields;
use Thinktomorrow\Chief\Pages\PageManager;
use Thinktomorrow\Chief\Fields\Types\InputField;
use Thinktomorrow\Chief\Management\Assistants\UrlAssistant;
use Thinktomorrow\Chief\Management\Assistants\ArchiveAssistant;
use Thinktomorrow\Chief\Management\Assistants\PublishAssistant;
use Thinktomorrow\ChiefSitestructure\Breadcrumbs\BreadCrumbAssistant;

class BreadcrumbAssistedManager extends PageManager
{
    protected $assistants = [
        UrlAssistant::class,
        ArchiveAssistant::class,
        PublishAssistant::class,
        BreadCrumbAssistant::class
    ];
}
