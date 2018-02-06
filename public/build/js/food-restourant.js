(function ($) {
    var img = image;
    img.inputid = $('#image');
    img.previewid = $('#file-preview');
    img.inputclick();
    function frmrestourant() {

        this.clearInput = function () {
            $('#frm-category').attr('action', _base + '/foods/restourant');
            $('input[type="text"]').val('');
            $('input[name="id"]').val(0);
            $('input[type="file"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('#file-preview').html('');
            $('input[name="_method"]').val('POST');
        }
        this.edit = function (id) {
            $('#frm-category').attr('action', _base + '/foods/restourant/' + id);
            $.ajax({
                url: _base + '/foods/restourant/' + id + '/edit',
                success: function (data) {
                    console.log('data', data);
                    if (data.code == 200) {
                        var res = data.data;
                        $('input[name="id"]').val(res.id);
                        $('input[name="restourant"]').val(res.restourant);
                        $('textarea[name="contact"]').val(res.contact);
                        $('input[name="tel"]').val(res.tel);
                        $('input[name="_method"]').val('PUT');

                        if (res.groups){
                            var $gr = res.groups;
                            $('input[name="groups[]"').each(function(i,v){
                                var val = $(this).val().toString();
                                if ($gr.indexOf(parseInt(val)) !== -1){
                                    console.log(val + ' checked true');
                                    $(this).prop('checked',true);
                                }else{
                                    console.log(val + ' checked false');
                                    $(this).prop('checked',false);
                                }
                                console.log($gr.indexOf( parseInt(val) ), ' | ', $gr ,' | ', val.toString() );
                            });

                        }else{
                            console.log('group checked false all');
                            $('input[name="groups[]"').prop('checked',false);
                        }

                        if (res.active == 'Y') {
                            $('input[name="active"]').prop('checked', true);
                        } else {
                            $('input[name="active"]').prop('checked', false);
                        }
                        if (res.image) {
                            $('#file-preview').html('<img src="' + _base + '/images/restourant/' + res.image +'" />');
                        } else {
                            $('#file-preview').html('');
                        }

                    }
                }
            });
        }

        this.delete = function (id) {
            $.ajax({
                url: _base + '/foods/restourant/' + id,
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
        $('#modal-restourant').modal('show');
    });

    $('.onEdit').on('click', function () {
        frm.edit($(this).attr('data-id'));
        $('#modal-restourant').modal('show');
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