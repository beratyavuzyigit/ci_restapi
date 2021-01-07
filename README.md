# Codeigniter 3 RESTful API Service

Codeigniter çatısı altında geliştirdiğim ecommerce için REST API örneği
- **Allowed HTTP Methods:** `[GET, POST, PATCH, DELETE, OPTIONS]`
- **Authorization Method:** `Basic Auth`
- **Request Format:** `JSON`
- **Response Format:** `JSON, XML`

## DOSYALAR
#### Controllers
- controller/**Api.php**
- consoller/**Apitest.php**
#### Models
- model/**Restapi_product.php**
- model/**Restapi_authentication.php**
#### Libraries
- library/**Restapi_formatter.php**

## KURULUMU



## KULLANIMI
Kimlik doğrulaması için `username:password` şeklinde bir veri oluşturup bunu BASE64 ile şifrelemelisiniz. Daha sonra HTTP Headers içeriğinde `Authorization: Basic {base64_code}` şeklinde başlık oluşturup istek yollamalısınız.

`CREATE` ve `UPDATE` işlemlerinde gerekli veriyi JSON formatında yollamalısınız. Ayrıca istek attığınız URL'in parametre içermesine gerek yoktur.

PHP için örnek kullanım (cURL):
```php
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
```
#### READ
`READ` işleminde `Body` üzerinden veri yollamanıza gerek yoktur.

Tüm verileri çekmek için `{base_url}/api/product/`

Bir ürüne ait verileri çekmek için `{base_url}/api/product/{id}`

Bir ürüne ait bir sütun verisi çekmek için `{base_url}/api/product/{id}/{column_name}`

PHP için örnek bir kullanım:

```php
/*
    RESTful API Get Product info.
    HTTP Method        --> GET
    -----------------------------------------------------------------------------
    _URL_/api/product                    --> Gel all product info.
    _URL_/api/product/{id}               --> Get product info by id
    _URL_/api/product/{id}/{column_name} --> Get product {column_name} info by id 
*/
public function read()
{
    $user = "beratyavuzyigit";                        // Basic Auth Username
    $pass = "123";                                    // Basic Auth Password
    $url = 'http://localhost/rest_api/api/product/';  // Request Url
    $method = "GET";                                  // Set HTTP Method
    $this->curl($user, $pass, $url, $method);         // cURL func.
}
```

#### CREATE
`CREATE` işleminde, eklenecek olan ürüne ait bilgileri JSON formatında yollamanız gerekir. Veri tabanına iletilecek olan bilgilerden `stock_code` benzersiz olmalıdır.

PHP için örnek bir kullanım:
```php
/*
    RESTful API Create New Product
    HTTP Method        --> POST
    _URL_/api/product/ --> defined URL
    --------------------------------------
            ***  collumns  ***
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
        'stock_code' => "TEST-003",
    );
    $product_json = json_encode($product_json);                // Array to JSON Func.

    $user = "beratyavuzyigit";                                 // Basic Auth Username
    $pass = "123";                                             // Basic Auth Password
    $url = 'http://localhost/rest_api/api/product';            // Request Url
    $method = "POST";                                          // Set HTTP Method
    $this->curl($user, $pass, $url, $method, $product_json);   // cURL func.
}
```

#### UPDATE
`UPDATE` işleminde, `CREATE` işleminde olduğu gibi sadece değiştirilecek olan sütunlar için JSON formatında veri yollamanız gerekir. Değiştirilecek olan ürünün tespiti için `stock_code` sütununun belirtilmesi gerekir.

PHP için örnek bir kullanım:
```php
/*
    RESTful API Update Product
    HTTP Method        --> PATCH
    _URL_/api/product/ --> defined URL
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
    $product_json = json_encode($product_json);                // Array to JSON Func.

    $user = "beratyavuzyigit";                                 // Basic Auth Username
    $pass = "123";                                             // Basic Auth Password
    $url = 'http://localhost/rest_api/api/product';            // Request Url
    $method = "PATCH";                                         // Set HTTP Method
    $this->curl($user, $pass, $url, $method, $product_json);   // cURL func.
}
```
#### DELETE
`DELETE` işleminde, `READ` işleminde olduğu gibi veri yollamanıza gerek yoktur. Yalnızca silinecek olan ürüne ait `id` değerini URL'de belirtmeniz yeterlidir.

PHP için örnek bir kullanım:
````php
/*
    RESTful API Delete Product
    HTTP Method             --> DELETE
    -----------------------------------------------------------------------------
    _URL_/api/product/{id}  --> Delete Product by id
*/
public function delete()
{
    $user = "beratyavuzyigit";                        // Basic Auth Username
    $pass = "123";                                    // Basic Auth Password
    $url = 'http://localhost/rest_api/api/product/8'; // Request Url
    $method = "DELETE";                               // Set HTTP Method
    $this->curl($user, $pass, $url, $method);         // cURL func.
}
```
