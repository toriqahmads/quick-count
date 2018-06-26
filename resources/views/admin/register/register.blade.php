@extends('admin.base')
@section('content')
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
<div class="col-md-12 content-center">
    <div class="card card-login card-plain">
        <form class="form" method="post" action="{{ url('/admin/registerPost') }}">
            <div class="header header-primary text-center">
                <h4>Register</h4>
            </div>
            {{ csrf_field() }}
            <div class="content">
                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="text" name="fname" class="form-control" placeholder="Nama Depan" value="{{ old('fname') }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="lname" placeholder="Nama Belakang" class="form-control" value="{{ old('lname') }}"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="text" name="nik" class="form-control" placeholder="Nomor NIK" value="{{ old('nik') }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="telp" placeholder="Nomor HP" class="form-control" value="{{ old('telp') }}"/>
                    </div>
                </div>

                <div class="form-group">
                  <select name="gender" id="gender" class="form-control">
                    <option value="0" selected>Jenis Kelamin</option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </div>
                
                <div class="form-group col-sm-14">
                    <input type="text" name="alamat" class="form-control" id="inputAddress" placeholder="Alamat" value="{{ old('alamat') }}">
                </div>

                <div class="form-group">
                  <select name="kec" id="kec" class="form-control">
                    <option value="0" selected>Kecamatan</option>
                    @foreach($data as $kec)
                    {
                        <option value="{{ $kec->id_kec }}">{{ $kec->kec }}</option>
                    }
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <select name="kel" id="kel" class="form-control">
                    <option value="0" selected>Kelurahan</option>
                  </select>
                </div>

                <div class="form-group">
                  <select name="tps" id="tps" class="form-control">
                    <option value="0" selected>TPS</option>
                  </select>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-6">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="password" name="confirmation" placeholder="Confirm Password" class="form-control" />
                    </div>
                </div>

                <input type="hidden" id="prov" name="prov" value="">
                <input type="hidden" id="kab" name="kab" value="">
                <input type="hidden" id="dapil" name="dapil" value="">
                <div class="input-group form-group-no-border input-lg">
                    <input type="submit" class="btn-primary btn btn-round btn-block" value="Register" />
                </div>

                <div class="pull-left">
                <h6>
                    <a href="{{ url('/admin/login') }}" class="link">Login</a>
                </h6>
                </div>
                <div class="pull-right">
                    <h6>
                        <a href="{{ url('/admin/forgot') }}" class="link">Lupa password?</a>
                    </h6>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection