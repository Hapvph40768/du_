<?php
//điều chỉnh kết nối db ở đây
const DBNAME = "du_an1";
const DBUSER = "root";
const DBPASS = "";
const DBCHARSET = "utf8mb4";
const DBHOST = "127.0.0.1";

const BASE_URL = "http://localhost/du_an1/base/";

function redirect($key = "",$msg = "",$url ="") {
    $_SESSION[$key] = $msg;
    switch ($key) {
        case "errors":
            unset($_SESSION['success']);
            break;
        case "success":
            unset($_SESSION['errors']);
            break;
    }
    $separator = (strpos($url, '?') !== false) ? '&' : '?';
    header('location: ' . BASE_URL . $url . $separator . "msg=" . $key);die;
}

function route($name) {
    return BASE_URL.$name;
}

if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8', false);
    }
}