<div class="form-group row">
    <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th>Restourant</th>
                <th class="w140">Unit/Price</th>
            </tr>
          </thead>
          <tbody>
              @if( $price )
              @foreach($price as $row)
              <tr>
                <td>
                    {{ App\Models\Restourant::field($row->restourant_id) }}
                </td>
                <td class="text-right">
                    {{ $row->price }}
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
        </table>

</div>
        
