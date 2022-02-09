<?php
    function auth(): bool 
    {   
        return !empty($_SESSION['auth']);
    }

    function auth_verif(): void 
    {
        if(!auth()) 
        {
            header('Location: /administration/login.php');
            exit('redirection vers : <a href="/administration/login.php">page de connection</a>');
        }
    }

    /*OLD cours
    function auth(): bool 
    {
        if(session_status() != 2  ) 
        {
            session_start();
        }        
        return !empty($_SESSION['auth']);
    }*/
?>