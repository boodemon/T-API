<div class="modal fade"  tabindex="-1" id="modal-payment" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title pull-left">Payments</h4>
            <button type="button" class="close pull-right" aria-label="Close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-category" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <input type="hidden" name="_method" />
                <div class="form-group row">
                    <label class="col-md-2 form-control-label"></label>
                    <div class="col-md-10" id="file-preview">
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Image : </label>
                    <div class="col-md-8">
                        <input type="file" id="image" name="image" file-allow="jpg|jpeg|png|gif" />
                        <input type="hidden" id="id" id="id" name="id" />
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">ธนาคาร : </label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="bank_name" id="bank_name" />
                    </div>
                </div>

                
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">สาขา : </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="bank_branch" id="bank_branch"/>
                    </div>
                    <label class="col-md-2 form-control-label text-right">ประเภท : </label>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="bank_type" id="bank_type"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label">ชื่อบัญชี : </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="bank_account" id="bank_account"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label">เลขที่บัญชี : </label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="bank_id" id="bank_id"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 form-control-label">ลำดับ : </label>
                    <div class="col-md-2">
                        <input type="number" class="form-control" name="bank_sort" id="bank_sort"/>
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-md-2 form-control-label">Status : </label>
                    <div class="col-md-8">
                        <label class="checkbox">
                        <input type="checkbox" id="active" name="active" /> Active
                        </label>
                    </div>
                </div>
        
                <div class="form-groups text-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SAVE</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-save"></i> CANCEL</button>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>