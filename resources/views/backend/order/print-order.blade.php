@extends('backend.layouts.template-'. ($action == 'print' ? 'print' : 'export'))
@section('content')
        <div class="table-responsive">
            <table class="noboder">
                <tr>
                    <td style="width:140px;"><strong>ORDER NO.</strong> </td>
                    <td>{{ '#' . sprintf( '%05d',$head->id ) }}</td>
                    <td colspan="2" class="text-right">{{ date('d M Y', strtotime( $head->created_at ) ) }}</td>
                </tr>
                <tr>
                    <td><strong>JOB NAME</strong></td>
                    <td>{{ $head->jobname }}</td>
                    <td colspan="2" class="text-right"><strong>JOB DATE</strong> {{ date('d M Y H:i', strtotime( $head->jobdate ) ) }}</td>
                </tr>
                <tr>
                    <td><strong>JOB ADDRESS</strong> </td>
                    <td colspan="3">{{ $head->jobaddress }}</td>
                </tr>
                <tr>
                    <td><strong>REMARK</strong> </td>
                    <td colspan="3">{{ $head->remark }}</td>
                </tr>
            </table>
            <hr/>
            </table>
                <table class="table table-sm table-data table-bordered">
                        <thead>
                          <tr>
                              <th class="w60">No</th>
                              <th class="">Food</th>
                              <th class="">Restourant</th>
                              <th class="w120">Price</th>
                              <th class="w120">Quantity</th>
                              <th class="w120">Amount</th>
                              <th class="w180">Remark</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if( $details )
                            @foreach( $details as $detail )
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ App\Models\Food::field($detail->food_id) }}</td>
                                <td class="thai-font">{!! App\Models\Restourant::showContact($detail->restourant_id) !!}</td>
                                <td class="text-right">{{ $detail->per_price }}</td>
                                <td class="text-right">{{ $detail->qty }}</td>
                                <td class="text-right">{{ $detail->total_price }}</td>
                                <td>{{ $detail->remark }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                              
                </table>
        </div>
@endsection
@section('javascript')
    @if($action == 'print')
    <script type="text/javascript">
        window.print();
        setTimeout(function(){
            location.href = "{{url('order/'. $id .'/edit') }}";            
            },500);
    </script>
    @endif
@endsection