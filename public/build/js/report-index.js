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
function exported(){
    this.pdf = function(){

    }
    this.pdf_order = function(id){
    }
    this.xls = function(){
        var param = '?start=' + $('#start').val() + '&end=' + $('#end').val();
        $.ajax({
            url: _base + '/report/sheet/xls' + param,
            success:function(data){
                console.log('data => ', data );
                if(data['code'] == 200){
                    location.href = data.file;
                }
            }
        });
    }
    this.xls_order = function(id){

    }
}

(function($){
    $('.btn-filter').on('click',function(e){
        $('#modal-report').modal('show');
    });
        $('#start').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            maxViewMode: 'days',
            endDate: $('#end').val()
        })
        .on('changeDate',function(e){
            console.log('change date start');
            var minDate = new Date(e.date.valueOf());
            $('#end').datepicker('setStartDate', minDate);
        });

        $('#end').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            maxViewMode: 'days',
            endDate: '+0d',
            startDate: $('#start').val()
        }).on('changeDate',function(e){
            //$('#start').change();
            var maxDate = new Date(e.date.valueOf());
            $('#start').datepicker('setEndDate', maxDate);
        });
        // Export //
        var exporter = new exported();
        $('.btn-exporter-xls').on('click',function(e){
            exporter.xls();
        });

}(jQuery));