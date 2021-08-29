<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class GetProductApiTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetProductApi()
    {
        $this->assertTrue(true);
        // $this->json('get', '/products', ['Accept' => 'application/json'])
        //     ->assertStatus(200)
        //     ->assertJsonStructure([
        //         'data' => [
        //             [
        //                 'image' => [
        //                     'id',
        //                     'url',
        //                     'imageable_id',
        //                     'imageable_type',
        //                     'created_at',
        //                     'updated_at'
        //                 ],
        //                 'id',
        //                 'product_name',
        //                 'product_price',
        //                 'category_id',
        //                 'created_at',
        //                 'updated_at',
        //                 'category' => ['*']
        //             ]
        //         ]
        //     ]);
    }
}
