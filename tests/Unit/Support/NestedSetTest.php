<?php

namespace LegoCMS\Tests\Unit\Support;

use LegoCMS\Support\NestedSet;
use LegoCMS\Tests\Unit\TestCase;

class NestedSetTest extends TestCase
{
    /**
     * @test
     */
    public function testItemsAreAddedToCollection()
    {
        $collection = new NestedSet();

        $item1 = [
            'key' => '1',
            'parent' => 'root'
        ];

        $collection->add($item1);

        $this->assertTrue($collection->isNotEmpty());

        $this->assertEquals($item1, $collection->firstWhere('key', '1'));
    }

    /**
     * @test
     */
    public function testParentIsSetToRootIfParentNotProvided()
    {
        $collection = new NestedSet();

        $item1 = [
            'key' => '1'
        ];

        $collection->add($item1);

        $this->assertEquals('root', $collection->firstWhere('key', '1')['parent']);
    }

    /**
     * @test
     */
    public function testDirectChildrenItemsCanBeFound()
    {
        $items = [
            ['key' => '1'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
        ];

        $expected = [
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1']
        ];

        $collection = new NestedSet();

        foreach ($items as $item) {
            $collection->add($item);
        }

        $resultWithKey = $collection->children('1');
        $resultWithItem = $collection->children($items[0]);

        foreach ($expected as $item) {
            $this->assertContains($item, $resultWithKey->toArray());
            $this->assertContains($item, $resultWithItem->toArray());
        }
    }

    /**
     * @test
     */
    public function testParentOfItemCanBeFound()
    {
        $items = [
            ['key' => '1'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
            ['key' => '4', 'parent' => '2'],
            ['key' => '5', 'parent' => '3'],
            ['key' => '6', 'parent' => '5'],
            ['key' => '7', 'parent' => '6'],
        ];

        $expected = ['key' => '2', 'parent' => '1'];

        $collection = new NestedSet();

        foreach ($items as $item) {
            $collection->add($item);
        }

        $resultWithKey = $collection->parent('4');
        $resultWithItem = $collection->parent($items[3]);

        $this->assertEquals($expected, $resultWithKey->toArray());
        $this->assertEquals($expected, $resultWithItem->toArray());
    }



    /**
     * @test
     */
    public function testSiblingsItemsWithoutSelfIncludedCanBeFound()
    {
        $items = [
            ['key' => '1'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
        ];

        $expectedWithoutself = [
            ['key' => '3', 'parent' => '1']
        ];

        $collection = new NestedSet();

        foreach ($items as $item) {
            $collection->add($item);
        }

        $resultWithoutSelfInclude = $collection->siblings('2');

        foreach ($expectedWithoutself as $item) {
            $this->assertContains($item, $resultWithoutSelfInclude->toArray());
        }

        $this->assertEquals(count($expectedWithoutself), $resultWithoutSelfInclude->count());
    }

    /**
     * @test
     */
    public function testSiblingsItemsWithSelfIncludedCanBeFound()
    {
        $items = [
            ['key' => '1'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
        ];

        $expectedWithself = [
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1']
        ];

        $collection = new NestedSet();

        foreach ($items as $item) {
            $collection->add($item);
        }

        $resultWithSelfInclude = $collection->siblings($items[1], true);

        foreach ($expectedWithself as $item) {
            $this->assertContains($item, $resultWithSelfInclude->toArray());
        }

        $this->assertEquals(count($expectedWithself), $resultWithSelfInclude->count());
    }

    /**
     * @test
     */
    public function testAllDecendantsCanBeFound()
    {
        $items = [
            ['key' => '1'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
            ['key' => '4', 'parent' => '2'],
            ['key' => '5', 'parent' => '3'],
            ['key' => '6', 'parent' => '5'],
            ['key' => '7', 'parent' => '6'],
        ];

        $expected = [
            ['key' => '5', 'parent' => '3'],
            ['key' => '6', 'parent' => '5'],
            ['key' => '7', 'parent' => '6'],
        ];

        $collection = new NestedSet();

        foreach ($items as $item) {
            $collection->add($item);
        }

        $result = $collection->decendants('3');

        foreach ($expected as $item) {
            $this->assertContains($item, $result->toArray());
        }

        $this->assertEquals(count($expected), $result->count());
    }

    /**
     * @test
     */
    public function testAllAncenstorsCanBeFound()
    {
        $items = [
            ['key' => '1'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
            ['key' => '4', 'parent' => '2'],
            ['key' => '5', 'parent' => '3'],
            ['key' => '6', 'parent' => '5'],
            ['key' => '7', 'parent' => '6'],
        ];

        $expected = [
            ['key' => '1', 'parent' => 'root'],
            ['key' => '2', 'parent' => '1'],
            ['key' => '3', 'parent' => '1'],
            ['key' => '5', 'parent' => '3'],
            ['key' => '6', 'parent' => '5'],
        ];

        $collection = new NestedSet();

        foreach ($items as $item) {
            $collection->add($item);
        }

        $result = $collection->ancestors('7');


        foreach ($expected as $item) {
            $this->assertContains($item, $result->toArray());
        }

        $this->assertEquals(count($expected), $result->count());
    }
}
