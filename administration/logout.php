<?php
    if(session_status() != 2) 
    {
        session_start();
    }
    
    if($_SESSION['auth']) 
    {
        unset($_SESSION['auth']);
    }

    if($_SESSION['id'])
    {
        unset($_SESSION['id']);
    }

    if($_SESSION['success'])
    {
        $_SESSION['success'] = null;
    }

    if($_SESSION['age'])
    {
        unset($_SESSION['age']);
    }
    
    if($_SESSION['user'])
    {
        unset($_SESSION['user']);
    }
    
    header('Location: /');
?>