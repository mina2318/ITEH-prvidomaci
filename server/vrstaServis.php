
<?php

class VrstaServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSveVrste(){
        return $this->broker->izvrsiCitanje("select * from vrsta_proizvoda");
    }

    public function kreirajVrstu($naziv){
        if(!isset($naziv)){
            throw new Exception("Naziv nije prosledjen");
        }
        $this->broker->izvrsiIzmenu("insert into vrsta_proizvoda(naziv) values ('".$naziv."')");
    }
    public function izmeniVrstu($id,$naziv){
        if(!isset($id)){
            throw new Exception("id nije prosledjen");
        }
        if(!isset($naziv)){
            throw new Exception("Naziv nije prosledjen");
        }
        $this->broker->izvrsiIzmenu("update vrsta_proizvoda set naziv='".$naziv."' where id=".$id);
    }
    public function obrisiVrstu($id){
        if(!isset($id)){
            throw new Exception("id nije prosledjen");
        }
        $this->broker->izvrsiIzmenu("delete from vrsta_proizvoda where id=".$id);
    }
   
}

?>