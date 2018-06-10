@if( $price )
    @foreach($price as $row)
        <div class="col-sm-4 col-lg-4 restourant-panel">
            <div class="card">
                <div class="card-body">
                    <input type="hidden" class="price-id" name="price['id'][]" value="{{ $row->id }}"/>
                    <input type="hidden" class="price-restourant-id" name="price['restourant_id'][]" value="{{ $row->restourant_id }}"/>
                    <input type="hidden" class="price-price" name="price['price'][]" value="{{ $row->price }}"/>
                    <div class="text-value">Restourant : <strong class="restourant-name">{{ $row->restourant }}</strong></div>
                    <div>Unit/Price : <strong  class="price-price">{{ $row->price }}</strong>.-</div>
                    <div class="action">
                        <a href="#" class="price-remove text-danger pull-right" data-id="{{ $row->id }}"><i class="fa fa-trash"></i></a>
                        <a href="#" class="price-edit text-primary pull-right" data-id="{{ $row->id }}"><i class="fa fa-edit"></i></a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
