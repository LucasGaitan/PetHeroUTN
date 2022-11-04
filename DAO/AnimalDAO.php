<?php

namespace DAO;

use DAO\IDAO as IDAO;
use Exception;
use Models\Owner as Owner;
use Models\Dog;

class AnimalDAO implements IDAO
{
    private $tableName;
    private $connection;

    function __construct()
    {
        $this->tableName = 'animals';
    }

    public function Add($id)
    {
        $query = "INSERT INTO " . $this->tableName . "(id_user) VALUES (:id)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getAllTypes(): array
    {
        $query = "SELECT * FROM animal_types";
        $listAnimalTypes = array();

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            if (!empty($result)) {
                $listAnimalTypes = $this->mapAnimalTypes($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $listAnimalTypes;
    }

    public function getTypesBreeds()
    {
        $query = "SELECT CONCAT(t.TYPE, ' - ' , B.BREED) AS animalBreeds, b.id_animal_breed from animal_breeds b
inner join animal_types t on b.id_animal_type = t.id_animal_type";
        $listAnimalTypes = array();


        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            var_dump($result);
            if (!empty($result)) {
                $listAnimalTypes = $this->mapAnimalTypesBreeds($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $listAnimalTypes;
    }

    public function getAllSizes(): array
    {
        $query = "SELECT * FROM animal_sizes";
        $listAnimalSizes = array();

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            if (!empty($result)) {
                $listAnimalSizes = $this->mapAnimalSizes($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return $listAnimalSizes;
    }

    public function getTypeFromBreed($id)
    {
        $query = "SELECT t.id_animal_type from animal_breeds b
inner join animal_types t on b.id_animal_type = t.id_animal_type
where id_animal_breed = (:id);";
        $listAnimalTypes = array();

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            $result = $result[0]["id_animal_type"];
        } catch (Exception $e) {
            throw $e;
        }
        return $result;
    }


    private function mapAnimalTypes($animalType): array
    {
        return array_map(function ($p) {
            $animalTypes = ["id_animal_type" => $p["id_animal_type"], "type" => $p["type"]];
            return $animalTypes;
        }, $animalType);
    }

    private function mapAnimalSizes($animalSize): array
    {
        return array_map(function ($p) {
            $animalSizes = ["id_animal_size" => $p["id_animal_size"], "size" => $p["size"]];
            return $animalSizes;
        }, $animalSize);
    }

    private function mapAnimalTypesBreeds($animalBreeds): array
    {
        return array_map(function ($p) {
            $animalBreeds = ["animalBreeds" => $p["animalBreeds"], "id_animal_breed" => $p["id_animal_breed"]];
            return $animalBreeds;
        }, $animalBreeds);
    }


}
