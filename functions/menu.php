<?php
//Rendu HTML
  function nav_item(string $link, string $title, string $linkClass=''): string {
    $classe=$linkClass;
    $classe2 = 'aria-current=" page"';

    if ($_SERVER['SCRIPT_NAME'] === $link) 
    {
        $classe = $classe.' active"'.$classe2;
    } else { 
        $classe = $classe.'" ';
    }
      return <<<HTML
        <li class="nav-item">
            <a href="{$link}" class= "{$classe}">{$title}</a> 
        </li>
HTML;
  }

//Définition du menu
  function nav_menu(string $linkClass=''):string {
    return
      nav_item('/index.php', "Accueil", $linkClass)."\n". 
      nav_item('/guestbook.php',"Livre d'Or", $linkClass)."\n".
      nav_item('/blog/blog.php',"Blog", $linkClass)."\n".
      nav_item('/mon_cv/fifi-cv.php', "Mon CV", $linkClass)."\n".
      nav_item('/glace.php',"Glace", $linkClass)."\n".
      nav_item('/pizzas.php',"Pizza", $linkClass)."\n".
      nav_item('/nsfw.php', 'NSFW', $linkClass)."\n".
      nav_item('/jeu.php', "Jeux", $linkClass). "\n".
      nav_item('/Contact.php', "contact", $linkClass)."\n";
  }  
?>


