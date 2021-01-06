<?php
defined('BASEPATH') or exit('No direct script access allowed');

class apitest extends CI_Controller
{
    public function read()
    {
        $user = "beratyavuzyigit";
        $pass = "123";
        $base_encode = base64_encode($user . ":" . $pass);
        $headr = array();
        $headr[] = 'Authorization: Basic ' . $base_encode;
        $url = 'http://localhost/rest_api/api/product/1';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_exec($ch);
        curl_close($ch);
    }
    public function create()
    {
        $user = "beratyavuzyigit";
        $pass = "123";
        $base_encode = base64_encode($user . ":" . $pass);
        $headr = array();
        $headr[] = 'Authorization: Basic ' . $base_encode;
        $url = 'http://localhost/rest_api/api/product';
        $product_json = array(
            'product_name' => "URUN_TEST",
            'product_desc' => "restapi post test",
            'img_url' => "urun_resim/test.jpg",
            'product_price' => "20",
            'product_discount' => "0",
            'product_status' => "1",
            'stock_code' => "TEST-002",
        );
        $product_json = json_encode($product_json);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $product_json);
        curl_exec($ch);
        curl_close($ch);
    }
    public function update()
    {
        $user = "beratyavuzyigit";
        $pass = "123";
        $base_encode = base64_encode($user . ":" . $pass);
        $headr = array();
        $headr[] = 'Authorization: Basic ' . $base_encode;
        $url = 'http://localhost/rest_api/api/product';
        $product_json = array(
            'stock_code' => "TEST-001",
            'product_name' => "URUN_TEST",
            'product_desc' => "restapi post test updated",
        );
        $product_json = json_encode($product_json);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $product_json);
        curl_exec($ch);
        curl_close($ch);
    }
    public function delete()
    {
        $user = "beratyavuzyigit";
        $pass = "123";
        $base_encode = base64_encode($user . ":" . $pass);
        $headr = array();
        $headr[] = 'Authorization: Basic ' . $base_encode;
        $url = 'http://localhost/rest_api/api/product/6';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_exec($ch);
        curl_close($ch);
    }
}
