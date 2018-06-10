<div class="modal fade"  tabindex="-1" id="restourant-filter" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title pull-left">Report Filter</h4>
            <button type="button" class="close pull-right" aria-label="Close"  data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form category input -->
            <form enctype="multipart/form-data" class="form-horizontal" id="frm-status" method="GET" action="{{ url('foods/restourant') }}">
                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">CATEGORY</label>
                    <div class="col-sm-10">
                        <div class="row">
                            @if( $groups )
                            @foreach( $groups as $index => $group )
                            <div class="col-md-6">
                                <label>
                                    <input type="checkbox" {{ ( Request::exists('groups') && in_array( $group['id'], Request::input('groups') ) )? 'checked' : '' }} name="groups[]" value="{{ $group['id']}}"/> 
                                    {{ $group['name']  }}
                                </label>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>                

                <div class="form-group row">
                    <label class="col-sm-2 form-control-label">KEYWORD</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="keywords" value="{{ Request::input('keywords') }}" placeholder="Keyword..." />
                    </div>
                </div>
                <div class="form-groups text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Filter
                    </button>
                </div>
            </form>
            <!-- /Form category input -->
          </div>
    </div>
    </div>
  </div>