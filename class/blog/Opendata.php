<?php

class Opendata
{
    private $dataLink;
    private $dataUser;
    private $dataPassword;

    
    /**
     * Construction pour PDO
     *
     * @param  string $dataLink : lien de la base de donnée
     * @param  string $dataUser : nom d'utilisateur de la base de donnée
     * @param  string $dataPassword : mot de pass de la base de donnée
     * @return void
     */
    public function __construct(string $dataLink, string $dataUser = null, string $dataPassword = null)
    {
        $this->dataLink = $dataLink;
        $this->dataUser = $dataUser;
        $this->dataPassword = $dataPassword;
    }

        
    /**
     * Construit le PDO
     *
     * @return pdo
     */
    public function getPDO() 
    {
        $pdo = new PDO("'sqlite:" . $this->dataLink . "'", $this->dataUser, $this->dataPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
        return var_dump($pdo);
    }
}
?>