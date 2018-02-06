function frmfood(){
    this.price = function($id = 0,$food=0){
        $.ajax({
            url : _base + '/foods/price/' + $id + '/' + $food,
            success : function(data){
                $('.price-list').html(data);
            },
            error:function(e){
                console.log('error !! ' , e);
                $('.price-list').html('');
            }
        })
    }

}
(function($){
    var img = image;
    img.inputid = $('#image');
    img.previewid = $('#file-preview');
    img.inputclick();
    var food = new frmfood();
    var foodID = $('input[name="id"]').val();
    $('#groups').on('change',function(e){
        food.price( $(this).val(), foodID );
    });
    food.price($('#groups').val(), foodID );

    $('.btn-cancel').on('click',function(){
        window.location.href= _base + '/foods/food';
    })
}(jQuery));
