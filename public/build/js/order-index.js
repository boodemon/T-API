function orders(){
    this.delete = function (id) {
        $.ajax({
            url: _base + '/order/' + id,
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
(function($){

    var frm = new orders();
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

        $('.onEdit').on('click',function(e){
            e.preventDefault();
            var $id = $(this).attr('data-id');
            $.ajax({
                url:_base + '/order/' + $id,
                success : function(data){
                    console.log('data => ', data );
                    var res = data.data;
                    $('select[name="status"]').val( res.status );
                    $('#frm-status').attr('action', _base + '/order/' + $id );
                }
            });
            $('#modal-order').modal('show');
        });

        $('.onTracking').on('click',function(e){
            e.preventDefault();
            var $id = $(this).attr('data-id');
            $.ajax({
                url:_base + '/order/tracking/' + $id,
                success : function(data){
                    console.log('tracking data => ', data );
                    var track = '';
                    $('.orderId').html( '#' + data.orderId);
                    $.each(data.data,function(i,v){
                        console.log('img length ' , v.attach.length );
                        track += '<div class="card">'
                                        +'<div class="card-header">'
                                            +'<div class="row">'
                                                +'<div class="col-md-6">'
                                                    +' <i class="fa fa-truck fa-1x text-warning"></i> '+ v.created_date
                                                    +' <i class="fa fa-clock-o fa-1x text-secondary"></i> '+ v.created_time
                                                +'</div>'
                                                +'<div class="col-md-6 text-right">'
                                                    +( v.admin_id != 0 ? ' <i class="icon-user text-primary"></i> ' + v.admin : '' )
                                                    +( v.user_id != 0 ? ' <i class="icon-people text-success"></i> ' + v.user : '' )
                                                +'</div>'
                                            +'</div>'
                                        +'</div>'
                                        +'<div class="card-body">'
                                            + v.tracking_name
                                            + ( v.attach.length === undefined ? '<hr/>'
                                                        +'<strong>Attach</strong><br/>'
                                                        +'<img src="'+ v.attach.attach_img +'" class="img-responsive"/>'
                                                : ''
                                                )
    
                                        +'</div>'
                                    +'</div>';
                        console.log('i:',i,'v:',v);
                    });
                    $('.tracking-view').html( track );
                }
            });
            $('#modal-tracking').modal('show');
        });

        $('.btn-filter').on('click',function(e){
            $('#order-filter').modal('show');
        });

}(jQuery));