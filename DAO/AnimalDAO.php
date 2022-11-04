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

    public function Add($animal)
    {
        $query = "INSERT INTO " . $this->tableName . "(name, age, photo, vaccinationPlan, video, observations, id_animal_size, id_animal_breed, id_owner)
         VALUES (:name, :age, :photo, :vaccinationPlan, :video, :observations, :id_animal_size, :id_animal_breed, :id_owner)";
        try {
            $this->connection = Connection::GetInstance();
            $parameters['name'] = $animal->getName();
            $parameters['age'] = $animal->getAge();
            $parameters['photo'] = $animal->getPhoto();
            $parameters['vaccinationPlan'] = $animal->getVaccinationPlan();
            $parameters['video'] = $animal->getVideo();
            $parameters['observations'] = $animal->getObservations();
            $parameters['id_animal_size'] = $animal->getIdAnimalSize();
            $parameters['id_animal_breed'] = $animal->getIdAnimalBreed();
            $parameters['id_owner'] = $animal->getIdOwner();
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
