<?php
    namespace Fifi;
    
    class Menu 
    {
        private $link;
        private $linkClass;
        private $title;

        public function __construct(string $link, string $title, string $linkClass='')
        {
            $this->link = $link;
            $this->linkClass = $linkClass;
            $this->title = $title;
        }

        public function toHTML()
        {
            //menu selectionné
            $class2 = 'aria-curent=" page"';
            if($_SERVER['SCRIPT_NAME'] === $this->link)
            {
                $class = $this->linkClass . ' active"' . $class2;
            } else {
                $class = $this->linkClass . '" ';
            }
            
            return <<<HTML
            <li class="nav-item">
                <a href="$this->link" class="$class">$this->title</a>
            </li>
HTML;
    
        }
    }
?>