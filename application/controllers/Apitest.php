<?php
defined('BASEPATH') or exit('No direct script access allowed');

class apitest extends CI_Controller
{

    public function index(){
        echo "s";
    }
    /*
        Welcome xCommerce RESTful API Test

        Allowed HTTP Methods  --> [GET, POST, PATCH, DELETE, OPTIONS]
        Authentication Method --> Basic Auth

        All methods need these variables --> [$user , $pass , $url , $method]
   


        
        <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>




        RESTful API Get Product info.
        HTTP Method        --> GET
        -----------------------------------------------------------------------------
        _URL_/api/{table_name}                    --> Gel all table info.
        _URL_/api/{table_name}/{id}               --> Get product info by id
        _URL_/api/{table_name}/{id}/{column_name} --> Get product {column_name} info by id 
    */
    public function read()
    {
        $user = "beratyavuzyigit";                        // Basic Auth Username
        $pass = "123";                                    // Basic Auth Password
        $url = 'http://localhost/rest_api/api/products/1/product_name';  // Request Url
        $method = "GET";                                  // Set HTTP Method
        $this->curl($user, $pass, $url, $method);         // cURL func.
    }


    /*
    RESTful API Create New Product
    HTTP Method             --> POST
    _URL_/api/{table_name}/ --> defined URL
    --------------------------------------
        ***  products collumns  ***
        product_name     => required
        product_desc     => required
        img_url          => required
        product_price    => required
        product_discount => default "0"
        product_status   => required
        stock_code       => required
    --------------------------------------
    */
    public function create()
    {
        /* Product Columns */
        $product_json = array(
            'product_name' => "URUN_TEST",
            'product_desc' => "restapi post test",
            'img_url' => "urun_resim/test.jpg",
            'product_price' => "20",
            'product_discount' => "0",
            'product_status' => "1",
            'stock_code' => "TEST-004",
        );
        $product_json = json_encode($product_json);                // Array to JSON Func.

        $user = "beratyavuzyigit";                                 // Basic Auth Username
        $pass = "123";                                             // Basic Auth Password
        $url = 'http://localhost/rest_api/api/products';           // Request Url
        $method = "POST";                                          // Set HTTP Method
        $this->curl($user, $pass, $url, $method, $product_json);   // cURL func.
    }


    /*
        RESTful API Update Product
        HTTP Method             --> PATCH
        _URL_/api/{table_name}/ --> defined URL
        --------------------------------------
                ***  collumns  ***
            stock_code       => required
            product_name     => optional
            product_desc     => optional
            img_url          => optional
            product_price    => optional
            product_discount => optional
            product_status   => optional
        --------------------------------------
    */
    public function update()
    {
        /* Product Columns */
        $product_json = array(
            'stock_code' => "TEST-001",
            'product_name' => "URUN_TEST",
            'product_desc' => "restapi post test",
        );
        $product_json = json_encode($product_json);                 // Array to JSON Func.

        $user = "beratyavuzyigit";                                  // Basic Auth Username
        $pass = "123";                                              // Basic Auth Password
        $url = 'http://localhost/rest_api/api/products';            // Request Url
        $method = "PATCH";                                          // Set HTTP Method
        $this->curl($user, $pass, $url, $method, $product_json);    // cURL func.
    }


    /*
        RESTful API Delete Product
        HTTP Method                  --> DELETE
        -----------------------------------------------------------------------------
        _URL_/api/{table_name}/{id}  --> Delete Product by id
    */
    public function delete()
    {
        $user = "beratyavuzyigit";                         // Basic Auth Username
        $pass = "123";                                     // Basic Auth Password
        $url = 'http://localhost/rest_api/api/products/8'; // Request Url
        $method = "DELETE";                                // Set HTTP Method
        $this->curl($user, $pass, $url, $method);          // cURL func.
    }




    /*
        RESTful API cURL Func.
    */
    private function curl($user, $pass, $url, $method, $body = null)
    {
        $base_encoded = base64_encode($user . ":" . $pass); // [USER:PASS] Convert to Basic Auth Format and BASE64 Encode
        $headr = array();                                   // Create Header Array
        $headr[] = 'Authorization: Basic ' . $base_encoded; // Insert Basic Auth Method to Header

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);       // Set Option HTTP Header
        curl_setopt($ch, CURLOPT_URL, $url);                // Set Option cURL URL
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);   // Set Method with Custom Request

        /* Check if exists body */
        if ($body != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        /* Execute and Close cURL */
        curl_exec($ch);
        curl_close($ch);
    }
}
