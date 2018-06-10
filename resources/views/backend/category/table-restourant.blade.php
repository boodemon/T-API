<table class="table table-sm table-data table-bordered">
    <thead>
      <tr>
          <th class="w120">Image</th>
          <th>Restourant</th>
      </tr>
    </thead>
    <tbody>
      @if( $rows )
      @foreach( $rows as $row)
      <tr>
        <td>
          <img src="{{asset(Lib::existsFile('public/images/restourant/', $row->image) ) }}" class="img-responsive" width="120" />
        </td>
        <td>
            <p><strong>{{ $row->restourant }}</strong></p>
            <p>{{ $row->contact }} </p>
            <p>Tel. {{ $row->tel }}</p>
        </td>
      </tr>
      @endforeach
      @endif
    </tbody>
  </table>