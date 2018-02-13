(function ($) {
    var img = image;
    img.inputid = $('#image');
    img.previewid = $('#file-preview');
    img.inputclick();
    function frmrestourant() {

        this.clearInput = function () {
            $('#frm-category').attr('action', _base + '/payment');
            $('input[type="text"]').val('');
            $('input[name="id"]').val(0);
            $('input[type="file"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('#file-preview').html('');
            $('input[name="_method"]').val('POST');
        }
        this.edit = function (id) {
            $('#frm-category').attr('action', _base + '/payment/' + id);
            $.ajax({
                url: _base + '/payment/' + id + '/edit',
                success: function (data) {
                    console.log('data', data);
                    if (data.code == 200) {
                        var res = data.data;
                        $('input[name="id"]').val(res.id);
                        $('input[name="bank_name"]').val(res.bank_name);
                        $('input[name="bank_branch"]').val(res.bank_branch);
                        $('input[name="bank_type"]').val(res.bank_type);
                        $('input[name="bank_id"]').val(res.bank_id);
                        $('input[name="bank_account"]').val(res.bank_account);
                        $('input[name="bank_sort"]').val(res.bank_sort);
                        $('input[name="_method"]').val('PUT');

                        if (res.active == 'Y') {
                            $('input[name="active"]').prop('checked', true);
                        } else {
                            $('input[name="active"]').prop('checked', false);
                        }
                        if (res.image) {
                            $('#file-preview').html('<img src="' + _base + '/public/images/bank/' + res.bank_image + '" />');
                        } else {
                            $('#file-preview').html('');
                        }

                    }
                }
            });
        }

        this.delete = function (id) {
            $.ajax({
                url: _base + '/payment/' + id,
                method: 'POST',
                data: { _token: $('input[name="_token"]').val(), _method: 'DELETE' },
                success: function (data) {

                },
                error: function (e) {
                    console.log(e);
                }
            });
        }


    }


    var frm = new frmrestourant();
    $('#btn-new').on('click', function () {
        //alert('model');
        frm.clearInput();
        $('#modal-payment').modal('show');
    });

    $('.onEdit').on('click', function () {
        frm.edit($(this).attr('data-id'));
        $('#modal-payment').modal('show');
    });

    $('.onDelete').on('click', function (e) {
        e.preventDefault();
        var row = $(this).closest('tr');
        if (confirm('Please confirm delete this')) {
            var id = $(this).attr('data-id');
            frm.delete(id);
            row.remove();
        }
    });

    $('.btn-delete').on('click', function (e) {
        var ids = [];
        if (!confirm('Please confirm delete this selected'))
            return false;
        $('.checkboxAll').each(function (index, val) {
            var row = $(this).closest('tr');
            if ($(this).is(':checked')) {
                ids.push($(this).val());
                row.remove();
            }
        });
        frm.delete(ids.join('-'));
    });
}(jQuery));