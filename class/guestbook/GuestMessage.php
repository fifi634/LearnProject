<?php
    class Message 
    {
        const LIMITE_USERNAME = 3;
        const LIMITE_MESSAGE = 10;
        private $username;
        private $message;
        private $date;

        public static function fromJSON(string $json): Message
        {
            $data = json_decode($json, true);
            return new self($data['username'], $data['message'], new DateTime("@" . $data['date'])); 
        }
        
        public function __construct(string $username, string $message, ?DateTime $date=NULL)
        {
            $this->username = $username;
            $this->message = $message;
            $this->date = $date ?: new DateTime();           
        }

        public function isValid(): bool
        {
            return empty($this->getErrors());
        }

        public function getErrors(): array
        {
            $errors = [];
            if(strlen($this->username) < self::LIMITE_USERNAME) 
            {
                $errors['username'] = 'Votre pseudonyme est trop court';
            }
            if(strlen($this->message) < self::LIMITE_MESSAGE) 
            {
                $errors['message'] = 'Votre message est trop court';
            }
            return $errors;
        }

        public function toHTML():string
        {
            $username = htmlentities($this->username);
            $this->date->setTimezone(new DateTimeZone('Europe/Paris'));
            $date = $this->date->format('d/m/Y à H:i');
            $message = nl2br(htmlentities($this->message));
            return <<<HTML
                <p>
                    <strong>{$username}</strong> <em>le {$date}</em><br>
                    {$message}
                </p>
HTML;
        }

        public function toJSON(): string
        {
            return json_encode([
                'username' => $this->username,
                'message' => $this->message,
                'date' => $this->date->getTimestamp()
            ]);
        }
    }
?>