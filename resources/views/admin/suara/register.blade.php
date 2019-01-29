@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('js/getreg.js')}}" type="text/javascript"></script>
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
<script type="text/javascript">
  $("#partai").change(function()
        {
            var gender = $("#partai").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap isi nama Partai!', 'danger');
            }
            else
            {
                return false;
            }
        });
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

<?php $partai = array('1'=>'Demokrat', '2'=>'Hanura', '3'=>'PAN', '4'=>'PKS', '5'=>'PDI Perjuangan', '6'=>'Gerindra');
	  $caleg = array('1'=>, '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18');
?>
<div class="content">
  <div class="row">
  	@foreach($partai as $part)
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5 class="title">{{$part}}</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/admin/suara/registerPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-12 pl-1">
                <div class="form-group">
                  <label>{{$part}}</label>
                  <input type="text" name="suara[{{$part}}][{{$part}}]" class="form-control" placeholder="Suara Partai" value="{{ old('partai') }}">
                </div>
              </div>
              @foreach($caleg as $cal)
              <div class="col-md-12 pl-1">
                <div class="form-group">
                  <label>{{$cal}}</label>
                  <input type="text" name="suara[{{$part}}][{{$cal}}]" class="form-control" placeholder="{{$cal}}" value="{{ old('partai') }}">
                </div>
              </div>
          	  @endforeach
          </div>
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Submit" />
            </div>
          </form>
        </div>
      </div>
    </div>
	@endforeach
  </div>
</div>
@endsection