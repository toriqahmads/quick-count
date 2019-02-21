@extends('saksi.basedashboard')
@section('content')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('js/saksi/suara/dprkab/getdetailforeditsuara.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/saksi/suara/dprkab/edit-suara.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/saksi/suara/dprkab/kirim-edit-suara.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/saksi/suara/dprkab/delete-suara.js')}}" type="text/javascript"></script>
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
          <h3>View Suara DPR Kabupaten</h3>
        </div>
      <div class="row">
        <input type="hidden" id="prov" name="prov" value="{{Session::get('id_prov')}}">
        <input type="hidden" id="kab" name="kab" value="{{Session::get('id_kab')}}">
        <input type="hidden" id="kec" name="kec" value="{{Session::get('id_kec')}}"> 
        <input type="hidden" id="kel" name="kel" value="{{Session::get('id_kel')}}">
        <input type="hidden" id="dapil" name="dapil" value="{{Session::get('dapil_kec')}}">
        <input type="hidden" id="tps" name="tps" value="{{Session::get('id_tps')}}">
        <input type="hidden" id="saksi" name="saksi" value="{{Session::get('id')}}">
        <input type="hidden" id="tingkat" name="tingkat" value="e">
      </div>
      </div>
    </div>
   </div>

   @foreach($partai as $part)
   <div class="col-md-3">
      <div class="card">
        <div class="card-header">
          <h5 class="title">{{$part->no_urut}}. {{$part->partai}}</h5>
        </div>
        <div class="card-body">
          <form id="suara{{$part->id}}" class="form" method="post" action="{{ url('/suara/updateSuara') }}" enctype="multipart/form-data">
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
<!--<script src="{{ asset('js/kirim-suara.js')}}" type="text/javascript"></script>-->

@endsection