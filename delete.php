<?php

    spl_autoload_register(function($class){
        include $class .'.php';
    });

    $user = new Person();

     if (isset($_GET['action']) && $_GET['action']=='delete')
    {
        $id = (int)$_GET['id'];
        if ($user->delete($id)) 
        {
            echo "<script> alert('Deleted successfully');
                        window.location.href = 'index.php';
                   </script>";
                exit();
        }
    }
?>