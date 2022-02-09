<?php
    class Counter
    {
        const INCREMENT = 1;

        //CONSTRUCTION DE L'OBJET
        public function __construct(string $link)
        {
            $this->link = $link;
        }

        /** METHODE INCREMENTER */
        public function increment():void {
            if(file_exists($this->link)) {
              $count = (int)file_get_contents($this->link);
            } else {
              $count = (int)file_put_contents($this->link, 0);
            }
            $count ++;
            file_put_contents($this->link, $count);      
          }
        
        /** METHODE AFFICHER */
        public function recover():int
        {
            if(!file_exists($this->link))
            {
                return 0;
            }
            return (int)file_get_contents($this->link);
        }      
    }
?>