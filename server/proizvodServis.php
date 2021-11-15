
<?php

class ProizvodServis{

    private $broker;

    public function __construct($b){
        $this->broker=$b;
    }
    public function vratiSveProizvode(){
        $data= $this->broker->izvrsiCitanje("select p.*,v.naziv as 'naziv_vrste' from proizvod p left join vrsta_proizvoda v on(p.vrsta_id=v.id)");
        $res=[];
        foreach ($data as $red) {
            $val=[
                "id"=>$red->id,
                "naziv"=>$red->naziv,
                "sifra"=>$red->sifra,
                "serijskiBroj"=>$red->serijski_broj,
                "prodajnaCena"=>$red->prodajna_cena,
                "opis"=>$red->opis,
                "stanje"=>$red->stanje,
                "kupovnaCena"=>$red->kupovna_cena,
               
            ];
            if(isset($red->vrsta_id)){
                $val['vrsta']['id']=$red->vrsta_id;
                $val['vrsta']['naziv']=$red->naziv_vrste;
            }
            $res[]=$val;
        }
        return $res;
    }

    public function kreirajProizvod($naziv,$sifra,$serijskiBroj,$prodajnaCena,$opis,$stanje,$kupovnaCena,$vrstaId){
        if(!isset($naziv)){
            throw new Exception("naziv nije prosledjen");
        }
        if(!isset($sifra)){
            throw new Exception("Sifra nije prosledjena");
        }
        if(!isset($serijskiBroj)){
            throw new Exception("serijski broj nije prosledjen");
        }
        if(!isset($prodajnaCena)){
            throw new Exception("prodajna cena nije prosledjena");
        }
        if(!isset($opis)){
            throw new Exception("opis nije prosledjen");
        }
        if(!isset($stanje)){
            throw new Exception("stanje nije prosledjeno");
        }
        if(!isset($kupovnaCena)){
            throw new Exception("kupovna cena nije prosledjene");
        }
        if(!isset($vrstaId)){
            throw new Exception("vrsta nije prosledjene");
        }
        $this->broker->izvrsiIzmenu("insert into proizvod(naziv,sifra,serijski_broj,prodajna_cena,opis,stanje,kupovna_cena,vrsta_id) values ('".$naziv."','".$sifra."','".$serijskiBroj."',".$prodajnaCena.",'".$opis."',".$stanje.",".$kupovnaCena.",".$vrstaId.")");
    }
    public function izmeniProizvod($id,$naziv,$sifra,$serijskiBroj,$prodajnaCena,$opis,$stanje,$kupovnaCena,$vrstaId){
        if(!isset($id)){
            throw new Exception("id nije prosledjen");
        }
        if(!isset($naziv)){
            throw new Exception("naziv nije prosledjen");
        }
        if(!isset($sifra)){
            throw new Exception("Sifra nije prosledjena");
        }
        if(!isset($serijskiBroj)){
            throw new Exception("serijski broj nije prosledjen");
        }
        if(!isset($prodajnaCena)){
            throw new Exception("prodajna cena nije prosledjena");
        }
        if(!isset($opis)){
            throw new Exception("opis nije prosledjen");
        }
        if(!isset($stanje)){
            throw new Exception("stanje nije prosledjeno");
        }
        if(!isset($kupovnaCena)){
            throw new Exception("kupovna cena nije prosledjene");
        }
        if(!isset($vrstaId)){
            throw new Exception("vrsta nije prosledjene");
        }
        $this->broker->izvrsiIzmenu("update proizvod set naziv='".$naziv."',opis='".$opis."', sifra='".$sifra."',serijski_broj='".$serijskiBroj."', kupovna_cena=".$kupovnaCena.", prodajna_cena=".$prodajnaCena.", stanje=".$stanje.", vrsta_id=".$vrstaId." where id=".$id);
    }
    public function obrisiProizvod($id){
        if(!isset($id)){
            throw new Exception("id nije prosledjen");
        }
        $this->broker->izvrsiIzmenu("delete from proizvod where id=".$id);
    }
    
}

?>