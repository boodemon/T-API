function frmfood(){
    this.item = {};
    this.category = 0;
    this.price = function($id = 0,$food=0){
        var _this = this;
        _this.onSearch($id);
        if( $food != 0 ){
            _this.category = $id;
            $.ajax({
                url : _base + '/foods/price/' + $id + '/' + $food,
                success : function(data){
                    $('.price-list').html(data);
                    _this.onClick();
                },
                error:function(e){
                    console.log('error !! ' , e);
                    $('.price-list').html('');
                }
            });
        }
    }

    this.onSearch = function(id){
        var food = this;
        $('#restourant').autocomplete({
            source 		: _base + '/foods/price-restourant/' + id,
            minLength 	: 1,
            select 		: function( event, ui){
                console.log('ui => ', ui ,' | event => ', event);
                food.item = ui.item;
            },
            change : function(event, ui){
                if(ui.item === null || ui.item === undefined){
                   //
                }
            }
        });
    }

    this.removePrice = function(id,row){
        if( id != 0){
            $.ajax({
                url: _base + '/foods/price-remove/' + id ,
                success: function(data){
                    console.log('success full');
                    row.remove();
                }
            });
        }
    }

    this.appends = function(item){
        var priceID = item.price_id !== undefined ? item.price_id : 0;
        return '<div class="col-sm-4 col-lg-4 restourant-panel">'
            +'<div class="card">'
                +'<div class="card-body">'
                    +'<input type="hidden" class="price-id" name="price[id][]" value="'+ priceID +'"/>'
                    +'<input type="hidden" class="price-restourant-id" name="price[restourant_id][]" value="'+ item.id +'"/>'
                    +'<input type="hidden" class="price-price" name="price[price][]" value="'+ $('#price').val() +'"/>'
                    +'<div class="text-value">Restourant : <strong class="restourant-name">'+ item.value +'</strong></div>'
                    +'<div>Unit/Price : <strong class="price-price">'+ $('#price').val() +'</strong>.-</div>'
                    +'<div class="action">'
                        +'<a href="#" class="price-remove text-danger pull-right" data-id="'+ priceID +'"><i class="fa fa-trash"></i></a>'
                        +'<a href="#" class="price-edit text-primary pull-right" data-id="'+ priceID +'"><i class="fa fa-edit"></i></a>'
                    +'</div>'
                +'</div>'
            +'</div>'
        +'</div>';
    }

    this.onRemove = function(){
        var _this = this;
        $('.price-remove').on('click',function(e){
            e.preventDefault();
            var row = $(this).closest('.restourant-panel');
            var price_id = $(this).attr('data-id');
            if( price_id != 0){
                if( confirm('please confirm delete this restourant') )
                _this.removePrice(price_id,row);
            }else{
                row.remove();
            }
        });
    }
    this.onEdit = function(){
        var _this = this;
        $('.price-edit').on('click',function(e){
            e.preventDefault();
            var row = $(this).closest('.restourant-panel');
            var price_id = $(this).attr('data-id');
            _this.item = {
                    id          : row.find('.price-restourant-id').val(),
                    price_id    : row.find('.price-id').val(),
                    label       : row.find('.restourant-name').html(),
                    value       : row.find('.restourant-name').html(),
                    restourant_id : row.find('.price-restourant-id').val(),
                    price       : row.find('input.price-price').val()
                    };
            console.log('price edit result ', _this.item );
            $('#restourant').val( _this.item.label ).prop('readOnly',true);
            $('#price').val( _this.item.price );

        });
    }

    this.onAdd = function(){
        var _this   = this;
        $('.btn-add').on('click',function(e){
            var x       = 0;
            var panel = $('.restourant-panel');
            var itm = _this.item;
            var price_id = itm.price_id !== undefined ? itm.price_id : 0;
            console.log('panel => ', panel.length );
            if( panel.length == 0){
                console.log('A');
                $('.price-list').append( _this.appends( itm ) );
                x++;
            }else{
                console.log('B');
                panel.each(function(i,v){
                    var restourantID = $(this).find('.price-restourant-id').val();
                    console.log('restourant [ ' + restourantID + ' = ' + itm.id +'] result fund ', itm);                    
                    if( itm.id == restourantID  && itm.id !== undefined && restourantID !== undefined ){    
                       $(this).find('input.price-price').val( $('#price').val() );
                       $(this).find('strong.price-price').html( $('#price').val() );
                        x++;
                    }
                });
                console.log('x => ', x);
                if(x == 0){
                    console.log('C');
                    $('.price-list').append( _this.appends( itm ) );
                }    
            }

            _this.item = {};
            $('#restourant').prop('readOnly',false);

            $('#restourant').val('');
            $('#price').val('');

            _this.onClick();

        });
    }

    this.onClick = function(){
        this.onRemove();
        this.onEdit();
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
    });

    

    food.onClick();
    food.onAdd();


}(jQuery));
