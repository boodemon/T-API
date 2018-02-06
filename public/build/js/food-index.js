function food(){
    this.delete = function (id) {
        $.ajax({
            url: _base + '/foods/food/' + id,
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
    $('#btn-new').on('click',function(e){
        e.preventDefault();
        window.location.href = _base + '/foods/food/create';
    });
    var frm = new food();
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

        $('.show-price').on('click',function(e){
            e.preventDefault();
            var $food = $(this).attr('food-id');
            $.ajax({
                url:_base + '/foods/price-list/' + $food,
                success : function(data){
                    $('#price-list').html(data);
                }
            });
            $('#modal-price').modal('show');
        });
}(jQuery));