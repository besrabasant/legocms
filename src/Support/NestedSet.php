<?php

namespace LegoCMS\Support;

use Illuminate\Support\Collection;

/**
 * Class NestedSet
 *
 * @package  LegoCMS\Support
 * @category Utililites
 * @author   Basant Besra <besrabasant@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/besrabasant/legocms/blob/master/src/Support/NestedSet.php
 */
class NestedSet extends Collection
{
    /**
     * Add an item to the collection.
     *
     * @param  mixed  $item
     *
     * @return $this
     */
    public function add($item)
    {
        if (!\array_key_exists('parent', $item)) {
            $item['parent'] = 'root';
        };

        return parent::add($item);
    }

    /**
     * Returns children of an item.
     *
     * @param  mixed  $item
     *
     * @return  static
     */
    public function children($item)
    {
        if (\is_array($item)) {
            $item = $item['key'];
        }

        $children = $this->where('parent', $item);

        return new static($children->sortKeys());
    }

    /**
     * Returns parent of an item.
     *
     * @param  mixed  $item
     *
     * @return  static
     */
    public function parent($item)
    {
        if (\is_string($item) || \is_int($item)) {
            $item = $this->firstWhere('key', $item);
        }

        if ($item['parent'] === 'root') {
            return new static([]);
        }

        return new static($this->firstWhere('key', $item['parent']));
    }

    /**
     * Returns siblings of an item.
     *
     * @param  mixed  $item
     * @param  bool  $includeSelf
     *
     * @return  static
     */
    public function siblings($item, $includeSelf = false)
    {
        if (\is_string($item) || \is_int($item)) {
            $item = $this->firstWhere('key', $item);
        }

        $result = $this->where('parent', $item['parent']);

        if ($includeSelf === false) {
            $result = $result->reject(function ($resultItem) use ($item) {
                return $resultItem['key'] == $item['key'];
            });
        }

        return new static($result->sortKeys());
    }

    /**
     * Returns all decendants of an item.
     *
     * @param  mixed  $item
     *
     * @return  static
     */
    public function decendants($item)
    {
        $children = $this->children($item)->sort();

        $children->each(function ($child) use ($children) {
            $subChildren = $this->decendants($child);

            if ($subChildren->isNotEmpty()) {
                $subChildren->each(function ($subChild) use ($children) {
                    $children->push($subChild);
                });
            }
        });

        return new static($children);
    }

    /**
     * Returns all ancestors of an item.
     *
     * @param  mixed  $item
     *
     * @return  static
     */
    public function ancestors($item)
    {
        $parent = $this->parent($item);

        if ($parent->isEmpty()) {
            return new static([]);
        }

        $parentSiblings = $this->siblings($parent, true);

        $parentSiblings->each(function ($sibling) use ($parentSiblings) {
            if ($sibling['parent'] != 'root') {
                $ancestors = $this->ancestors($sibling);

                if ($ancestors->isNotEmpty()) {
                    $ancestors->each(function ($ancestor, $key) use ($parentSiblings) {
                        if ($parentSiblings->search($ancestor) == false) {
                            $parentSiblings->put($key, $ancestor);
                        }
                    });
                }
            }
        });

        return new static($parentSiblings->sortKeys());
    }
}
