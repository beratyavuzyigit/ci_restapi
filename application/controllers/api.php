<?php
defined('BASEPATH') or exit('No direct script access allowed');

class api extends CI_Controller
{
	public function product()
	{
		$data = getallheaders();

		if (!isset($data["Authorization"])) {
			exit(http_response_code(400));
		}
		$header_authorization = $data["Authorization"];
		if (!isset(explode(" ", $header_authorization)[0])) {
			exit(http_response_code(400));
		}
		if (!isset(explode(" ", $header_authorization)[1])) {
			exit(http_response_code(400));
		}
		$auth_method = explode(" ", $header_authorization)[0];
		$authentication_code = explode(" ", $header_authorization)[1];
		$authorization = base64_decode($authentication_code);
		if (!isset(explode(":", $authorization)[0])) {
			exit(http_response_code(400));
		}
		if (!isset(explode(":", $authorization)[1])) {
			exit(http_response_code(400));
		}
		$user = explode(":", $authorization)[0];
		$pass = md5(explode(":", $authorization)[1]);
		$this->load->model("restapi_authentication");
		if (!$this->restapi_authentication->check_user($user, $pass)) {
			exit(http_response_code(401));
		}
		$method = $this->input->method();

		if ($method == "get") {
			if (!$this->restapi_authentication->authorization_read($user, $pass)) {
				exit(http_response_code(401));
			}
			$this->load->helper('url');
			$params = explode('/', str_replace('api/product', '', uri_string()));
			if (isset($params[1])) {
				$id = $params[1];
				if (isset($params[2])) {
					$column = $params[2];
					$this->load->model("restapi_product");
					$result = $this->restapi_product->with_select($column, $id);
					$this->load->library('restapi_formatter');
					$this->restapi_formatter->set_format('xml');
					$response = $this->restapi_formatter->convert_to_format($result);
					print_r($response);
					http_response_code(200);
				} else {
					$this->load->model("restapi_product");
					$result = $this->restapi_product->where_id($id);
					$this->load->library('restapi_formatter');
					$this->restapi_formatter->set_format('xml');
					$response = $this->restapi_formatter->convert_to_format($result);
					print_r($response);
					http_response_code(200);
				}
			} else {
				$this->load->model("restapi_product");
				$result = $this->restapi_product->get_all();
				$this->load->library('restapi_formatter');
				$this->restapi_formatter->set_format('xml');
				$response = $this->restapi_formatter->convert_to_format($result);
				print_r($response);
				http_response_code(200);
			}
		} elseif ($method == "post") {
			if (!$this->restapi_authentication->authorization_create($user, $pass)) {
				exit(http_response_code(401));
			}
			date_default_timezone_set('Europe/Istanbul');
			$this->load->helper('date');
			$data = json_decode($this->input->raw_input_stream);

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
			$product_data = array(
				"product_name" => $data->product_name,
				"product_desc" => $data->product_desc,
				"img_url" => $data->img_url,
				"product_price" => $data->product_price,
				"product_discount" => $discount,
				"product_status" => $data->product_status,
				"products_author" => $user,
				"created_at" => mdate("%d.%m.%Y %h.%i.%s"),
				"stock_code" => $data->stock_code,
				"views" => 0
			);
			$this->load->model('restapi_product');
			$result = $this->restapi_product->create_product($product_data);
			if ($result)
				exit(http_response_code(201));
			else
				exit(http_response_code(404));
		} elseif ($method == "patch") {
			if (!$this->restapi_authentication->authorization_update($user, $pass)) {
				exit(http_response_code(401));
			}
			$data = json_decode($this->input->raw_input_stream);
			$update_list = array();
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
			if (isset($data->stock_code)) {
				$update_list["stock_code"] = $data->stock_code;
			}
			$this->load->model('restapi_product');
			$result = $this->restapi_product->insert_product($update_list);
			if ($result)
				exit(http_response_code(200));
			else
				exit(http_response_code(403));
		} elseif ($method == "delete") {
			if (!$this->restapi_authentication->authorization_delete($user, $pass)) {
				exit(http_response_code(401));
			}
			$this->load->helper('url');
			$params = explode('/', str_replace('api/product', '', uri_string()));
			if (isset($params[1])) {
				$product_id = $params[1];
				$this->load->model('restapi_product');
				$result = $this->restapi_product->delete_product($product_id);
				if ($result)
					exit(http_response_code(200));
				else
					exit(http_response_code(403));
			} else {
				exit(http_response_code(400));
			}
		} elseif ($method == "options") {
			$allowed_methods = array(
				"GET",
				"POST",
				"PATCH",
				"DELETE",
				"OPTIONS",
			);
			$this->load->library('restapi_formatter');
			$this->restapi_formatter->set_format('json');
			$response = $this->restapi_formatter->convert_to_format($allowed_methods);
			print_r($response);
		} else {
			exit(http_response_code(405));
		}
	}
}
