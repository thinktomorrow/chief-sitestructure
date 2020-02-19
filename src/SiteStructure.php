<?php declare(strict_types = 1);

namespace Thinktomorrow\ChiefSitestructure;

use Vine\NodeCollection;
use Vine\Sources\ArraySource;
use Illuminate\Support\Facades\DB;
use Thinktomorrow\Chief\FlatReferences\FlatReferenceFactory;

class SiteStructure
{
    private $collection;

    public function __construct()
    {
        $this->collection = $this->buildCollection();
    }

    public function save(string $child_reference, ?string $parent_reference = null)
    {
        //call the flatrefencefactory to check for valid references. Maybe not needed?
        $parent_reference ? FlatReferenceFactory::fromString($parent_reference) : '';
        FlatReferenceFactory::fromString($child_reference);

        $parent = DB::table('site_structure')->where('reference', $parent_reference)->get();
        $parent_id = null;

        if($parent->isEmpty() && $parent_reference){
            $parent_id = DB::table('site_structure')->insertGetId(['reference' => $parent_reference]);
        }elseif($parent_reference){
            $parent_id = $parent->first()->id;
        }


        DB::table('site_structure')->updateOrInsert(['reference' => $child_reference], ['parent_id' => $parent_id]);
    }

    public function get()
    {
        return $this->collection;
    }

    private function buildCollection()
    {
        $source = DB::table('site_structure')->get()->toArray();

        $source = $this->mapExtraFields($source);

        return NodeCollection::fromSource(new ArraySource($source));
    }

    private function mapExtraFields(array $source)
    {
        $source = collect($source)->map(function($entry){
            $model = FlatReferenceFactory::fromString($entry->reference)->instance();
            $entry->url = $model->url();
            $entry->label = $model->title;
            $entry->online = $model->isPublished();
            return $entry;
        })->toArray();

        return $source;
    }

    public function getForReference(string $reference)
    {
        return $this->collection->shake(function($node) use($reference){
            return $node->reference == $reference;
        });
    }
}
