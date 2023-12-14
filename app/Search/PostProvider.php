<?php

namespace App\Search;

use App\Models\Post;
use Illuminate\Support\Collection;
use Statamic\Search\Searchables\Provider;

class PostProvider extends Provider
{
    /**
     * The handle used within search configs.
     *
     * e.g. For 'searchables' => ['collection:blog', 'products:hats', 'users']
     *      they'd be 'collection', 'products', and 'users'.
     */
    protected static $handle = 'posts';

    /**
     * The prefix used in each Searchable's reference.
     *
     * e.g. For 'entry::123', it would be 'entry'.
     */
    protected static $referencePrefix = 'post';

    /**
     * Convert an array of keys to the actual objects.
     * The keys will be searchable references with the prefix removed.
     */
    public function find(array $keys): Collection
    {
        return Post::find($keys);
    }

    /**
     * Get a collection of all searchables.
     */
    public function provide(): Collection
    {
        return Post::all();

        // If you wanted to allow subsets of products, you could specify them in your
        // config then retrieve them appropriately here using keys.
        // e.g. 'searchables' => ['products:hats', 'products:shoes'],
        // $this->keys would be ['keys', 'hats'].
        // return Post::whereIn('type', $this->keys)->get();
    }

    /**
     * Check if a given object belongs to this provider.
     */
    public function contains($searchable): bool
    {
        return $searchable instanceof Post;
    }
}
