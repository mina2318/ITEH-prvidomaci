<?php
include 'header.php';

?>

<div class='container mt-3'>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forma proizvod</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="proizvodForma">
                        <div class="form-group">
                            <label for="naziv" class="col-form-label">Naziv</label>
                            <input required type="text" class="form-control" id="naziv">
                        </div>
                        <div class="form-group">
                            <label for="sifra" class="col-form-label">Sifra</label>
                            <input required type="text" class="form-control" id="sifra">
                        </div>
                        <div class="form-group">
                            <label for="serijskiBroj" class="col-form-label">Serijski broj</label>
                            <input required type="text" class="form-control" id="serijskiBroj">
                        </div>
                        <div class="form-group">
                            <label for="prodajnaCena" class="col-form-label">Prodajna cena</label>
                            <input required type="number" class="form-control" id="prodajnaCena">
                        </div>
                        <div class="form-group">
                            <label for="kupovnaCena" class="col-form-label">Kupovna cena</label>
                            <input required type="number" class="form-control" id="kupovnaCena">
                        </div>
                        <div class="form-group">
                            <label for="stanje" class="col-form-label">Stanje</label>
                            <input required type="number" class="form-control" id="stanje">
                        </div>
                        <div class="form-group">
                            <label for="vrsta" class="col-form-label">Vrsta</label>
                            <select required class="form-control" id="vrsta"></select>
                        </div>
                        <div class="form-group">
                            <label for="opis" class="col-form-label">Opis</label>
                            <textarea required type="number" class="form-control" id="opis"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary form-control">Sacuvaj</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="row mb-3">
        <div class="col-1">

        </div>
        <div class="col-10">
            <h1 class="text-center">Proizvodi</h1>
        </div>
        <div class="col-1">
            <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary width-100">Kreiraj</button>
        </div>
    </div>
    <table class="table table-light">
        <thead>
            <th>ID</th>
            <th>Naziv</th>
            <th>Sifra</th>
            <th>Serijski broj</th>
            <th>Prodajna cena</th>
            <th>Kupovna cena</th>
            <th>Stanje</th>
            <th>Vrsta</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </thead>
        <tbody id='proizvodi'>

        </tbody>
    </table>
</div>
<script>
    let selId = 0;
    $(document).ready(function () {
        ucitajProizvode();
        ucitajVrste();
        $('#proizvodForma').submit(function (e) {
            e.preventDefault();
            const naziv = $('#naziv').val();
            const sifra = $('#sifra').val();
            const serijskiBroj = $('#serijskiBroj').val();
            const prodajnaCena = $('#prodajnaCena').val();
            const kupovnaCena = $('#kupovnaCena').val();
            const stanje = $('#stanje').val();
            const vrsta = $('#vrsta').val();
            const opis = $('#opis').val();
            $.post('./server/index.php?operacija=' + (selId ? 'izmeniProizvod' : 'kreirajProizvod'), {
                sifra,
                serijskiBroj,
                prodajnaCena,
                kupovnaCena,
                stanje,
                vrsta,
                opis,
                naziv,
                id: selId
            }).then(res => {
                res = JSON.parse(res);
                if (!res.status) {
                    alert(res.error);
                }
                ucitajProizvode();
            })
        })
        $('#exampleModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)
            const id = button.data('id')
            selId = Number(id) || 0;
            const naziv = button.data('naziv')
            $('#naziv').val(naziv || '');

            const sifra = button.data('sifra')
            $('#sifra').val(sifra || '');

            const serijskiBroj = button.data('serijskibroj')
            $('#serijskiBroj').val(serijskiBroj || '');

            const prodajnaCena = button.data('prodajnacena')
            $('#prodajnaCena').val(prodajnaCena || '');

            const kupovnaCena = button.data('kupovnacena')
            $('#kupovnaCena').val(kupovnaCena || '');

            const stanje = button.data('stanje')
            $('#stanje').val(stanje || '');

            const vrsta = button.data('vrsta')
            $('#vrsta').val(vrsta || '');

            const opis = button.data('opis')
            $('#opis').val(opis || '');


        })
    })
    function ucitajVrste() {
        $.getJSON('./server/index.php?operacija=vratiVrste').then(function (res) {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let vrsta of res.data) {
                $('#vrsta').append(`
                    <option value='${vrsta.id}'>${vrsta.naziv}</option>
                `)
            }
        })
    }
    function ucitajProizvode() {
        $.getJSON('./server/index.php?operacija=vratiProizvode').then(res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            $('#proizvodi').html('');
            for (let proizvod of res.data) {
                $('#proizvodi').append(`
                    <tr>
                        <td>${proizvod.id}</td>
                        <td>${proizvod.naziv}</td>
                        <td>${proizvod.sifra}</td>
                        <td>${proizvod.serijskiBroj}</td>
                        <td>${proizvod.prodajnaCena}</td>
                        <td>${proizvod.kupovnaCena}</td>
                        <td>${proizvod.stanje}</td>
                        <td>${proizvod.vrsta?.naziv || ''}</td>
                        <td>
                            <button
                                data-toggle="modal" 
                                data-target="#exampleModal"
                                data-id="${proizvod.id}" 
                                data-naziv="${proizvod.naziv}" 
                                data-sifra="${proizvod.sifra}" 
                                data-serijskibroj="${proizvod.serijskiBroj}" 
                                data-prodajnacena="${proizvod.prodajnaCena}" 
                                data-kupovnacena="${proizvod.kupovnaCena}" 
                                data-stanje="${proizvod.stanje}" 
                                data-opis="${proizvod.opis}" 
                                data-vrsta="${proizvod.vrsta?.id || 0}" 
                                class='btn btn-success width-100'>Izmeni</button>
                        </td>
                        <td>
                            <button onClick="obrisi(${proizvod.id})" class='btn btn-danger width-100'>Obrisi</button>
                        </td>
                    </tr>
                `)
            }
        })
    }
    function obrisi(id) {
        $.post('./server/index.php?operacija=obrisiProizvod', { id }).then(res => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
            }
            ucitajProizvode();
        })
    }
</script>
<?php
include 'footer.php';

?>