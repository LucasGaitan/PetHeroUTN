<?php
    namespace DAO;

    use DAO\IDAO as IDAO;
    use Models\Guardian as Guardian;

    class GuardianDAO implements IDAO
    {
        private $tableName;
        private $connection;

        function __construct()
        {
            $this->tableName = 'guardians';
        }

        public function Add($guardian)
        {
            $query = "INSERT INTO " . $this->tableName . "(salaryExpected, reputation, startDate, endDate, id_animal_size_expected, id_user) 
            VALUES (:salaryExpected, null, null, null, :id_animal_size_expected, :id)";

            try
            {
                $this->connection = Connection::GetInstance();
                $parameters['id'] = $guardian->getId();
                $parameters['salaryExpected'] = $guardian->getSalaryExpected();
                $parameters['id_animal_size_expected'] = $guardian->getId_animal_size_expected();
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }
    }
