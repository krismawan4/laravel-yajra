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
            if (save_method == 'POST') {
                url_save = `${url}/produk/`;
            } else {
                let id = $('#id').val();
                url_save = `${url}/produk/${id}`;
            }
            console.log(url_save);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: url_save,
                type: save_method,
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
        save_method = 'POST';
        $('.modal-title').text('Tambah Produk');
        modalReset();
        modalShow();
    }

    function editForm(id) {
        save_method = 'PUT';
        $('.modal-title').text('Edit Produk');
        modalReset();
        $.ajax({
            url: `${url}/produk/${id}/edit`,
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
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: `${url}/produk/${id}`,
                type: "DELETE",
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
