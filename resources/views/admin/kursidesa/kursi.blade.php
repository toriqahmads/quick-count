@extends('admin.basedashboard')
@section('content')
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
          <h3>Hitung Kursi DPR <?php if($tingkat == 'e') echo "Kabupaten"; if($tingkat == 'd') echo "Provinsi"; if($tingkat == 'c') echo "RI"; ?></h3>
        </div>
      <div class="row">
        <div class="col-md-4 px-1 prov">
          <div class="form-group">
              <label for="exampleFormControlSelect1">Provinsi</label>
              <select name="prov" id="prov" class="form-control">
                <option value="0" selected>Provinsi</option>
                @foreach($prov as $prov)
                  <option value="{{ $prov->id }}">{{$prov->prov}}</option>
                @endforeach
              </select>
          </div>
        </div>
        @if($tingkat == 'e')
        <div class="col-md-4 px-1 kab">
          <div class="form-group">
              <label for="exampleFormControlSelect1">Kabupaten</label>
              <select name="kab" id="kab" class="form-control">
                <option value="0" selected>Kabupaten</option>
              </select>
          </div>
        </div>
        @endif
        <div class="col-md-4 px-1 dapil">
          <div class="form-group">
              <label for="exampleFormControlSelect1">Dapil</label>
              <select name="dapil" id="dapil" class="form-control">
                <option value="0" selected>Dapil</option>
              </select>
          </div>
        </div>
        <input type="hidden" id="saksi" name="saksi" value="{{Session::get('id')}}">
        <input type="hidden" id="tingkat" name="tingkat" value="{{$tingkat}}">
      </div>
      <div id="table"></div>
      <div id="kursi"></div>
      <div id="pemenang"></div>
      </div>
    </div>
   </div>
  </div>

</div>
<script src="{{ asset('js/kursi/hitungkursi-desa.js')}}" type="text/javascript"></script>
<!--<script src="{{ asset('js/kirim-suara.js')}}" type="text/javascript"></script>-->

@endsection