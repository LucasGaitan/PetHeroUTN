<?php
namespace DAO;

use \PDO as PDO;
use \Exception as Exception;

class Connection {

    private $pdo = null;
    private $pdoStatement = null;
    private static $instance = null;

    public function __construct()
    {
        try {
            $this->pdo = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetPdo() // SINGLETON
    {
        return $this->pdo;
    }

    public static function GetInstance()
    {
        if(self::$instance == null)
            self::$instance = new Connection();

        return self::$instance;
    }

    public function Execute($query, $parameters = array())
    {

        try {

            // Creo una sentencia llamando a prepare. Esto devuelve un objeto statement
            $this->pdoStatement = $this->pdo->prepare($query);  // PREPARO LA CONSULTA PARA MANDARLA A LA BASE DE DATOS

            foreach($parameters as $parameterName => $value) {
                //$this->pdoStatement->bindParam(":".$parameterName, $value);  // para verificar, y queda lista la consulta con los valores q trae el objeto pasado x parametro q solicito este execute
                $this->pdoStatement->bindParam(":$parameterName", $parameters[$parameterName]);
                // estar atento a futuros conflictos
            }
            $this->pdoStatement->execute();

            return $this->pdoStatement->fetchAll(); // devuelve registros
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ExecuteNonQuery($query, $parameters = array())
    {
        try
        {
            // Creo una sentencia llamando a prepare. Esto devuelve un objeto statement
            $this->pdoStatement = $this->pdo->prepare($query);
            foreach($parameters as $parameterName => $value) {
                // Reemplazo los marcadores de parametro por los valores reales utilizando el método bindParam().
                $this->pdoStatement->bindParam(":$parameterName", $parameters[$parameterName]);
            }
            $this->pdoStatement->execute();

            return $this->pdoStatement->rowCount();
        }
        catch(\PDOException $ex)
        {
            throw $ex;
        }
    }
}
?>
