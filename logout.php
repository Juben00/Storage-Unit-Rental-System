<?php
session_start();

if (isset($_SESSION['customer'])) {
    session_unset();

    session_destroy();
}

header('Location: index.php');
exit();