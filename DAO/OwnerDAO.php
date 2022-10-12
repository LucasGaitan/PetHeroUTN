<?php
    namespace DAO;

    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Dog;

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
            $dogsToJSON = array();

            foreach($this->ownerList as $owner)
            {
                $valuesArray["firstName"] = $owner->getFirstName();
                $valuesArray["lastName"] = $owner->getLastName();
                $valuesArray["username"] = $owner->getUsername();
                $valuesArray["password"] = $owner->getPassword();

                $dogList = $owner->getDogs();
//                $valuesArray["dogs"] = $owner->getDogs();

                if (!empty($dogList[0]))
                {

                    var_dump($dogList);
                    echo '<br>';
                    var_dump(count($dogList));

                    $i = 0;

                    foreach ($dogList as $dog)
                    {

                        $valuesDog["dogName"] = $dog->getName();
                        $valuesDog["age"] = $dog->getAge();
                        $valuesDog["size"] = $dog->getSize();

//                        $valuesDog["dog" . ($i+1)]["dogName"] = $dog->getName();
//                        $valuesDog["dog" . ($i+1)]["age"] = $dog->getAge();
//                        $valuesDog["dog" . ($i+1)]["size"] = $dog->getSize();

                        $valuesArray["dogs"] = $valuesDog;

                        $i++;
                    }
                }
                else
                {
                    $valuesArray["dogs"] = [];
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
                    $owner->setAllDogs($valuesArray["dogs"]);

                    array_push($this->ownerList, $owner);
                }
            }
        }
    }
