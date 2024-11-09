<?php
session_start();
if (isset($_GET['id'])) {
    $_SESSION['edit_id'] = (int)$_GET['id'];
    header("Location: edit.php");
    exit();
}
?>
