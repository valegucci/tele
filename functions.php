<?php

session_start();

require_once(dirname(__FILE__).'/settings.php');
require_once(dirname(__FILE__).'/includes/db.php');
require_once(dirname(__FILE__).'/includes/r4me_query.php');

function r4me_get_countries(){
    $countries = array();
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="SELECT * FROM r4me_vendor_countries";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            $countries[] = array('id'=>$row['id'], 'code'=>$row['country_code'], 'name'=>$row['country_name']);
        endwhile;
    endif;   

    return $countries;  
}


function r4me_get_vendor_country($vendor_id){
    $country_ids = array();
    $countries = array();
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="SELECT * FROM r4me_vendor_country_relationship WHERE vendor_id = '$vendor_id'";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            $country_id = $row['country_id'];
            $country = $mysqli->query("SELECT * FROM r4me_vendor_countries WHERE id = '$country_id' LIMIT 1");
            if($country->num_rows > 0){
                $country = mysqli_fetch_assoc($country);
                $countries[] = array('id'=>$country['id'], 'code'=>$country['country_code'], 'name'=>$country['country_name']);
            }
        endwhile;
    endif;  



    return $countries;  
}

function r4me_is_selected_country($selected, $countries = array()){
    $countries = array_map(
    function($str) {
        return r4me_param_encode($str);
    },
    $countries
);
    return in_array($selected, $countries);
}

function r4me_get_country_by_code($param){
    $country = strtoupper($param);
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "SELECT * FROM r4me_vendor_countries WHERE country_code = '$country'";
    $result = $mysqli->query($sql);
    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            return $row['id'];
        endwhile;
    endif;

    return 0;
}

function r4me_get_feature_by_slug($param){
    $db = Database::getInstance();
    $mysqli = $db->getConnection();
    $sql = "SELECT * FROM r4me_vendor_features WHERE slug = '$param'";
    $result = $mysqli->query($sql);
    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            return $row['id'];
        endwhile;
    endif;

    return 0;
}


function r4me_get_features(){
    $features = array();
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="SELECT * FROM r4me_vendor_features ORDER BY feature_group ASC";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            $features[] = array('id'=>$row['id'], 'name'=>$row['name'], 'slug'=>$row['slug'], 'group'=>$row['feature_group']);
        endwhile;
    endif;   

    return $features;  
}

function r4me_get_vendor_feature($vendor_id){
    $features = array();
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="SELECT * FROM r4me_vendor_feature_relationship WHERE vendor_id = '$vendor_id'";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0):
        while($row = $result->fetch_assoc()):
            $feature_id = $row['feature_id'];
            $feature = $mysqli->query("SELECT * FROM r4me_vendor_features WHERE id = '$feature_id' LIMIT 1");
            if($feature->num_rows > 0){
                $feature = mysqli_fetch_assoc($feature);
                $features[] = array('id'=>$feature['id'], 'name'=>$feature['name'], 'slug'=>$feature['slug'], 'group'=>$feature['feature_group']);
            }
        endwhile;
    endif;  

    return $features;  
}

function r4me_is_selected_feature($selected, $features = array()){
    $features = array_map(
    function($str) {
        return r4me_param_encode($str);
    },
    $features
);
    return in_array($selected, $features);
}

function r4me_slug_encode($param){
    $param = strtolower(str_replace(' ', '-', $param));
    $param = str_replace('/', '-', $param);
    $param = str_replace('&', '-', $param);
    $param = preg_replace("/[^a-z0-9_-]/i",'',$param);
    $param = str_replace('---', '-', $param);

    return $param;
}

function r4me_param_encode($param){
    
    return urlencode($param);
}

function r4me_param_decode($param){
    $param = rawurldecode($param);
    $param = str_replace('+', ' ', $param);
    return $param;
}

function r4me_get_url_currently($filter = array()) {
    $pageURL = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? "https://" : "http://";

    $pageURL .= $_SERVER["SERVER_NAME"];

    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= ":".$_SERVER["SERVER_PORT"];
    }

    $pageURL .= $_SERVER["REQUEST_URI"];


    if (strlen($_SERVER["QUERY_STRING"]) > 0) {
        $pageURL = rtrim(substr($pageURL, 0, -strlen($_SERVER["QUERY_STRING"])), '?');
    }

    $query = $_GET;
    foreach ($filter as $key) {
        unset($query[$key]);
    }

    if (sizeof($query) > 0) {
        $pageURL .= '?' . http_build_query($query);
    }

    return $pageURL;
}

function r4me_get_directory_url(){
    return isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? "https://" : "http://" . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
}

function r4me_get_child_directory_url(){
    return isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on" ? "https://" : "http://" . $_SERVER['HTTP_HOST'].dirname(dirname($_SERVER['PHP_SELF']));
}

function r4me_country_has_vendor($country_id){
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="SELECT * FROM r4me_vendor_country_relationship WHERE country_id = '$country_id' LIMIT 1";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0) return true;

    return false;
}

function r4me_total_vendors(){
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="SELECT COUNT(*) FROM r4me_vendors";
    
    $result = $mysqli->query($sql);
    $row = $result->fetch_row();

    return $row[0];
}

function r4me_user_logged_in(){
    if(isset($_SESSION['app_username']) && isset($_SESSION['app_password'])){
        if($_SESSION['app_username'] === APP_USERNAME && $_SESSION['app_password']=== APP_PASSWORD){
            return true;
        }
    }
    return false;
}

function r4me_set_token(){
    $token = md5(rand(1000,9999));
    $_SESSION['token'] = $token;
    echo $token;
}

function r4me_is_page($page){
    return stripos($_SERVER['REQUEST_URI'], $page);
}

function r4me_delete_country_relations($vendor){
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="DELETE FROM r4me_vendor_country_relationship WHERE vendor_id='$vendor'";
    $mysqli->query($sql);
}

function r4me_delete_feature_relations($vendor){
    $db = Database::getInstance();
    $mysqli = $db->getConnection(); 

    $sql="DELETE FROM r4me_vendor_feature_relationship WHERE vendor_id='$vendor'";
    $mysqli->query($sql);
}

function r4me_search_array($needle, $haystack){
    if(in_array($needle, $haystack)){
        return true;
    }
    foreach ($haystack as $element) {
        if(is_array($element) && r4me_search_array($needle, $element))
            return true;
    }
    return false;
}

function r4me_format_text($text){
    $paragraphs = '';
    foreach (explode("\n", $text) as $line) {
        if (trim($line) && substr($line, 0, 1) !== '<') {
            $paragraphs .= '<p>' . $line . '</p>';
        }
    }
    if($paragraphs !== ''){
        return $paragraphs;
    }
    
    return $text;
}
