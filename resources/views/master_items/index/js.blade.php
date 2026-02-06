<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function () {
    $('#table').DataTable({
        searching: false,
        order: [[0, 'desc']],
    });

    getData();

    $('.btn-get-data').click(function () {
        getData();
    });
});

function getData() {
    $('#loading-filter').show();

    let table = $('#table').DataTable();
    table.clear().draw();

    $.ajax({
        url: '{{ url("master-items/search") }}',
        method: 'GET',
        dataType: 'json',
        data: {
            kode: $('#filter-kode').val(),
            nama: $('#filter-nama').val(),
            hargamin: $('#filter-harga-min').val(),
            hargamax: $('#filter-harga-max').val(),
        },
        success: function (res) {
            let data = res.data;

            $.each(data, function (i, item) {
                let harga_jual = Math.round(
                    item.harga_beli + (item.harga_beli * item.laba / 100)
                );

                let btnView = `
                    <a href="{{ url('master-items/view') }}/${item.kode}"
                       class="btn btn-primary btn-sm">View</a>
                `;

                table.row.add([
                    item.kode,
                    item.nama,
                    item.jenis,
                    item.harga_beli,
                    harga_jual,
                    item.supplier,
                    btnView
                ]).draw(false);
            });

            $('#loading-filter').hide();
        },
        error: function () {
            alert('Gagal mengambil data');
            $('#loading-filter').hide();
        }
    });
}

    
</script>