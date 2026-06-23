<?php
session_start();
function require_admin(){
    if(empty($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin'){
        header('Location: /wijaya_transport/admin.php?module=auth&action=login');
        exit;
    }
}
