<?php
    namespace DAOJson;

    use DAO\IDAO as IGuardianDAO;
    use Models\Guardian as Guardian;

    class GuardianDAO implements IDAO
    {
        private $guardianList = array();

        public function Add(Guardian $guardian)
        {
            $this->RetrieveData();

            $i = 0;
            $flag = false;

            if (!empty($this->guardianList[0]))
            {
                do
                {
                    if ($this->guardianList[$i]->getUsername() === $guardian->getUsername())
                    {
                        $flag = true;
                        $this->guardianList[$i] = $guardian;
                    }
                    $i++;
                }while ($i < count($this->guardianList) && !$flag);
            }
            if (!$flag)
            {
                array_push($this->guardianList, $guardian);
            }

            $this->SaveData();
        }

        public function GetAll(): array
        {
            $this->RetrieveData();

            return $this->guardianList;
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->guardianList as $guardian)
            {

                $valuesArray["firstName"] = $guardian->getFirstName();
                $valuesArray["lastName"] = $guardian->getLastName();
                $valuesArray["username"] = $guardian->getUsername();
                $valuesArray["password"] = $guardian->getPassword();
                $valuesArray["dogTypeExpected"] = $guardian->getDogTypeExpected();
                $valuesArray["postulation"] = array();

                $postulations = $guardian->getPostulation();

                if (!empty($postulations[0]))
                {
                    foreach ($postulations as $post){
                        $valuesArray["postulation"][] = array("startDate"=>$post->getStartDate(), "endDate"=>$post->getEndDate()
                        , "hoursPerDay"=> $post->getHoursPerDay(), "description"=>$post->getDescription());

                    }
                }
                else
                {
                    $valuesArray["postulation"]= [];
                }

                $valuesArray["reputation"] = $guardian->getReputation();
                $valuesArray["salaryExpected"] = $guardian->getSalaryExpected();
                

                $arrayToEncode[] = $valuesArray;
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents('Data/guardians.json', $jsonContent);
        }

        private function RetrieveData()
        {
            $this->guardianList = array();

            if(file_exists('Data/guardians.json'))
            {
                $jsonContent = file_get_contents('Data/guardians.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $guardian = new Guardian();
                    $guardian->setFirstName($valuesArray["firstName"]);
                    $guardian->setLastName($valuesArray["lastName"]);
                    $guardian->setUsername($valuesArray["username"]);
                    $guardian->setPassword($valuesArray["password"]);
                    $guardian->setDogTypeExpected($valuesArray["dogTypeExpected"]);
                    $guardian->setAllPostulations($valuesArray["postulation"]);
                    $guardian->setReputation($valuesArray["reputation"]);
                    $guardian->setSalaryExpected($valuesArray["salaryExpected"]);

                    array_push($this->guardianList, $guardian);
                }
            }
        }
    }
