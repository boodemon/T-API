(function($){
    $('.onEdit').on('click',function(e){
        e.preventDefault();
        var $id = $(this).attr('data-id');
        $('#frm-status').attr('action', _base + '/order/' + $id );
        $.ajax({
            url:_base + '/order/' + $id,
            success : function(data){
                console.log('data => ', data );
                var res = data.data;
                $('select[name="status"]').val( res.status );
            }
        });
        $('#modal-order').modal('show');
    });
}(jQuery));