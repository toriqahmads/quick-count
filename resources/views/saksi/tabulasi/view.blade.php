@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/apexchart.js')}}"></script>
<script type="text/javascript">
  function showNotification(from, align, msg, color){
    color = color

    $.notify({
        icon: "now-ui-icons ui-1_bell-53",
        message: msg

      },{
          type: color,
          timer: 8000,
          placement: {
              from: from,
              align: align
          }
      });
  };
</script>

@if(\Session::has('alert'))
    <script type="text/javascript">
        $(document).ready(function(){
            showNotification('top', 'right', '{!! Session::get('alert') !!}', 'danger');
        });
    </script>
@endif

@if(\Session::has('alert-success'))
    <script type="text/javascript">
        $(document).ready(function(){
            showNotification('top', 'right', '{!! Session::get('alert-success') !!}', 'success');
        });
    </script>
@endif

@if ($errors->any())
    <?php $err = '<ul>';
        foreach ($errors->all() as $error)
        {
            $err .= '<li>'. $error .'</li>';
        }
        
        $err .= '</ul>';
    ?>

    <script type="text/javascript">
        $(document).ready(function(){
            showNotification('top', 'right', '<?php echo $err; ?>', 'danger');
        });
    </script>
@endif

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
      <div class="row">
        <div class="col-md-3 px-1">
          <div class="form-group">
            <label>Dapil</label>
              <select name="dapil" id="dapil" class="form-control">
                <option value="0" selected>Dapil</option>
                @foreach($dapil as $dap)
                    <option value="{{ $dap->id }}">{{ $dap->id }}</option>
                @endforeach
              </select>
          </div>
        </div>
        <input type="hidden" id="saksi" name="saksi" value="{{Session::get('id')}}">
      </div>
      </div>
    </div>
   </div>

   <div class="col-md-12" id="chart" hidden="true">
      
   </div>

   @foreach($partai as $part)
   <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h5 class="title">{{$part->partai}}</h5>
        </div>
        <div class="card-body">
          <form id="suara{{$part->id}}" class="form" method="post" action="{{ url('/admin/suara/updateSuara') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row" id="{{$part->id}}">
            </div>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
<script src="{{ asset('js/gettabulasibydapil.js')}}" type="text/javascript"></script>
<!--<script src="{{ asset('js/kirim-suara.js')}}" type="text/javascript"></script>-->

@endsection