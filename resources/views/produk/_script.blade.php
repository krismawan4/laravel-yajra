<script>
    let table, save_method, url;
    url = "{{ url('/') }}";
    console.log(url);
    $(function() {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('produk.listData') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'harga',
                    name: 'harga'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $('#form').submit(function(e) {
            e.preventDefault();
            // Serialize formulir
            let formData = $(this).serialize();
            if (save_method == 'add') {
                url_save = `${url}/produk/insert`;
            } else {
                url_save = `${url}/produk/update`;
            }
            console.log(url_save);
            $.ajax({
                url: url_save,
                type: "POST",
                dataType: "JSON",
                data: formData,
                success: function(data) {
                    toast(data.message, data.status);
                    modalHide()
                    table.ajax.reload();
                },
                error: function(error) {
                    console.log(error);
                    toast(error.message, error.status);
                }
            });
        });
    });

    function addForm() {
        save_method = 'add';
        $('.modal-title').text('Tambah Produk');
        modalReset();
        modalShow();
    }

    function editForm(id) {
        save_method = 'edit';
        $('.modal-title').text('Edit Produk');
        modalReset();
        $.ajax({
            url: `${url}/produk/edit/${id}`,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                modalShow()
                $('#id').val(data.id);
                $('#nama').val(data.nama);
                $('#harga').val(data.harga);
            },
            error: function() {
                toast('Tidak dapat menampilkan data', 500);
            }
        });
    }

    function deleteData(id) {
        if (confirm('Yakin Hapus Data?')) {
            $.ajax({
                url: `${url}/produk/delete/${id}`,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    toast(data.message, data.status);
                    table.ajax.reload();
                },
                error: function() {
                    toast(data.message, data.status);
                }
            });
        }
    }

    function modalReset() {
        const form = document.getElementById("form");
        form.reset();
    }

    function modalShow() {
        const modal = new bootstrap.Modal(document.getElementById("modal-form"));
        modal.show();
    }

    function modalHide() {
        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-form'));
        modal.hide();
    }
</script>
