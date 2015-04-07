<?php

include("encryption.php");

class Auth {

    var $db = null; // db pointer

    function Auth(&$db) {
        $this->db = $db;
    }

    function check_login($username, $password, $key) {
        $enc_password = encrypt($password, $key);

        // build db query to return valid users from db
        $query = "SELECT id FROM users WHERE username = '$username' ";
        $query .= "AND enc_password = '$enc_password'  ";
        $query .= "AND enabled = true";
        $result = $this->db->query($query);

        $rows = $result->fetch();
        $uid = $rows['id'];
        return $uid;
    } 

    function get_role($uid) {
        // build db query to get user's role id
        $query = "SELECT role_id FROM users_roles WHERE user_id = '$uid'";
        $result = $this->db->query($query);

        $rows = $result->fetch();
        $role_id = $rows['role_id'];
        return $role_id;
    }    

    function check_permissions_by_name($role_id, $permission_name) {
        // build db query to check if the given role_id has the named permission
        $query  = "select 1 from roles r, users_roles u, permissions p ";
        $query .= "where p.name = '$permission_name' ";
        $query .= "and p.id = r.permission_id and u.role_id = r.id ";
        $query .= "and r.id = $role_id";
        $result = $this->db->query($query);

        $rows = $result->fetch();
        if ($rows[1] == 1) {
            return true;
        } else {
            return false;
        }
    }
}

?>
