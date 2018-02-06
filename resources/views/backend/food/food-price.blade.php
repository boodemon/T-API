<h3>Restourant Price List</h3>
<div class="form-group row">
    <table class="table table-sm table-data table-bordered">
          <thead>
            <tr>
                <th class="w20"><input type="checkbox" id="checkAll"/></th>
                <th>Restourant</th>
                <th class="w140">Unit/Price</th>
            </tr>
          </thead>
          <tbody>
              @if( $rows )
              @foreach($rows as $row)
              <tr>
                <td class="text-center">
                    <input type="checkbox" class="checkboxAll" {{ isset($price[ $row->id ]) ? 'checked': '' }} name="restourant[{{ $row->id }}]" value="{{ $row->id }}" >
                </td>
                <td>
                    {{ $row->restourant }}
                </td>
                <td>
                    <input type="text" class="form-control" name="unit-price[{{ $row->id }}]" value="{{  isset($price[ $row->id ]) ? $price[$row->id]['price']: 0 }}" />
                </td>
              </tr>
              @endforeach
              @endif
            </tbody>
        </table>

</div>
        
