<?php

namespace DAO;

use DAO\IDAO as IDAO;
use Exception;
use Models\Cat;
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

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getPets($id)
    {
        $query = "select a.*, t.id_animal_type from animals a
        inner  join animal_breeds b on a.id_animal_breed = b.id_animal_breed
        inner join animal_types t on b.id_animal_type = t.id_animal_type
        where id_owner = (:id)";
        $petArray = array();
        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                $petArray = $this->mapPets($result);
                }
        } catch (Exception $e) {
            throw $e;
        }
        return $petArray;
    }

    private function mapPets($pets)
    {
        return array_map(function ($p) {
            if ($p["id_animal_type"] == 1)
            {
                $dog = new Dog();
                $dog->setIdAnimal($p["id_animal"]);
                $dog->setName($p["name"]);
                $dog->setAge($p["age"]);
                $dog->setIdAnimalBreed($p["id_animal_breed"]);
                $dog->setPhoto($p["photo"]);
                $dog->setVaccinationPlan($p["vaccinationPlan"]);
                $dog->setIdAnimalSize($p["id_animal_size"]);
                $dog->setVideo($p["video"]);
                $dog->setObservations($p["observations"]);
                $dog->setIdOwner($p["id_owner"]);
                return $dog;

            }
            else
            {
                $cat = new Cat();
                $cat->setIdAnimal($p["id_animal"]);
                $cat->setName($p["name"]);
                $cat->setAge($p["age"]);
                $cat->setIdAnimalBreed($p["id_animal_breed"]);
                $cat->setPhoto($p["photo"]);
                $cat->setIdAnimalSize($p["id_animal_size"]);
                $cat->setVaccinationPlan($p["vaccinationPlan"]);
                $cat->setVideo($p["video"]);
                $cat->setObservations($p["observations"]);
                $cat->setIdOwner($p["id_owner"]);
                return $cat;
            }

        }, $pets);
    }

    public function findOwnerIdByUserId($id){
        $query = "select o.id_owner from users u
                  inner join owners o on u.id_user = o.id_user
                  where u.id_user = (:id)";
        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            return $result[0]['id_owner'];
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }


}
