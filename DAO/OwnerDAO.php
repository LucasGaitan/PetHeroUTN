<?php
    namespace DAO;

    use DAO\IDAO as IDAO;
    use Models\Owner as Owner;
    use Models\Dog;

    class OwnerDAO implements IDAO
    {
        private $tableName;
        private $connection;

        function __construct()
        {
            $this->tableName = 'owners';
        }

        public function Add($id)
        {
            $query = "INSERT INTO " . $this->tableName . "(id_user) VALUES (:id)";

            try
            {
                $this->connection = Connection::GetInstance();
                $parameters['id'] = $id;
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }
    }
