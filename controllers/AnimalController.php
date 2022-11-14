<?php

namespace Controllers;

use DAO\AnimalDAO;
use DAO\OwnerDAO;
use Exception;
use Models\Cat;
use Models\Owner;
use Models\Dog;

class AnimalController
{
    private $animalDAO;

    public function __construct()
    {
        $this->animalDAO = new AnimalDAO();
    }

    public function animalForm($animalName, $age, $breed, $photo, $vaccinationPlan, $video, $observations, $size)
    {
        session_start();
        try {
            if ($this->animalDAO->getTypeFromBreed($breed) === 1) {
                $dog = new Dog();
                $dog->setName($animalName);
                $dog->setAge($age);
                $dog->setIdAnimalBreed($breed);
                $dog->setPhoto($_FILES["photo"]['name']);
                $dog->setVaccinationPlan($_FILES["vaccinationPlan"]['name']);
                $dog->setVideo($video);
                $dog->setObservations($observations);
                $dog->setIdAnimalSize($size);
                $dog->setIdOwner($_SESSION["user"]->getIdOwner());
                $this->subirArch("photo", $photo, "animalPhoto/");
                $this->subirArch("vaccinationPlan", $vaccinationPlan, "vaccinationPlan/");

                $this->animalDAO->Add($dog);

                header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=2");
            } else {
                $cat = new Cat();
                $cat->setName($animalName);
                $cat->setAge($age);
                $cat->setIdAnimalBreed($breed);
                $cat->setPhoto($_FILES["photo"]['name']);
                $cat->setVaccinationPlan($_FILES["vaccinationPlan"]['name']);
                $cat->setVideo($video);
                $cat->setObservations($observations);
                $cat->setIdAnimalSize($size);
                $cat->setIdOwner($_SESSION["user"]->getIdOwner());
                $this->subirArch("photo", $photo, "animalPhoto/");
                $this->subirArch("vaccinationPlan", $vaccinationPlan, "vaccinationPlan/");

                $this->animalDAO->Add($cat);

                header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=2");

            }
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];

            #QUEDA PENDIENTE VER A DONDE MANDAR

            //header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=2");
        }
    }

    public function subirArch($nombreArch, $arch, $path)
    {
        //var_dump($arch);
        if (isset($arch)) {
            //Recogemos el archivo enviado por el formulario
            $archivo = $_FILES[$nombreArch]['name'];
            //Si el archivo contiene algo y es diferente de vacio
            if (isset($archivo) && $archivo != "") {
                $tipo = $_FILES[$nombreArch]['type'];
                $tamano = $_FILES[$nombreArch]['size'];
                $temp = $_FILES[$nombreArch]['tmp_name'];

                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!((strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 10000000000000))) {
                    throw new Exception("The image does not comply with the expected formats (jpeg, jpg, png, size < 200kb).");
                } else {

                    //Si la imagen es correcta en tamaño y tipo
                    //Se intenta subir al servidor
                    if (move_uploaded_file($temp, UPLOADS_PATH . $path . $archivo)) {
                        //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        chmod(UPLOADS_PATH . $path . $archivo, 0777);

                    } else {
                        throw new Exception("The image could not be uploaded correctly.");
                    }
                }
            }
        }
    }
}