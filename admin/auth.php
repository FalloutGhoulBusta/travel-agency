<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

if (!isAdmin()) {
    redirectWith('/login.php', 'Please login as admin.', 'danger');
    exit;
}
