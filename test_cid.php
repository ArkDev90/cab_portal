<?php
session_start();
if (isset($_GET['test'])) {
    $_SESSION['test'] = '123';
} else {
    unset($_SESSION['test']);
}
header('Location: ./');
?>