<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Statamic\Contracts\Data\Augmentable;
use Statamic\Contracts\Data\Augmented;
use Statamic\Contracts\Query\ContainsQueryableValues;
use Statamic\Contracts\Search\Result as ResultContract;
use Statamic\Contracts\Search\Searchable as SearchableContract;
use Statamic\Data\AugmentedData;
use Statamic\Fields\Value;
use Statamic\Search\Result;
use Statamic\Search\Searchable;

class Post extends Model implements Augmentable, ContainsQueryableValues, SearchableContract
{
    use HasFactory, Searchable;

    protected $fillable = ['title', 'slug'];

    /**
     * The identifier that will be used in search indexes.
     */
    public function getSearchReference(): string
    {
        return 'post::'.$this->id;
    }

    /**
     * The indexed value for a given field.
     */
    public function getSearchValue(string $field)
    {
        return $this->$field;
    }

    /**
     * Convert to a search result class.
     * You can use the Result class, or feel free to create your own.
     */
    public function toSearchResult(): ResultContract
    {
        return new Result($this, 'product');
    }

    public function getQueryableValue(string $field)
    {
        return $this->$field;
    }

    public function augmentedValue($key)
    {
        return $this->augmented()->get($key);
    }

    public function toAugmentedCollection($keys = null)
    {
        return $this->augmented()
            ->withRelations($this->defaultAugmentedRelations())
            ->select($keys ?? $this->defaultAugmentedArrayKeys());
    }

    public function toAugmentedArray($keys = null)
    {
        return $this->toAugmentedCollection($keys)->all();
    }

    public function toShallowAugmentedCollection()
    {
        return $this->augmented()->select($this->shallowAugmentedArrayKeys())->withShallowNesting();
    }

    public function toShallowAugmentedArray()
    {
        return $this->toShallowAugmentedCollection()->all();
    }

    public function augmented()
    {
        return $this->newAugmentedInstance();
    }

    protected function defaultAugmentedArrayKeys()
    {
        return null;
    }

    public function shallowAugmentedArrayKeys()
    {
        return ['id', 'title', 'api_url'];
    }

    protected function defaultAugmentedRelations()
    {
        return [];
    }

    public function toEvaluatedAugmentedArray($keys = null)
    {
        $collection = $this->toAugmentedCollection($keys);

        // Can't just chain ->except() because it would return a new
        // collection and the existing 'withRelations' would be lost.
        if ($exceptions = $this->excludedEvaluatedAugmentedArrayKeys()) {
            $collection = $collection
                ->except($exceptions)
                ->withRelations($collection->getRelations());
        }

        return $collection->withEvaluation()->toArray();
    }

    protected function excludedEvaluatedAugmentedArrayKeys()
    {
        return null;
    }

    public function newAugmentedInstance(): Augmented
    {
        return new AugmentedData($this, $this->augmentedArrayData());
    }

    public function augmentedArrayData()
    {
        return method_exists($this, 'values') ? $this->values() : $this->toArray();
    }
}
