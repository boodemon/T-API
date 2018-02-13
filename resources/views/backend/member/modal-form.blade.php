<div class="modal fade "  tabindex="-1" id="modal-member" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title pull-left">Member user</h4>
          <button type="button" class="close pull-right" aria-label="Close"  data-dismiss="modal">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form category input -->
          <form enctype="multipart/form-data" class="form-horizontal" id="frm-user" method="POST" action="">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="hidden" name="id" id="id" />
            <input type="hidden" name="_method" />
            
            <div class="form-group row">
              <label class="col-md-3 form-control-label">Username : </label>
              <div class="col-md-6">
                <input type="text" class="form-control" name="username" id="username"/>
                <span class="require-username"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 form-control-label">Email : </label>
              <div class="col-md-8">
                 <input type="text" class="form-control" name="email" id="email"/>
                 <span class="require-email"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 form-control-label">Password : </label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="password" id="password"/>
                <span class="require-password"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 form-control-label">Confirm Password : </label>
              <div class="col-md-6">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password"/>
                <span class="require-confirm_password"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 form-control-label">Name : </label>
              <div class="col-md-8">
                <input type="text" class="form-control" name="name" id="name"/>
                <span class="require-name"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 form-control-label">Tel : </label>
              <div class="col-md-4">
              <input type="text" class="form-control" name="tel" id="tel"/>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-3 form-control-label">Status : </label>
              <div class="col-md-8">
              <label class="checkbox">
                <input type="checkbox" name="active" value="Y" /> Active
              </label>
              </div>
            </div>
          
            <div class="form-groups text-right">
              <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> SAVE</button>
              <button type="button" class="btn btn-danger"  data-dismiss="modal">
                <i class="fa fa-times"></i> CANCEL</button>
            </div>
          </form>
          <!-- /Form category input -->
        </div>
  </div>
  </div>
</div>