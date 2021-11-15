<?php
include "vrstaServis.php";
include "proizvodServis.php";
include "broker.php";
class Controller{

    private $vrstaServis;
    private $proizvodServis;
    private $broker;
    private static $controller;

    private function __construct(){
        $this->broker=new Broker();
        $this->vrstaServis=new VrstaServis($this->broker);
        $this->proizvodServis=new ProizvodServis($this->broker);
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
            if($metoda!=='GET'){
                throw new Exception('Putanja nije pronadjena');
            }
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
        if($operacija=='vratiProizvode'){
            if($metoda!=='GET'){
                throw new Exception('Putanja nije pronadjena');
            }
            return $this->proizvodServis->vratiSveProizvode();
        }
        if($operacija=='kreirajProizvod'){
            if($metoda!=='POST'){
                throw new Exception('Putanja nije pronadjena');
            }
            $this->proizvodServis->kreirajProizvod($_POST['naziv'],$_POST['sifra'],$_POST['serijskiBroj'],$_POST['prodajnaCena'],$_POST['opis'],$_POST['stanje'],$_POST['kupovnaCena'],$_POST['vrsta']);
            return null;
        }
        if($operacija=='izmeniProizvod'){
            if($metoda!=='POST'){
                throw new Exception('Putanja nije pronadjena');
            }
            $this->proizvodServis->izmeniProizvod($_POST['id'],$_POST['naziv'],$_POST['sifra'],$_POST['serijskiBroj'],$_POST['prodajnaCena'],$_POST['opis'],$_POST['stanje'],$_POST['kupovnaCena'],$_POST['vrsta']);
            return null;
        }
        if($operacija=='obrisiProizvod'){
            if($metoda!=='POST'){
                throw new Exception('Putanja nije pronadjena');
            }
            $this->proizvodServis->obrisiProizvod($_POST['id']);
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