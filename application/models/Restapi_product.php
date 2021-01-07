<?php

defined('BASEPATH') or exit('No direct script access allowed');

class restapi_product extends CI_Model
{

    /*
    
        This Page Contains RESTful API Product Model Func.

        ┌──────────────────────────────────────┐
        │ [C]REATE, [R]EAD, [U]PDATE, [D]ELETE │
        └──────────────────────────────────────┘
        
    */

    /* Get All Product Info. Func. */
    public function get_all()
    {
        $this->load->database();                                // Load Database
        $result = $this->db->get('products')->result_array();   // Get Data as Multi-Dimensional Array
        return $result;                                         // Return Data as Multi-Dimensional Array
    }

    /* Get Product Info by {id} */
    public function where_id($id)
    {
        $this->load->database();                            // Load Database
        $this->db->where('product_id', $id);                // Get Data by {id}
        $result = $this->db->get('products')->row_array();  // Get Data as Array
        return $result;                                     // Return Data as Array
    }

    /* Get Product {column_name} İnfo by {id}  */
    public function with_select($select_query, $id)
    {
        $this->load->database();                                    // Load Database
        if ($this->db->field_exists($select_query, 'products')) {   // Check if Exits X Column in Products
            $this->db->select($select_query);                       // Select X Column
            $this->db->where('product_id', $id);                    // Get Data by {id}
            $result = $this->db->get('products')->row_array();      // Get Data as Array
            return $result;                                         // Return Data as Array
        }
    }

    /* Create New Product Func. */
    public function create_product($product_data)
    {
        $this->load->database();                                        // Load Database
        $this->db->where('stock_code', $product_data["stock_code"]);    // Get Data by {stock_code}
        $num_rows = $this->db->get('products')->num_rows();             // Get Query Row Count
        if ($num_rows) {                                                // Check if Exists {stock_code} in Products
            return false;                                               // ** Return False
        } else {
            $this->db->insert('products', $product_data);               // Create New Data in Products
            return true;                                                // ** Return True
        }
    }

    /* Update a Product by {id} */
    public function update_product($product_data)
    {
        $this->load->database();                            // Load Database
        $stock_code = $product_data["stock_code"];          // Get {stock_code}
        unset($product_data["stock_code"]);                 // Delete {stock_code} from Product Data Array
        $this->db->where('stock_code', $stock_code);        // Get Data by {stock_code}
        $num_rows = $this->db->get('products')->num_rows(); // Get Query Row Count
        if ($num_rows) {                                    // Check if Exists {stock_code} in Products
            $this->db->where('stock_code', $stock_code);    // Select Row by {stock_code}
            $this->db->update('products', $product_data);   // Update a Product Data
            return true;                                    // ** Return True
        } else {
            return false;                                   // ** Return false
        }
    }

     /* Delete a Product by {id} */
    public function delete_product($product_id)
    {
        $this->load->database();                            // Load Database
        $this->db->where('product_id', $product_id);        // Get Data by {id}
        $num_rows = $this->db->get('products')->num_rows(); // Get Query Row Count
        if ($num_rows) {                                    // Check if Exists {id} in Products
            $this->db->where('product_id', $product_id);    // Select Row by {id} 
            $this->db->delete('products');                  // Delete a Product Data
            return true;                                    // ** Return True
        } else {
            return false;                                   // ** Return False
        }
    }
}
