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
<script type="text/javascript">
    $(document).ready(function()
    {
        $("#kec").change(function()
        {
            var kec_id = $("#kec").val();
            if(kec_id === '0' || kec_id === null || kec_id === undefined)
            {
                showNotification('top', 'right','Harap pilih kecamatan!', 'danger');
            }
            else
            {
                $.ajax({
                  url: window.location.origin+"/data/kel/" + kec_id,
                  type: "GET",
                  success: function(html){
                    var res = "<option value='0'>Kelurahan</option>";
                    $.each(html, function(key, val)
                    {
                        res = res + "<option value='" + val.id_kel +"'>" + val.kel + "</option>";
                        $("#dapil").val(val.id_dapil);
                    });
                    $('#kel').html(res);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   } 
                });
            }
            return false;
        });

        $("#kel").change(function()
        {
            var kel_id = $("#kel").val();
            
            if(kel_id === '0' || kel_id === null || kel_id === undefined)
            {
                showNotification('top', 'right','Harap pilih kelurahan!', 'danger');
            }
            else
            {
                $.ajax({
                  url: window.location.origin+"/data/tps/" + kel_id,
                  type: "GET",
                  success: function(html){

                    var res = "<option value='0'>TPS</option>";
                    $.each(html, function(key, val)
                    {
                        res = res + "<option value='" + val.id_tps +"'>" + val.tps + "</option>";
                        $("#prov").val(val.id_prov);
                        $("#kab").val(val.id_kab);
                    });
                    $("#tps").html(res);
                  },
                  error: function(xhr, Status, err) {
                     showNotification('top', 'right','Terjadi error : '+ Status, 'danger');
                   } 
                });
            }
            return false;
        });

        $("#gender").change(function()
        {
            var gender = $("#gender").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih jenis kelamin!', 'danger');
            }
            else
            {
                return false;
            }
        });
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
          <h5 class="title">Input Data Saksi</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/admin/saksi/registerPost') }}">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label>Nama Depan</label>
                  <input type="text" name="fname" class="form-control" placeholder="Nama Depan" value="{{ old('fname') }}">
                </div>
              </div>
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label>Nama Belakang</label>
                  <input type="text" name="lname" class="form-control" placeholder="Nama Belakang" value="{{ old('lname') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pl-1">
                <div class="form-group">
                  <label>NIK</label>
                  <input type="text" name="nik" class="form-control" placeholder="Nomor NIK" value="{{ old('nik') }}">
                </div>
              </div>
              <div class="col-md-4 px-1">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="text" name="telp" placeholder="Nomor HP" class="form-control" value="{{ old('telp') }}">
                </div>
              </div>
              <div class="col-md-4 pr-1">
                  <div class="form-group">
                    <label>Jenis Kelamin</label>
                  <select name="gender" id="gender" class="form-control">
                    <option value="0" selected>Jenis Kelamin</option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 pl-1">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec" id="kec" class="form-control">
                      <option value="0" selected>Kecamatan</option>
                      @foreach($data as $kecs)
                      {
                          <option value="{{ $kecs->id_kec }}">{{ $kecs->kec }}</option>
                      }
                      @endforeach
                    </select>
                  </div>
              </div> 
              <div class="col-md-4 px-1">
                    <label>Kelurahan</label>
                    <select name="kel" id="kel" class="form-control">
                      <option value="0" selected>Kelurahan</option>
                    </select>
              </div>
              <div class="col-md-4 pr-1">
                  <label>TPS</label>
                    <select name="tps" id="tps" class="form-control">
                      <option value="0" selected>TPS</option>
                    </select>
              </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat" class="form-control" id="inputAddress" placeholder="Alamat" value="{{ old('alamat') }}">
          </div>
          </div>
          <div class="row">
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
              </div>
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Konfirmasi Password</label>
                  <input type="password" name="confirmation" placeholder="Confirm Password" class="form-control" />
                </div>
              </div>
          </div>
                <input type="hidden" id="prov" name="prov" value="">
                <input type="hidden" id="kab" name="kab" value="">
                <input type="hidden" id="dapil" name="dapil" value="">
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Registrasi" />
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection