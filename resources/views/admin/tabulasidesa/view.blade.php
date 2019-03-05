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
          <form id="form" method="post" action="{{ url('/tabulasi/desa/viewForm') }}">
        <div class="row">
          {{ csrf_field() }}
          <div class="col-md-4 px-1">
          <div class="form-group">
              <label for="exampleFormControlSelect1">Tingkatan</label>
              <select name="tingkat" class="form-control" id="tingkat">
                <option value="0" selected>Tingkatan</option>
                    <option value="presiden">Presiden</option>
                    <option value="dpd">DPD</option>
                    <option value="dprri">DPR RI</option>
                    <option value="dprprov">DPR Provinsi</option>
                    <option value="dprkab">DPR Kabupaten</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 px-1">
          <div class="form-group">
              <label for="exampleFormControlSelect1">Tabulasi By</label>
              <select name="jenis" class="form-control" id="jenis">
                <option value="0" selected>Pilih Jenis</option>
                    <option value="kelurahan">Kelurahan</option>
                    <option value="kecamatan">Kecamatan</option>
                    <option value="kabupaten">Kabupaten</option>
                    <option value="provinsi">Provinsi</option>
                    <option value="dapil">Dapil</option>
              </select>
            </div>
          </div>
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Go" />
            </div>
        </div>
          </form>
      </div>
    </div>
   </div>
  </div>
</div>
<!--<script src="{{ asset('js/gettabulasibydapil.js')}}" type="text/javascript"></script>-->
<!--<script src="{{ asset('js/kirim-suara.js')}}" type="text/javascript"></script>-->

@endsection