<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WCCredential;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $params = [
            'page' => $request->page ?? 1,
            'per_page' => $request->size ?? 10,
            'order_by' => isset($request->order_by) ? $request->order_by : 'title',
            'order' => isset($request->order) ? $request->order : 'asc',
        ];

        $result = $this->getProducts($params);
        $products = $this->buildProducts($result['products']);
        $pages = $result['pages'];

        return [
            'products' => $products,
            'pages' => $pages
        ];
    }

    public function update(Request $request)
    {
        $this->updateExternalBaseProduct($request->product);
        
        if(isset($request->product['variations'])){
            $this->updateExternalVariations($request->product, $request->modified_variations);
        }

        $updated_product = $this->getProduct($request->product["id"]);

        return response()->json($updated_product);
    }

    private function updateExternalBaseProduct($data)
    {
        $base_product = [
            'id' => $data["id"],
            'name' => $data["name"],
            'sale_price' => $data["sale_price"],
            'regular_price' => $data['regular_price'],
            'catalog_visibility' => $data["catalog_visibility"],
            'stock_quantity' => $data["stock_quantity"],
            'stock_status' => $data['stock_status'],
        ];
        $credentials = auth()->user()->getWCCredentials()["wc_credentials"];

        $result = Http::withBasicAuth($credentials["username"], $credentials["password"])
            ->put($credentials["url"].'/wp-json/wc/v3/products/'.$base_product["id"], $base_product)
            ->json();

        return $result;
    }

    private function updateExternalVariations($product, $modified_variations)
    {
        $variations = array_filter($product['variations'], function($variation) 
            use ($modified_variations)
            {
                return in_array($variation['id'], $modified_variations);
            }
        );

        $credentials = auth()->user()->getWCCredentials()["wc_credentials"];

        $results = Http::pool(function(Pool $pool) 
        use ($product, $variations, $credentials)
        {
            foreach ($variations as $variation) {
                $mapped_variation = [
                    'sale_price' => $variation["sale_price"],
                    'regular_price' => $variation['regular_price'],
                    'stock_quantity' => $variation["stock_quantity"],
                    'stock_status' => $variation['stock_status']
                ];

                $url = $credentials["url"].'/wp-json/wc/v3/products/'.$product["id"]."/".$variation['id'];

                $pool->withBasicAuth($credentials["username"], $credentials["password"])
                    ->put($url, $mapped_variation);
            }
        });
    }

    private function getProducts($params) {
        $credentials = auth()->user()->getWCCredentials()["wc_credentials"];
        $response = Http::withBasicAuth($credentials["username"], $credentials["password"])
            ->get($credentials["url"].'/wp-json/wc/v3/products', $params);

        $products = $response->json();
        $pages = $response->headers()['x-wp-totalpages'][0];

        return [
            'products' => $products,
            'pages' => $pages,
        ];
    }

    private function getProduct($product_id)
    {
        $credentials = auth()->user()->getWCCredentials()["wc_credentials"];
        $product = Http::withBasicAuth($credentials["username"], $credentials["password"])
            ->get($credentials["url"].'/wp-json/wc/v3/products/'.$product_id)
            ->json();

        $product = $this->buildProduct($product);

        return $product;
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
        $product = $this->buildBaseProduct($external_product);

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

    private function buildBaseProduct($base_external_product)
    {
        return [
            'id' => $base_external_product["id"],
            'name' => $base_external_product["name"],
            'sale_price' => $base_external_product["sale_price"],
            'image_url' => $base_external_product["images"][0]["src"],
            'regular_price' => $base_external_product['regular_price'],
            'permalink' => $base_external_product["permalink"],
            'catalog_visibility' => $base_external_product["catalog_visibility"],
            'stock_quantity' => $base_external_product["stock_quantity"],
            'stock_status' => $base_external_product['stock_status']
        ];
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
            'sale_price' => $external_variation["sale_price"],
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
