<?php

namespace Thinktomorrow\ChiefSitestructure\Tests\SiteStructure;

use Vine\NodeCollection;
use Illuminate\Support\Arr;
use Thinktomorrow\Chief\Pages\Single;
use Thinktomorrow\Chief\Urls\UrlRecord;
use Thinktomorrow\Chief\Management\Register;
use Thinktomorrow\Chief\States\PageState;
use Illuminate\Foundation\Exceptions\Handler;
use Thinktomorrow\ChiefSitestructure\SiteStructure;
use Thinktomorrow\ChiefSitestructure\Tests\TestCase;
use Thinktomorrow\ChiefSitestructure\Tests\Fakes\BreadcrumbAssistedManager;

class SiteStructureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDefaultAuthorization();
        app()->setLocale('nl');
        app(Register::class)->register(BreadcrumbAssistedManager::class, Single::class);

        // Create a dummy page up front based on the expected validPageParams
        $this->page = Single::create([
            'title:nl' => 'new title',
            'title:en' => 'nouveau title',
        ]);

        UrlRecord::create([
            'locale' => 'nl',  'slug' => 'new-slug', 'model_type' => $this->page->getMorphClass(), 'model_id' => $this->page->id,
        ]);

        UrlRecord::create([
            'locale' => 'en',  'slug' => 'nouveau-slug', 'model_type' => $this->page->getMorphClass(), 'model_id' => $this->page->id,
        ]);
    }

    /** @test */
    public function it_can_save_a_page_in_the_site_structure()
    {
        app(SiteStructure::class)->save($this->page->flatreference()->get());

        $structure = app(SiteStructure::class)->get();

        $this->assertInstanceOf(NodeCollection::class, $structure);
        $this->assertCount(1, $structure);
    }

    /** @test */
    public function it_can_use_an_existing_page_in_the_site_structure()
    {
        app(SiteStructure::class)->save($this->page->flatreference()->get());
        $extra_page = Single::create(['title' => 'top page', 'current_state' => PageState::PUBLISHED]);

        app(SiteStructure::class)->save($extra_page->flatreference()->get(), $this->page->flatreference()->get());

        $structure = app(SiteStructure::class)->get();

        $this->assertInstanceOf(NodeCollection::class, $structure);
        $this->assertCount(1, $structure);
    }

    /** @test */
    public function saving_a_page_triggers_site_structure_save()
    {
        $this->disableExceptionHandling();
        $extra_page = Single::create(['title' => 'top page', 'current_state' => PageState::PUBLISHED]);
        $response = $this->asAdmin()
            ->put(route('chief.back.managers.update', ['singles', $this->page->id]), $this->validUpdatePageParams([
                'parent_page' => $extra_page->flatreference()->get()
            ]));
        $response->assertStatus(302);

        $structure = app(SiteStructure::class)->get();

        $this->assertInstanceOf(NodeCollection::class, $structure);
        $this->assertCount(1, $structure);
    }

    protected function validUpdatePageParams($overrides = [])
    {
        $params = [
            'trans' => [
                'nl' => [
                    'title' => 'aangepaste title',
                    'seo_title' => 'aangepaste seo title',
                    'seo_description' => 'aangepaste seo description',
                    'seo_keywords' => 'aangepaste seo keywords',
                ],
                'en' => [
                    'title' => 'updated title',
                    'seo_title' => 'updated seo title',
                    'seo_description' => 'updated seo description',
                    'seo_keywords' => 'updated seo keywords',
                ],
            ],
            'url-slugs' => [
                'nl' => 'aangepaste-slug',
                'en' => 'updated-slug',
            ],
            'relations' => [],
        ];

        foreach ($overrides as $key => $value) {
            Arr::set($params, $key, $value);
        }

        return $params;
    }
}
