<?php

defined('BASEPATH') or exit('No direct script access allowed');

class restapi_product extends CI_Model
{
    public function get_all()
    {
        $this->load->database();
        $result = $this->db->get('products')->result_array();
        return $result;
    }

    public function where_id($id)
    {
        $this->load->database();
        $this->db->where('product_id', $id);
        $result = $this->db->get('products')->row_array();
        return $result;
    }

    public function with_select($select_query, $id)
    {
        $this->load->database();
        if ($this->db->field_exists($select_query, 'products')) {
            $this->db->select($select_query);
            $this->db->where('product_id', $id);
            $result = $this->db->get('products')->row_array();
            return $result;
        }
    }

    public function create_product($product_data)
    {
        $this->load->database();
        $this->db->where('stock_code', $product_data["stock_code"]);
        $num_rows = $this->db->get('products')->num_rows();
        if ($num_rows) {
            return false;
        } else {
            $this->db->insert('products', $product_data);
            return true;
        }
    }

    public function insert_product($product_data)
    {
        $this->load->database();
        $stock_code = $product_data["stock_code"];
        unset($product_data["stock_code"]);
        $this->db->where('stock_code', $stock_code);
        $num_rows = $this->db->get('products')->num_rows();
        if ($num_rows) {
            $this->db->where('stock_code', $stock_code);
            $this->db->update('products', $product_data);
            return true;
        } else {
            return false;
        }
    }

    public function delete_product($product_id)
    {
        $this->load->database();
        $this->db->where('product_id', $product_id);
        $num_rows = $this->db->get('products')->num_rows();
        if ($num_rows) {
            $this->db->where('product_id', $product_id);
            $this->db->delete('products');
            return true;
        } else {
            return false;
        }
    }
}
