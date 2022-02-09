<?php
require_once 'exceptions/CurlException.php';
require_once 'exceptions/HTTPException.php';
require_once 'exceptions/UnauthorizedHTTPException.php';    
    /**
     * API "OpenWeather" récupére la météo
     * 
     * @author fifi <contact@laradiodefifi.fr>
     */
    class OpenWeather
    {
        private $apiKey;

        public function __construct(string $apiKey)
        {
            $this->apiKey = $apiKey;
        }
        
        /**
         * Récupére la météo du jour
         *
         * @param  string $lat : Latitude du lieu (42.7057991028)
         * @param  string $long : Longitude du lieu (3.0085299015)
         * @return array
         */
        public function getToday(string $lat, string $long): array
        {
            $data = $this->callAPI("weather?lat={$lat}&lon={$long}&appid={$this->apiKey}");
            return
            [
                'temp'        => $data['main']['temp'],
                'description' => $data['weather'][0]['description'],
                'date'        => new DateTime()                           
            ];
        }
        
        /**
         * Récupére la météo sur plusieurs jours
         *
         * @param  string $lat Latitude du lieu (42.7057991028)
         * @param  string $long Longitude du lieu (3.0085299015)
         * @return array[]
         */
        public function getForecast(string $lat, string $long): array
        {
            $data = $this->callAPI("onecall?lat={$lat}&lon={$long}");  
            $i = 0;     
            foreach($data['daily'] as $day)
            {
                if($i++ < 1)
                {
                    continue;
                }
            $results[]  =
                [
                    'temp'        => $day['temp']['day'],
                    'description' => $day['weather'][0]['description'],
                    'date'        => new DateTime('@' . $day['dt'])                           
                ];
            }
            return $results;
        }
        
        /**
         * Appelle l'API Météo 'OpenWeather'
         *
         * @param  mixed $endpoint Appelle de l'action (weather, onecall)
         * 
         * @throws CurlException Erreur au niveau de Curl
         * @throws UnauthorizedHTTPException API non autorisé
         * @throws HTTPException Erreur HTTP
         * 
         * @return array
         */
        private function callAPI(string $endpoint): array
        {
            $curl = curl_init("https://api.openweathermap.org/data/2.5/{$endpoint}&appid={$this->apiKey}&units=metric&lang=fr&exclude=minutely,hourly,alerts,current");
            curl_setopt_array($curl, [
                CURLOPT_CAINFO => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'OpenWeathermap-org.pem',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 1
            ]);
            $data = curl_exec($curl);

            //Gestions Erreurs
            if($data === false)
            {
                throw new CurlException($curl);
            }
            $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if($code !== 200)
            {
                curl_close($curl);
                if($code === 401)
                {
                    $data = json_decode($data, true);
                    throw new UnauthorizedHTTPException($data['message'], 401);
                }
                throw new HTTPException($data, curl_getinfo($curl, CURLINFO_HTTP_CODE));
                
            }
            return $data = json_decode($data, true);
        }
    }
?>