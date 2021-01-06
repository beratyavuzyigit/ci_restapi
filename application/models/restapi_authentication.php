<?php

defined('BASEPATH') or exit('No direct script access allowed');

class restapi_authentication extends CI_Model
{
    public function check_user($user,$pass)
    {
        if ($user != null && $pass != null) {
            # code...
            $this->load->database();
            $this->db->where('user', $user);
            $this->db->where('pass', $pass);
            $result = $this->db->get('authentication');
            $num_rows = $result->num_rows();
            if ($num_rows) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // provision according to authorization
    // 1. select
    // 2. update
    // 3. insert
    // 4. delete

    public function authorization_read($user,$pass)
    {
        if ($user != null && $pass != null) {
            $this->load->database();
            $this->db->select("authorization");
            $this->db->where('user', $user);
            $this->db->where('pass', $pass);
            $result = $this->db->get('authentication');
            $num_rows = $result->num_rows();
            if ($num_rows) {
                $row = $result->row_array();
                $authorizations = $row["authorization"];
                $auth_select = $authorizations[0];
                if ($auth_select == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function authorization_update($user,$pass)
    {
        if ($user != null && $pass != null) {
            $this->load->database();
            $this->db->select("authorization");
            $this->db->where('user', $user);
            $this->db->where('pass', $pass);
            $result = $this->db->get('authentication');
            $num_rows = $result->num_rows();
            if ($num_rows) {
                $row = $result->row_array();
                $authorizations = $row["authorization"];
                $auth_select = $authorizations[1];
                if ($auth_select == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function authorization_create($user,$pass)
    {
        if ($user != null && $pass != null) {
            $this->load->database();
            $this->db->select("authorization");
            $this->db->where('user', $user);
            $this->db->where('pass', $pass);
            $result = $this->db->get('authentication');
            $num_rows = $result->num_rows();
            if ($num_rows) {
                $row = $result->row_array();
                $authorizations = $row["authorization"];
                $auth_select = $authorizations[2];
                if ($auth_select == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function authorization_delete($user,$pass)
    {
        if ($user != null && $pass != null) {
            $this->load->database();
            $this->db->select("authorization");
            $this->db->where('user', $user);
            $this->db->where('pass', $pass);
            $result = $this->db->get('authentication');
            $num_rows = $result->num_rows();
            if ($num_rows) {
                $row = $result->row_array();
                $authorizations = $row["authorization"];
                $auth_select = $authorizations[3];
                if ($auth_select == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
