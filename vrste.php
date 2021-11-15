<?php
include 'header.php';

?>

<div class='container mt-3'>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forma vrsta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="vrstaForma">
                        <div class="form-group">
                            <label for="naziv" class="col-form-label">Naziv</label>
                            <input required type="text" class="form-control" id="naziv">
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
            <h1 class="text-center">Vrste proizvoda</h1>
        </div>
        <div class="col-1">
            <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary width-100">Kreiraj</button>
        </div>
    </div>
    <table class="table table-light">
        <thead>
            <th>ID</th>
            <th>Naziv</th>
            <th>Izmeni</th>
            <th>Obrisi</th>
        </thead>
        <tbody id='vrste'>

        </tbody>
    </table>
</div>
<script>
    let selId = 0;
    $(document).ready(function () {
        ucitajVrste();
        $('#vrstaForma').submit(function (e) {
            e.preventDefault();
            const naziv = $('#naziv').val();
            $.post('./server/index.php?operacija=' + (selId ? 'izmeniVrstu' : 'kreirajVrstu'), { naziv, id: selId }).then(res => {
                res = JSON.parse(res);
                if (!res.status) {
                    alert(res.error);
                }
                ucitajVrste();
            })
        })
        $('#exampleModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget)
            const id = button.data('id')
            selId = Number(id) || 0;
            const naziv = button.data('naziv')
            $('#naziv').val(naziv || '');

        })
    })
    function ucitajVrste() {
        $.getJSON('./server/index.php?operacija=vratiVrste').then(res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            $('#vrste').html('');
            for (let vrsta of res.data) {
                $('#vrste').append(`
                    <tr>
                        <td>${vrsta.id}</td>
                        <td>${vrsta.naziv}</td>
                        <td>
                            <button  data-toggle="modal" data-target="#exampleModal" data-id="${vrsta.id}" data-naziv="${vrsta.naziv}" class='btn btn-success width-100'>Izmeni</button>
                        </td>
                        <td>
                            <button onClick="obrisi(${vrsta.id})" class='btn btn-danger width-100'>Obrisi</button>
                        </td>
                    </tr>
                `)
            }
        })
    }
    function obrisi(id) {
        $.post('./server/index.php?operacija=obrisiVrstu', { id }).then(res => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
            }
            ucitajVrste();
        })
    }
</script>
<?php
include 'footer.php';

?>