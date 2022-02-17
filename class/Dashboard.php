<?php 
    namespace Fifi;
    
    class dashboard
    {
        protected $link;


        public function __construct(string $link)
        {
            $this->link = $link;
        }

        

        //COMPTEUR DE VISITEUR jour par jour pour dashboard
        public function daystat():void 
        {
            $link = dirname(__DIR__) . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "Compteur de vues" . DIRECTORY_SEPARATOR . "stat ". date('Y-m-d');
        
            if(file_exists($link)) 
            {
                $statcount = (int)file_get_contents($link);
            } else {
                $statcount = (int)file_put_contents($link, 0);
            }
        
            if(!isset($_SESSION['dashboard'])) 
            {
                $_SESSION['dashboard'] = true;
                $statcount = $statcount + 1;
                file_put_contents($link, $statcount);
            }
        }

        //TOTAL DE PAGE CREER
        public function totalpage(): int 
        {
            $totalpage = 0;
            $link = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'page ';
            
            foreach(glob($link . "*") as $filename) 
            {
                $totalpage += (int)file_get_contents($filename);
            }
            return $totalpage;
        }

        //TOTAL PAGE MOIS SELECTIONNE
        public function pagemonth($selectyears, $selectmonth): int 
        {
            $selectmonth = str_pad($selectmonth, 2, "0", STR_PAD_LEFT);
            $monthpage = 0;
            $link = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'page ' . $selectyears . '-' . $selectmonth . '-';
            
            foreach(glob($link . "*") as $filename) 
            {
                $monthpage += (int)file_get_contents($filename);
            }
            return $monthpage;
        }

        //DETAIL PAGE MOIS
        public function detailpage($selectyears, $selectmonth): array 
        {
            $selectmonth = str_pad($selectmonth, 2, "0", STR_PAD_LEFT);
            $detailpage = [];
            $link = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'Compteur de vues' . DIRECTORY_SEPARATOR . 'page ' . $selectyears . '-' . $selectmonth . '-';
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