<?php
include "vrstaServis.php";
include "broker.php";
class Controller{

    private $vrstaServis;
    private $broker;
    private static $controller;

    private function __construct(){
        $this->broker=new Broker();
        $this->vrstaServis=new VrstaServis($this->broker);
    }

    public static function getController(){
        if(!isset($controller)){
            $controller=new Controller();
        }
        return $controller;
    }

    public function obradiZahtev(){
        try {
            echo json_encode($this->vratiOdgovor($this->izvrsi()));
        } catch (Exception $ex) {
            echo json_encode($this->vratiGresku($ex->getMessage()));
        }
    }

    private function izvrsi(){
        $operacija=$_GET["operacija"];
        $metoda=$_SERVER['REQUEST_METHOD'];
        if($operacija=='vratiVrste'){
            return $this->vrstaServis->vratiSveVrste();
        }
        if($operacija=='kreirajVrstu'){
            if($metoda!=='POST'){
                throw new Exception('Putanja nije pronadjena');
            }
            $this->vrstaServis->kreirajVrstu($_POST['naziv']);
            return null;
        }
        if($operacija=='izmeniVrstu'){
            if($metoda!=='POST'){
                throw new Exception('Putanja nije pronadjena');
            }
            $this->vrstaServis->izmeniVrstu($_POST['id'],$_POST['naziv']);
            return null;
        }
        if($operacija=='obrisiVrstu'){
            if($metoda!=='POST'){
                throw new Exception('Putanja nije pronadjena');
            }
            $this->vrstaServis->obrisiVrstu($_POST['id']);
            return null;
        }
        throw new Exception('Operacija nije podrzana');
    }

     private function vratiOdgovor($podaci){
        if(!isset($podaci)){
            return[
                "status"=>true,
            ];
        }
        return[
            "status"=>true,
            "data"=>$podaci
        ];
    }
     private function vratiGresku($greska){
        return[
            "status"=>false,
            "error"=>$greska
        ];
    }
}

Controller::getController()->obradiZahtev();


?>