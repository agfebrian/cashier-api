<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Product;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetProduct()
    {
        $this->json('get', '/api/products', [], [
                'Authorization' => 'Bearer fmebeE1ITb7R6JTHbIfQjT8DtDZZNUcrAP35vHDFMhHPSmtmz2JsRISA4VT6'
            ])
            ->assertStatus(200)
            ->assertJsonStructure([
                'products' => [
                    [
                        'image' => [
                            'id',
                            'url',
                            'imageable_id',
                            'imageable_type',
                            'created_at',
                            'updated_at'
                        ],
                        'id',
                        'product_name',
                        'product_price',
                        'category_id',
                        'created_at',
                        'updated_at',
                        'category' => []
                    ]
                ]
            ]);
    }

    public function testCreateProduct()
    {
        $this->json('post', '/api/products', [
                'product_name' => 'Watermelon Juice',
                'product_price' => 14000,
                'category_id' => 3
            ],
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer fmebeE1ITb7R6JTHbIfQjT8DtDZZNUcrAP35vHDFMhHPSmtmz2JsRISA4VT6'
            ])
            ->assertStatus(200);
    }

    public function testUpdateProduct()
    {
        $product = Product::all()->last();
        $this->json('put', '/api/products/' . $product->id,
            [
                'product_name' => 'Sunkis Juice',
                'product_price' => 15000
            ],
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer fmebeE1ITb7R6JTHbIfQjT8DtDZZNUcrAP35vHDFMhHPSmtmz2JsRISA4VT6'
            ])
            ->assertStatus(200);
    }

    public function testDeleteProduct()
    {
        $product = Product::all()->last();
        $this->json('delete', '/api/products/' . $product->id, [],
            [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer fmebeE1ITb7R6JTHbIfQjT8DtDZZNUcrAP35vHDFMhHPSmtmz2JsRISA4VT6'
            ])
            ->assertStatus(200);
    }
}
