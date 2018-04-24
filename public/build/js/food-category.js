(function($)
{
    var img = image;
        img.inputid = $('#image');
        img.previewid = $('#file-preview');
        img.inputclick();
    function frmcate(){
        this.clearInput = function(){
            $('#frm-category').attr('action', _base + '/foods/category');
            $('input[type="text"]').val('');
            $('input[name="id"]').val(0);
            $('input[type="file"]').val('');
            $('input[type="checkbox"]').prop('checked',false);
            $('.image-preview').hide();
            $('input[name="_method"]').val('POST');
        }
        this.edit = function(id){
            $('#frm-category').attr('action',_base + '/foods/category/' + id);
            $.ajax({
                url : _base + '/foods/category/' + id + '/edit' ,
                success:function(data){
                    console.log('data',data);
                    if( data.code == 200){
                        var res = data.data;
                        $('input[name="id"]').val( res.id );
                        $('input[name="name"]').val(res.name );
                        $('select[name="category_option"]').val(res.category_option );
                        $('input[name="category_sort"]').val(res.category_sort );
                        $('input[name="_method"]').val('PUT');
                        if (res.active == 'Y'){
                            $('input[name="active"]').prop('checked', true);
                        }else{
                            $('input[name="active"]').prop('checked', false);
                        }
                        if( res.image ){
                            $('.image-preview').show();
                            $('.img-preview').attr('src',_base + '/public/images/category/' + res.image);
                        }else{
                            $('.image-preview').hide();
                        }
                        
                    }
                }
            });
        }

        this.delete = function(id){
            $.ajax({
                url : _base + '/foods/category/' + id,
                method:'POST',
                data:{_token:$('input[name="_token"]').val(), _method:'DELETE'},
                success : function(data){
                    
                },
                error:function(e){
                    console.log(e);
                }
            });
        }


    }


    var frm = new frmcate();
    $('#btn-new').on('click',function(){
        //alert('model');
        frm.clearInput();
        $('#modal-category').modal('show');
    });

    $('.onEdit').on('click',function(){
        frm.edit($(this).attr('data-id') );
        $('#modal-category').modal('show');
    });

    $('.onDelete').on('click',function(e){
        e.preventDefault();
        var row = $(this).closest('tr');
        if( confirm('Please confirm delete this')){
            var id = $(this).attr('data-id');
            frm.delete(id);
            row.remove();
        }
    });

    $('.btn-delete').on('click',function(e){
        var ids = [];
        if (!confirm('Please confirm delete this selected')) 
            return false;
        $('.checkboxAll').each(function(index,val){
            var row = $(this).closest('tr');
            if( $(this).is(':checked') ){
                ids.push( $(this).val() );
                row.remove();
            }
        });
        frm.delete(ids.join('-'));
    });
}(jQuery));