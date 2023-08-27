<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WCCredential;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'page' => $request->page ?? 1,
            'per_page' => $request->size ?? 10,
        ];

        $products = $this->getProducts($params);

        return $products;
    }

    private function getProducts($params) {
        $credentials = auth()->user()->getWCCredentials()["wc_credentials"];
        $products = Http::withBasicAuth($credentials["username"], $credentials["password"])
            ->get($credentials["url"].'/wp-json/wc/v3/products', $params)
            ->json();

        $products = $this->buildProducts($products);

        return response()->json($products);
    }

    private function buildProducts($external_products)
    {
        return array_map(
            function($item)
            {
                return $this->buildProduct($item);
            },
            $external_products
        );
    }

    private function buildProduct($external_product)
    {
        $product = [
            'id' => $external_product["id"],
            'name' => $external_product["name"],
            'price' => $external_product["price"],
            'image_url' => $external_product["images"][0]["src"],
            'regular_price' => $external_product['regular_price'],
            'permalink' => $external_product["permalink"],
            'catalog_visibility' => $external_product["catalog_visibility"],
            'stock_quantity' => $external_product["stock_quantity"],
            'stock_status' => $external_product['stock_status']
        ];

        if($external_product['variations']){
            $external_variations = $this->getVariations($external_product['id']);
            $variations = array_map(
                fn ($variation) => $this->buildVariation($variation), 
                $external_variations
            );
            $product['variations'] = $variations;
        }

        return $product;
    }


    private function getVariations($product_id) {
        $credentials = auth()->user()->getWCCredentials()["wc_credentials"];
        
        $variants = Http::withBasicAuth($credentials["username"], $credentials["password"])
        ->get($credentials["url"].'/wp-json/wc/v3/products/'.$product_id.'/variations')
        ->json();
        return $variants;
    }

    private function buildVariation($external_variation)
    {
        $variation = [
            'id' => $external_variation["id"],
            'price' => $external_variation["price"],
            'regular_price' => $external_variation['regular_price'],
            'image_url' => $external_variation['image']['src'],
            'permalink' => $external_variation["permalink"],
            'attributes' => $external_variation["attributes"],
            'stock_quantity' => $external_variation["stock_quantity"],
            'stock_status' => $external_variation['stock_status']
        ];
        return $variation;
    }
}
