<table class="table table-sm table-data table-bordered">
    <thead>
      <tr>
          <th class="w120">Image</th>
          <th>Food name</th>
          <th class="w120">Calorie</th>
      </tr>
    </thead>
    <tbody>
        @if($rows )
          @foreach( $rows as $row )
          <tr>
              <td>
                  <img src="{{asset(Lib::existsFile('public/images/foods/' , $row->food_image) ) }}" class="img-responsive" width="120" />
              </td>
              <td>{{ $row->food_name }}</td>
              <td class="text-right">{{ $row->kcal }} (kcal)</td>
          </tr>
          @endforeach
        @endif
    </tbody>
  </table>