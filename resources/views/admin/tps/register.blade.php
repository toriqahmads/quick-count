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
  $("#ntps").change(function()
        {
            var gender = $("#ntps").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap isi nama TPS!', 'danger');
            }
            else
            {
                return false;
            }
        });
  $("#kel").change(function()
        {
            var gender = $("#kel").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih Kelurahan!', 'danger');
            }
            else
            {
                return false;
            }
        });
  $("#kec").change(function()
        {
            var gender = $("#kec").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih Kecamatan!', 'danger');
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
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Registrasi Data TPS</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/tps/registerPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-4 pl-1">
                <div class="form-group">
                  <label>Nama TPS</label>
                  <input type="text" name="tps" class="form-control" id='ntps' placeholder="Nama TPS" value="{{ old('tps') }}">
                </div>
              </div>
              <div class="col-md-4 px-1">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec" id="kec" class="form-control">
                      <option value="0" selected>Kecamatan</option>
                      @foreach($kec as $kecs)
                      {
                          <option value="{{ $kecs->id_kec }}">{{ $kecs->kec }}</option>
                      }
                      @endforeach
                    </select>
                  </div>
              </div> 
            <div class="col-md-4 pr-1">
                  <label>Kelurahan</label>
                  <select name="kel" id="kel" class="form-control">
                    <option value="0" selected>Kelurahan</option>
                  </select>
            </div>
          </div>
            </div>
                <input type="hidden" id="prov" name="prov" value="">
                <input type="hidden" id="kab" name="kab" value="">
                <input type="hidden" id="dapil" name="dapil" value="">
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Submit" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection