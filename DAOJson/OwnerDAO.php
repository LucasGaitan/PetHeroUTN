<?php
    namespace DAOJson;

    use DAO\IOwnerDAO as IOwnerDAO;
    use Models\Owner as Owner;
    use Models\Dog;

    class OwnerDAO implements IOwnerDAO
    {
        private $ownerList = array();

        public function Add(Owner $owner)
        {
            $this->RetrieveData();
            $i = 0;
            $flag = false;

            if(!empty($this->ownerList[0]))
            {
                do
                {
                    if ($this->ownerList[$i]->getUsername() === $owner->getUsername())
                    {
                        $flag = true;
                        $this->ownerList[$i] = $owner;
                    }
                    $i++;
                }while ($i < count($this->ownerList) && !$flag);
            }


            if (!$flag)
            {
                array_push($this->ownerList, $owner);
            }

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

            foreach($this->ownerList as $owner)
            {

                $valuesArray["firstName"] = $owner->getFirstName();
                $valuesArray["lastName"] = $owner->getLastName();
                $valuesArray["username"] = $owner->getUsername();
                $valuesArray["password"] = $owner->getPassword();
                $valuesArray["dogs"] = array();
                $dogs = $owner->getDogs();

                if (!empty($dogs[0]))
                {
                    foreach ($dogs as $dog)
                    {
                        $valuesArray["dogs"][] = array("name"=>$dog->getName(), "age"=>$dog->getAge(), "size"=>$dog->getSize());
                    }
                }
                else
                {
                    $valuesArray["dogs"]= [];
                }

                $arrayToEncode[] = $valuesArray;
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
