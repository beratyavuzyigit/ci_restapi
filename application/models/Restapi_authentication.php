<?php

defined('BASEPATH') or exit('No direct script access allowed');

class restapi_authentication extends CI_Model
{
    /*
    
        This Page Contains RESTful API Authentication Model Func.

        ┌─────────────────────────────┐
        │ A U T H E N T I C A T I O N │
        └─────────────────────────────┘
        
    */

    public function check_user($user,$pass)
    {
        if ($user != null && $pass != null) {           // Check if existing USER:PASS Data
            $this->load->database();                    // Load Database
            $this->db->where('user', $user);            // Select by User
            $this->db->where('pass', $pass);            // And Select by Pass
            $result = $this->db->get('authentication'); // From Authentication Table
            $num_rows = $result->num_rows();            // Get Row Count
            if ($num_rows) {                            // Check if existing Row
                return true;                            // ** Return True
            } else {
                return false;                           // ** Return False
            }
        } else {
            return false;                               // ** Return False
        }
    }

    /* 
    
        **** Authorization by Digit ****
        ┌───────────────────────────────┐
        │           1. SELECT           │
        │           2. UPDATE           │
        │           3. INSERT           │       
        │           4. DELETE           │
        └───────────────────────────────┘

    */


    /* Authorization Check For READ */
    public function authorization_read($user,$pass)
    {
        if ($user != null && $pass != null) {               // Check if existing USER:PASS Data
            $this->load->database();                        // Load Database
            $this->db->select("authorization");             // Select 'authorization' Column
            $this->db->where('user', $user);                // Select by User
            $this->db->where('pass', $pass);                // And Select by Pass
            $result = $this->db->get('authentication');     // From Authentication Table
            $num_rows = $result->num_rows();                // Get Row Count
            if ($num_rows) {                                // Check if existing Row
                $row = $result->row_array();                // Get Data as Array
                $authorizations = $row["authorization"];    // Get Authorization Data
                $auth_select = $authorizations[0];          // Get 'SELECT' Permission
                if ($auth_select == 1) {                    // 'SELECT' Authorization Check
                    return true;                            // ** Return True
                } else {
                    return false;                           // ** Return False
                }
            } else {
                return false;                               // ** Return False
            }
        } else {
            return false;                                   // ** Return False
        }
    }

    /* Authorization Check For UPDATE */
    public function authorization_update($user,$pass)
    {
        if ($user != null && $pass != null) {               // Check if existing USER:PASS Data
            $this->load->database();                        // Load Database
            $this->db->select("authorization");             // Select 'authorization' Column
            $this->db->where('user', $user);                // Select by User
            $this->db->where('pass', $pass);                // And Select by Pass
            $result = $this->db->get('authentication');     // From Authentication Table
            $num_rows = $result->num_rows();                // Get Row Count
            if ($num_rows) {                                // Check if existing Row
                $row = $result->row_array();                // Get Data as Array
                $authorizations = $row["authorization"];    // Get Authorization Data
                $auth_select = $authorizations[1];          // Get 'UPDATE' Permission
                if ($auth_select == 1) {                    // 'UPDATE' Authorization Check
                    return true;                            // ** Return True
                } else {
                    return false;                           // ** Return False
                }
            } else {
                return false;                               // ** Return False
            }
        } else {
            return false;                                   // ** Return False
        }
    }

    /* Authorization Check For CREATE */
    public function authorization_create($user,$pass)
    {
        if ($user != null && $pass != null) {               // Check if existing USER:PASS Data
            $this->load->database();                        // Load Database
            $this->db->select("authorization");             // Select 'authorization' Column
            $this->db->where('user', $user);                // Select by User
            $this->db->where('pass', $pass);                // And Select by Pass
            $result = $this->db->get('authentication');     // From Authentication Table
            $num_rows = $result->num_rows();                // Get Row Count
            if ($num_rows) {                                // Check if existing Row
                $row = $result->row_array();                // Get Data as Array
                $authorizations = $row["authorization"];    // Get Authorization Data
                $auth_select = $authorizations[2];          // Get 'CREATE' Permission
                if ($auth_select == 1) {                    // 'CREATE' Authorization Check
                    return true;                            // ** Return True
                } else {
                    return false;                           // ** Return False
                }
            } else {
                return false;                               // ** Return False
            }
        } else {
            return false;                                   // ** Return False
        }
    }

    /* Authorization Check For DELETE */
    public function authorization_delete($user,$pass)
    {
        if ($user != null && $pass != null) {               // Check if existing USER:PASS Data
            $this->load->database();                        // Load Database
            $this->db->select("authorization");             // Select 'authorization' Column
            $this->db->where('user', $user);                // Select by User
            $this->db->where('pass', $pass);                // And Select by Pass
            $result = $this->db->get('authentication');     // From Authentication Table
            $num_rows = $result->num_rows();                // Get Row Count
            if ($num_rows) {                                // Check if existing Row
                $row = $result->row_array();                // Get Data as Array
                $authorizations = $row["authorization"];    // Get Authorization Data
                $auth_select = $authorizations[3];          // Get 'DELETE' Permission
                if ($auth_select == 1) {                    // 'DELETE' Authorization Check
                    return true;                            // ** Return True
                } else {
                    return false;                           // ** Return False
                }
            } else {
                return false;                               // ** Return False
            }
        } else {
            return false;                                   // ** Return False
        }
    }
}
