<?php
defined('BASEPATH') or exit('No direct script access allowed');

class api extends CI_Controller
{
	public function index()
	{
		$data = getallheaders(); // get HTTP Header

		/* Get Authentication */
		if (!isset($data["Authorization"])) { // Check if exists Authorization in Headers
			exit(http_response_code(400));	  // Reponse HTTP Code 400
		}
		$header_authorization = $data["Authorization"];

		/* Get Content in the Authentication */
		if (!isset(explode(" ", $header_authorization)[0])) { // Check if exists Method in Authorization
			exit(http_response_code(400));					  // Reponse HTTP Code 400
		}
		if (!isset(explode(" ", $header_authorization)[1])) { // Check if exists USER:PASS in Authorization
			exit(http_response_code(400));					  // Reponse HTTP Code 400
		}
		$auth_method = explode(" ", $header_authorization)[0];         // Explode and Get Auth Method
		$authentication_code = explode(" ", $header_authorization)[1]; // Explode and Get USER:PASS

		/* Get Username and Password in Authentication Content */
		$authorization = base64_decode($authentication_code); // Authentication Decode in Exploded Data
		if (!isset(explode(":", $authorization)[0])) { 		  // Check if exists User in Authorization
			exit(http_response_code(400)); 			          // Reponse HTTP Code 400
		}
		if (!isset(explode(":", $authorization)[1])) { 		  // Check if exists Password in Authorization
			exit(http_response_code(400));			   		  // Reponse HTTP Code 400
		}
		$user = explode(":", $authorization)[0];	   		  // Explode and Get Username
		$pass = md5(explode(":", $authorization)[1]);  		  // Explode and Get Password

		/* Verify Username and Passowrd in Authentication Model */
		$this->load->model("restapi_authentication");  					// Load Authentication Model
		if (!$this->restapi_authentication->check_user($user, $pass)) { // Authentication...
			exit(http_response_code(401));								// Reponse HTTP Code 400
		}

		$method = $this->input->method(); // Get HTTP Method

		if ($method == "get") { // Check if HTTP Method is "GET"

			/* Check "POST" Authorization */
			if (!$this->restapi_authentication->authorization_read($user, $pass)) {
				exit(http_response_code(401));
			}

			$this->load->model("restapi_product"); 	 	  // Load Product Model
			$this->load->library('restapi_formatter');	  // Load RESTful API Formatter Library
			// $this->restapi_formatter->set_format('json'); // Set Format to JSON
			$this->load->helper('url'); 		   	      // Load URL Helper

			$params = explode('/', str_replace('api', '', uri_string())); // Get Parameters
			if (isset($params[1])) {	 	  // Check if Exists {table} Parameter
				$table_name = $params[1];     // Assign {table} Parameter to Variable
				if (isset($params[2])) {      // Check if Exists {id} Parameter
					$id = $params[2];         // Assign {id} Parameter to Variable
					if (isset($params[3])) {  // Check if Exists {column_name} Parameter
						$column = $params[3]; // Assign {column_name} Parameter to Variable

						$result = $this->restapi_product->with_select($table_name, $column, $id); // Get Product {column_name} Info by {id} 
						$response = $this->restapi_formatter->convert_to_format($result); 		  // Product Data Convert to X Format

						print_r($response); 	 // Print Formatted Product Data
						http_response_code(200); // Response HTTP Code 200 OK

					} else { // If {column_name} Parameter does not Exists
						$result = $this->restapi_product->where_id($table_name, $id); 	  // Get Oroduct Info by {id}
						$response = $this->restapi_formatter->convert_to_format($result); // Product Data Convert to X Format

						print_r($response); 	 // Print Formatted Product Data
						http_response_code(200); // Response HTTP Code 200 OK
					}
				} else { // If {id} Parameter does not Exists
					$result = $this->restapi_product->get_all($table_name); 		  // Get All Product Info.
					$response = $this->restapi_formatter->convert_to_format($result); // Product Data Convert to X Format

					print_r($response); 	 // Print Formatted Product Data
					http_response_code(200); // Response HTTP Code 200 OK
				}
			} else {
				exit(http_response_code(400));
			}
		} elseif ($method == "post") { // Check if HTTP Method is "POST"

			/* Check "CREATE" Authorization */
			if (!$this->restapi_authentication->authorization_create($user, $pass)) {
				exit(http_response_code(401));
			}

			$this->load->helper('url'); 	  // Load URL Helper
			$params = explode('/', str_replace('api', '', uri_string())); // Get Parameters
			if (isset($params[1])) {	 	  // Check if Exists {table} Parameter
				$table_name = $params[1];	  // Assign {table} Parameter to Variable

				date_default_timezone_set('Europe/Istanbul'); // Set Default Timezone 'Europe/Istanbul'
				$this->load->helper('date');				  // Load 'date' Helper

				$data = json_decode($this->input->raw_input_stream); // Receive Data Sent From Any Method

				/* Check If Exists Required Data */
				if (!isset($data->product_name)) {
					exit(http_response_code(400));
				}
				if (!isset($data->product_desc)) {
					exit(http_response_code(400));
				}
				if (!isset($data->img_url)) {
					exit(http_response_code(400));
				}
				if (!isset($data->product_price)) {
					exit(http_response_code(400));
				}
				if (!isset($data->product_discount)) {
					$discount = $data->product_discount;
				} else {
					$discount = 0;
				}
				if (!isset($data->product_status)) {
					exit(http_response_code(400));
				}
				if (!isset($data->stock_code)) {
					exit(http_response_code(400));
				}

				/* Creating a Data Array */
				$product_data = array(
					"product_name" => $data->product_name,
					"product_desc" => $data->product_desc,
					"img_url" => $data->img_url,
					"product_price" => $data->product_price,
					"product_discount" => $discount,
					"product_status" => $data->product_status,
					"products_author" => $user,
					"created_at" => mdate("%d.%m.%Y %h.%i.%s"), // Ex. Format: 25.10.2021 00.45.20
					"stock_code" => $data->stock_code,
					"views" => 0
				);

				/* Load Product Model */
				$this->load->model('restapi_product');

				$result = $this->restapi_product->create_product($product_data, $table_name); // Send Created Product Array and Table Name to Product Model

				/* Result */
				if ($result)
					exit(http_response_code(201));
				else
					exit(http_response_code(404));
			} else {
				exit(http_response_code(400)); // HTTP Response Code 400
			}
		} elseif ($method == "patch") { // Check if HTTP Method is "PATCH"

			/* Check "UPDATE" Authorization */
			if (!$this->restapi_authentication->authorization_update($user, $pass)) {
				exit(http_response_code(401));
			}

			$this->load->helper('url'); 	  // Load URL Helper
			$params = explode('/', str_replace('api', '', uri_string())); // Get Parameters
			if (isset($params[1])) {	 	  // Check if Exists {table} Parameter
				$table_name = $params[1];	  // Assign {table} Parameter to Variable

				$data = json_decode($this->input->raw_input_stream); // Receive Data Sent From Any Method

				$update_list = array(); // Create Update List

				/* Check If Exists Required and Optional Data */
				if (isset($data->stock_code)) {
					$update_list["stock_code"] = $data->stock_code;
				} else {
					exit(http_response_code(400));
				}
				if (isset($data->product_name)) {
					$update_list["product_name"] = $data->product_name;
				}
				if (isset($data->product_desc)) {
					$update_list["product_desc"] = $data->product_desc;
				}
				if (isset($data->img_url)) {
					$update_list["img_url"] = $data->img_url;
				}
				if (isset($data->product_price)) {
					$update_list["product_price"] = $data->product_price;
				}
				if (isset($data->product_discount)) {
					$update_list["product_discount"] = $data->product_discount;
				}
				if (isset($data->product_status)) {
					$update_list["product_status"] = $data->product_status;
				}

				/* Load Product Model */
				$this->load->model('restapi_product');

				$result = $this->restapi_product->update_product($update_list, $table_name); // Send Created Update List Array and Table Name to Product Model

				/* Result */
				if ($result)
					exit(http_response_code(200));
				else
					exit(http_response_code(403));
			} else {
				exit(http_response_code(400));
			}
		} elseif ($method == "delete") { // Check if HTTP Method is "DELETE"

			/* Check "DELETE" Authorization */
			if (!$this->restapi_authentication->authorization_delete($user, $pass)) {
				exit(http_response_code(401));
			}

			$this->load->helper('url');	   	  // Load URL Helper
			$params = explode('/', str_replace('api/product', '', uri_string())); // Get Parameters
			$params = explode('/', str_replace('api', '', uri_string())); // Get Parameters
			if (isset($params[1])) {	 	  // Check if Exists {table} Parameter
				$table_name = $params[1];	  // Assign {table} Parameter to Variable
				if (isset($params[2])) { 		// Check if Exists {id} Parameter
					$product_id = $params[2];	// Get {id} Parameter

					$this->load->model('restapi_product'); // Load Product Model

					$result = $this->restapi_product->delete_product($product_id, $table_name); // Send {id} and Table Name Parameter to Product Model

					/* Result */
					if ($result)
						exit(http_response_code(200));
					else
						exit(http_response_code(403));
				} else {						   // If {id} Parameter does not Exists
					exit(http_response_code(400)); // HTTP Response Code 400
				}
			} else {
				exit(http_response_code(400));	   // HTTP Response Code 400
			}
		} elseif ($method == "options") { // Check if HTTP Method is "OPTIONS"

			/* Allowed Methods Determining */
			$allowed_methods = array(
				"GET",
				"POST",
				"PATCH",
				"DELETE",
				"OPTIONS",
			);

			$this->load->library('restapi_formatter');	  // Load RESTful API Formatter Library
			$this->restapi_formatter->set_format('json'); // Set Format to JSON

			$response = $this->restapi_formatter->convert_to_format($allowed_methods); // Product Data Convert to X Format

			print_r($response); // Print Formatted Product Data

		} else {
			exit(http_response_code(405)); // HTTP Response Code 405
		}
	}
}
