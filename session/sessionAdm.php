<?php
if (!isset($_SESSION))
    session_start() or die();
    if ((!isset($_SESSION['login']))) {
        header('location: /');
        session_destroy();
        exit;
    }
