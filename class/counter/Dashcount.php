<?php
    require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'counter' . DIRECTORY_SEPARATOR . 'Counter.php';

    /** COMPTEUR DASHBOARD */
    class Dashcount extends Counter 
    {
        /** COMPTEUR DE VISITEUR GLOBAL */
        public function gcount():int
        { 
            if(file_exists($this->link)) 
            {
                $count = (int)file_get_contents($this->link);
            } 
            else 
            {
                $count = (int)file_put_contents($this->link, 0);
            }

            if(!isset($_SESSION['countsession'])) 
            {
                $_SESSION['countsession'] = true;
                $count ++;
                file_put_contents($this->link, $count);
            }
            return $count;
        }     

         /** COMPTEUR DE VISITEUR jour par jour pour dashboard */
         public function daystat():void 
         {                 
            if(!isset($_SESSION['dashboard'])) 
            {
                $_SESSION['dashboard'] = true;
                parent::increment();
            }
         }

        /** TOTAL DE PAGE CREER */
        public function totalpage(): int 
        {
            $totalpage = 0;

            foreach(glob($this->link . "*") as $filename) 
            {
                $totalpage += (int)file_get_contents($filename);
            }
            return $totalpage;
        }

        /** TOTAL PAGE MOIS SELECTIONNE */
        public function pagemonth($selectyears, $selectmonth): int 
        {
            $selectmonth = str_pad($selectmonth, 2, "0", STR_PAD_LEFT);
            $monthpage = 0;
            $link = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'page ' . $selectyears . '-' . $selectmonth . '-';
            
            foreach(glob($link . "*") as $filename) 
            {
                $monthpage += (int)file_get_contents($filename);
            }
            return $monthpage;
        }

        /** COMPTEUR VISITEUR MOIS SELECTIONNE */
        public function visitmonth($selectyears, $selectmonth): int 
        {
            $selectmonth = str_pad($selectmonth, 2, "0", STR_PAD_LEFT);
            $visitmonth = 0;
            $link = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'stat ' . $selectyears . '-' . $selectmonth . '-';
            
            foreach(glob($link . "*") as $filename) 
            {
                $visitmonth += (int)file_get_contents($filename);
            }
            return $visitmonth;
        }

        /** DETAIL PAGE MOIS */
        public function detailpage($selectyears, $selectmonth): array 
        {
            $selectmonth = str_pad($selectmonth, 2, "0", STR_PAD_LEFT);
            $detailpage = [];
            $link = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'page ' . $selectyears . '-' . $selectmonth . '-';
            
            $files = glob($link . "*");

            foreach($files as $file) 
            {
                $filepart = explode('-', basename($file));
                $detailpage [] = [
                    'day' => $filepart[2],
                    'visits' => (int)file_get_contents($file)
                ];
            }
            return $detailpage;
        }
    }