(function ($) {

    function frmuser() {
        this.clearInput = function () {
            $('#frm-user').attr('action', _base + '/user');
            $('input[type="text"]').val('');
            $('input[name="id"]').val(0);
            $('input[type="file"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
            $('input[name="_method"]').val('POST');
        }
        this.edit = function (id) {
            $('#frm-user').attr('action', _base + '/user/' + id);
            $.ajax({
                url: _base + '/user/' + id + '/edit',
                success: function (data) {
                    console.log('data', data);
                    if (data.code == 200) {
                        var res = data.data;
                        $('input[name="id"]').val(res.id);
                        $('input[name="username"]').val(res.username);
                        $('input[name="email"]').val(res.email);
                        $('input[name="name"]').val(res.name);
                        $('input[name="tel"]').val(res.tel);
                        $('input[name="password"]').val('');
                        $('input[name="confirm_password"]').val('');
                        $('input[name="_method"]').val('PUT');
                        if (res.active == 'Y') {
                            $('input[name="active"]').prop('checked', true);
                        } else {
                            $('input[name="active"]').prop('checked', false);
                        }

                    }
                }
            });
        }

        this.delete = function (id) {
            $.ajax({
                url: _base + '/user/' + id,
                method: 'POST',
                data: { _token: $('input[name="_token"]').val(), _method: 'DELETE' },
                success: function (data) {

                },
                error: function (e) {
                    console.log(e);
                }
            });
        }

        this.checkuser = function( $input ){
            var frm         = $input.closest('form');
            var inputName   = $input.attr('name');
            $.ajax({
                url: _base + '/user/checker',
                data:   {
                            _token  : $('input[name="_token"]').val(), 
                            type    : inputName,
                            text    : $input.val() 
                        },
                type:'POST',
                success:function(data){
                    var no = data.trim();
                    var $require = $('.require-' + inputName );
                    if( no > 0){
                        
                        if (inputName == 'username'){
                            $require.html('<span class="text-require">* Username นี้ถูกใช้ไปก่อนหน้านี้แล้ว โปรดใช้ Username อื่น</span>');
                        }
                        if (inputName == 'email'){
                            $require.html('<span class="text-require">* Email นี้ถูกใช้ไปก่อนหน้านี้แล้ว โปรดใช้ Email อื่น</span>');
                        }
                        $('input[name="' + inputName +'"]').focus();
                        return false;
                    }else{ 
                        $require.html('');
                    }
                }
            })
        }
        
        this.validate = function(){
            var username            =  $('input[name="username"]'),
                email               =   $('input[name="email"]');
            var password            =  $('input[name="password"]'),
                confirm_password    = $('input[name="confirm_password"]');
            var name                = $('input[name="name"]');
            var id                  = $('input[name="id"]');

            if( id.val() == 0){
                this.checkuser( username );
                this.checkuser( email );
                if (password.val() == '' || password.val() === null) {
                    $('.require-password').html('<span class="text-require">* กรุณาทำการป้อน Password</span>');
                }else{
                    $('.require-password').html('');
                }

                if (confirm_password.val() == '' || confirm_password.val() === null) {
                    $('.require-confirm_password').html('<span class="text-require">* กรุณาทำการป้อน Confirm Password</span>');
                }else{ 
                    $('.require-confirm_password').html('');
                }
            }           
            if( username.val() =='' || username.val() === null ){
                $('.require-username').html('<span class="text-require">* กรุณาทำการป้อน Username</span>');
            }else{ 

                $('.require-username').html('');
            }

            if (email.val() == '' || email.val() === null ){
                $('.require-email').html('<span class="text-require">* กรุณาทำการป้อน Email</span>');
            }else{ 
                $('.require-email').html('');
            }

            if (name.val() == '' || name.val() === null ){
                $('.require-name').html('<span class="text-require">* กรุณาทำการป้อนชื่อ</span>');
            }else{ 
                $('.require-name').html('');
            }



            if( password.val() !== '' ){
                if (confirm_password.val() == '' || confirm_password.val() === null) {
                    $('.require-confirm_password').html('<span class="text-require">* กรุณาทำการป้อน Confirm Password</span>');
                }else{ 
                    $('.require-confirm_password').html('');
                }

                if (password.val() != confirm_password.val()) {
                    $('.require-confirm_password').html('<span class="text-require">* Password และ Confirm Password ไม่ตรงกัน โปรดทำการป้อนใหม่อีกครั้ง</span>');
                }else{ 
                    $('.require-confirm_password').html('');
                }
            }
        }



    }


    var frm = new frmuser();
    $('#btn-new').on('click', function () {
        //alert('model');
        frm.clearInput();
        $('#modal-user').modal('show');
    });

    $('input[name="username"]').on('change',function(e){
        frm.checkuser( $(this) );
    });

    $('input[name="email"]').on('change',function(e){
        frm.checkuser( $(this) );
    });

    $('.onEdit').on('click', function () {
        frm.edit($(this).attr('data-id'));
        $('#modal-user').modal('show');
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

    $('form').on('submit',function(e){
        frm.validate();
        if( $('.text-require').length > 0 ){
            $('.text-require').each(function(i,v){
                console.log('i : ', i);
                if(i == 0){
                var inp = $(this).closest('div');
                inp.find('input').focus();
                }
            });
            return false;
        }
        
    });
}(jQuery));