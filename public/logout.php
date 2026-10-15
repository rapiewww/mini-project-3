<?php
require_once __DIR__ . '/../helpers/functions.php';
init_session();
session_destroy();
header('Location: login.php');
exit;

