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

    /**
     * ADD
     */

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
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * GETS
     */

    public function getTypesBreeds()
    {
        $query = "SELECT CONCAT(t.TYPE, ' - ' , B.BREED) AS animalBreeds, b.id_animal_breed from animal_breeds b
inner join animal_types t on b.id_animal_type = t.id_animal_type";

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);
            if (!empty($result)) {
                return $this->mapAnimalTypesBreeds($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function getAllSizes()
    {
        $query = "SELECT * FROM animal_sizes";
        $listAnimalSizes = array();

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            if (!empty($result)) {
                return $this->mapAnimalSizes($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function getSizeById($id)
    {
        $query = "SELECT a.size FROM animal_sizes a
                    WHERE a.id_animal_size = (:id)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters["id"] = $id;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $result[0]["size"];
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function getTypeFromBreed($id)
    {
        $query = "SELECT t.id_animal_type from animal_breeds b
inner join animal_types t on b.id_animal_type = t.id_animal_type
where id_animal_breed = (:id);";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $result[0]["id_animal_type"];
            }
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }


    /**
     * MAPS
     */

    private function mapAnimalSizes($animalSize): array
    {
        return array_map(function ($p) {
            return ["id_animal_size" => $p["id_animal_size"], "size" => $p["size"]];
        }, $animalSize);
    }

    private function mapAnimalTypesBreeds($animalBreeds): array
    {
        return array_map(function ($p) {
            return ["animalBreeds" => $p["animalBreeds"], "id_animal_breed" => $p["id_animal_breed"]];
        }, $animalBreeds);
    }


}
