<?php

// This file is for the core intranet stuff
class Intranet {

    var $redis = null; //redis pointer
    var $db = null; //db pointer

    // set some stuff up
    function Intranet(&$redis,&$db) {
        $this->redis = $redis;
        $this->db = $db;
    }

    function get_user_fullname($uid) {
        $result = $this->db->query("SELECT fullname FROM users WHERE id = $uid");
        $row = $result->fetch();
        return $row['fullname'];
    }

    // returns a user's full name
    function get_user_fullname_redis($uid) {
        $first_name = $this->redis->get("uid:$uid:firstname");             
        $surname = $this->redis->get("uid:$uid:surname");             
        $full_name = $first_name . ' ' . $surname;
        return $full_name;
    }

    // returns an array of a user's messages
    function get_user_messages($uid) {
        $results = array();
        $msg_list = $this->redis->lrange("uid:$uid:msgs",0,-1);
        foreach ($msg_list as $msg_id) {
            $data = $this->redis->get("msg:$msg_id");
            $msg = explode("|", $data);
            $msg_from_id = $msg[0];
            $msg_time = $msg[1];
            $msg_title = $msg[2];
            $msg_body = $msg[3];
            $msg_from = $this->get_user_fullname($msg_from_id);
            $msg_date = date("F j, Y, g:i a", $msg_time);
            array_push($results, array('id' => $msg_id, 'msg_from_id' => $msg_from_id, 'from' => $msg_from, 'date' => $msg_date, 'title'  => $msg_title, 'body' => $msg_body));
        }
        return $results;
    }

    // returns an array of updates
    function get_updates() {
        $result = $this->db->query("SELECT id, date, title FROM news ORDER by date DESC");
        $rows = $result->fetchAll();
        return $rows;
    }   

    // returns six most recent updates
    function get_recent_updates($cookie) {
        $cookie_arr =  split(":", $cookie);
        $recent_updates = array();
            
        foreach ($cookie_arr as $x) {
            if (empty($x)) {
                continue;
            }
            $result = $this->db->query("SELECT id, title FROM news WHERE id = $x");
            $row = $result->fetch();
            array_push($recent_updates, $row);
        }
        return $recent_updates;
    }

    function push_update_cookie($cookie, $article_id) {
        (empty($cookie)) ? $updates = array() : $updates = explode(":", $cookie);
        // remove last item from array if six already
        if (count($updates) == 6) {
            array_shift($updates);
        }
        
        // push latest item onto array
        if (!in_array($article_id, $updates)) {
            array_push($updates, $article_id);
        }
        
        // join into a | delimited string and set the cookie
        $cookie_str = implode(":", $updates);
        setcookie("recently_read", $cookie_str);
    }   

    // return a news article
    function get_article($id) {
        $result = $this->db->query("SELECT * FROM news WHERE id = $id");
        $rows = $result->fetch();
        return $rows;
    } 

    // get the next news article based on date
    function get_next_article_id($id) {
        $result = $this->db->query("SELECT id FROM news WHERE date < (SELECT date FROM news WHERE id = $id) ORDER BY date DESC LIMIT 1");
        $next_id = $result->fetch();
        return $next_id['id']; 
    }

    function get_profile($id) {
        $result = $this->db->query("SELECT * FROM profiles WHERE id = $id");
        $row = $result->fetch();
        return $row;
    }
    
    function update_profile($id, $bio) {
        $sql = "UPDATE profiles SET bio=:bio WHERE id=:id";
        try {
            $q = $this->db->prepare($sql);
            $q->execute(array(":bio" => "$bio", ":id" => "$id"));
            return true;
        } catch (PDOException $e) {
            echo "SQL error";
            return false;
        }
    }

    function generate_filename() {
        // could be improved upon really
        $random_string = random_string(8);
        $filename = $random_string . time() . ".jpg";
        return $filename;    
    }

    function update_avatar($id, $file_name) {
        print "id:$id | file_name:$file_name";
        $sql = "UPDATE profiles SET profile_image=:file_name WHERE id=:id";
        try {
            $q = $this->db->prepare($sql);
            $q->execute(array(":file_name" => "$file_name", ":id" => "$id"));
            return true;
        } catch (PDOException $e) {
            echo "SQL error";
            return false;
        }
    }

    function check_easter_egg() {
        define('EASTER_EGG_CODE', '425369646573');
    }
}
