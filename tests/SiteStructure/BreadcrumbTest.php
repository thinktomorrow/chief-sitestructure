<?php

namespace Thinktomorrow\ChiefSitestructure\Tests\SiteStructure;

use Illuminate\Support\Collection;
use Thinktomorrow\Chief\Pages\Single;
use Thinktomorrow\ChiefSitestructure\SiteStructure;
use Thinktomorrow\ChiefSitestructure\Tests\TestCase;
use Thinktomorrow\ChiefSitestructure\Breadcrumbs\Breadcrumbs;

class BreadcrumbTest extends TestCase
{

    /** @test */
    public function it_can_get_the_breadcrumb_for_current_page()
    {
        $top    = Single::create(['title' => 'top', 'published' => true]);
        $single = Single::create(['title' => 'top2', 'published' => true]);
        $page   = Single::create(['title' => 'sub', 'published' => true]);

        app(SiteStructure::class)->save($single->flatreference());
        app(SiteStructure::class)->save($page->flatreference(), $top->flatreference());

        $breadcrumb = Breadcrumbs::getForPage($page);

        $this->assertCount(2, $breadcrumb);
        $this->assertEquals('top', $breadcrumb->first()->label);
        $this->assertEquals('sub', $breadcrumb->last()->label);
    }

    /** @test */
    public function an_offline_page_can_be_identified_in_the_structure()
    {
        $top = Single::create(['title' => 'top', 'published' => false]);
        $single = Single::create(['title' => 'top2', 'published' => true]);
        $page = Single::create(['title' => 'sub', 'published' => true]);

        app(SiteStructure::class)->save($single->flatreference());
        app(SiteStructure::class)->save($page->flatreference(), $top->flatreference());

        $breadcrumb = Breadcrumbs::getForPage($page);

        $this->assertCount(1, $breadcrumb);
    }

    /** @test */
    public function helper_returns_structure_by_page()
    {
        $top    = Single::create(['title' => 'top', 'published' => true]);
        $single = Single::create(['title' => 'top2', 'published' => true]);
        $page   = Single::create(['title' => 'sub', 'published' => true]);

        app(SiteStructure::class)->save($single->flatreference());
        app(SiteStructure::class)->save($page->flatreference(), $top->flatreference());

        $breadcrumbs = breadcrumbs($page);

        $this->assertInstanceOf(Collection::class, $breadcrumbs);
        $this->assertCount(2, $breadcrumbs);
    }
}
