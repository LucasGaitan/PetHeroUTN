<?php
    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;

    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();

        public function Add(Owner $owner)
        {
            $this->RetrieveData();

            array_push($this->ownerList, $owner);

            $this->SaveData();
        }

        public function GetAll(): array
        {
            $this->RetrieveData();

            return $this->ownerList;
        }

        private function SaveData()
        {
            $arrayToEncode = array();
            $dogs = array();
            $dogsToJSON = array();
            foreach($this->ownerList as $owner)
            {

                $valuesArray["firstName"] = $owner->getFirstName();
                $valuesArray["lastName"] = $owner->getLastName();
                $valuesArray["username"] = $owner->getUsername();
                $valuesArray["password"] = $owner->getPassword();
                $dogs = $owner->getDogs();
                if (!empty($dogs)){
                    var_dump($dogs);
                    foreach ($dogs as $dog)
                    {

                        /*$valuesArray["dogName"] = $dog->getName();
                        $dogsToJSON[] = $valuesArray["dogName"];*/
                        //$dogsToJSON[] = json_encode($dogs, JSON_PRETTY_PRINT);
                    }
                    $valuesArray["dogs"] = $dogsToJSON;
                }



                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents('Data/owners.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->ownerList = array();

            if(file_exists('Data/owners.json'))
            {
                $jsonContent = file_get_contents('Data/owners.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $owner = new owner();
                    $owner->setFirstName($valuesArray["firstName"]);
                    $owner->setLastName($valuesArray["lastName"]);
                    $owner->setUsername($valuesArray["username"]);
                    $owner->setPassword($valuesArray["password"]);
                    $owner->setDogs($valuesArray["dogs"]);

                    array_push($this->ownerList, $owner);
                }
            }
        }
    }
