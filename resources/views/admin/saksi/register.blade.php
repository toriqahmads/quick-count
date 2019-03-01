@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/upload.js') }}"></script>
<script src="{{ asset('js/getreg.js') }}"></script>
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
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Input Data Saksi</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/saksi/registerPost') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nama Depan</label>
                  <input type="text" name="fname" class="form-control" placeholder="Nama Depan" value="{{ old('fname') }}">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nama Belakang</label>
                  <input type="text" name="lname" class="form-control" placeholder="Nama Belakang" value="{{ old('lname') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4 px-1">
                <div class="form-group">
                  <label>NIK</label>
                  <input type="number" name="nik" class="form-control" placeholder="Nomor NIK" value="{{ old('nik') }}">
                </div>
              </div>
              <div class="col-md-4 px-1">
                <div class="form-group">
                  <label>No. HP</label>
                  <input type="text" name="telp" placeholder="Nomor HP" class="form-control" value="{{ old('telp') }}">
                </div>
              </div>
              <div class="col-md-4 px-1">
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
              <div class="col-md-3 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Provinsi</label>
                  <select name="prov" id="prov" class="form-control">
                    <option value="0" selected>Pilih Provinsi</option>
                    @foreach($data as $d)
                      <option value="{{$d->id}}">{{$d->prov}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3 px-1">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kab" id="kab" class="form-control">
                      <option value="0" selected>Pilih Kabupaten</option>
                    </select>
                  </div>
              </div>
              <div class="col-md-3 px-1">
                  <div class="form-group">
                    <label>Kecamatan</label>
                    <select name="kec" id="kec" class="form-control">
                      <option value="0" selected>Pilih Kecamatan</option>
                    </select>
                  </div>
              </div> 
              <div class="col-md-3 px-1">
                    <label>Kelurahan</label>
                    <select name="kel" id="kel" class="form-control">
                      <option value="0" selected>Pilih Kelurahan</option>
                    </select>
              </div>
          </div>
          <div class="row">
            <div class="col-md-6 px-1">
                <label>TPS</label>
                  <select name="tps" id="tps" class="form-control">
                    <option value="0" selected>Pilih TPS</option>
                  </select>
            </div>
            <div class="col-md-6 px-1">
              <div class="form-group">
              <label>Alamat</label>
              <input type="text" name="alamat" class="form-control" id="inputAddress" placeholder="Alamat" value="{{ old('alamat') }}">
            </div>
            </div>
        </div>
          <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Konfirmasi Password</label>
                  <input type="password" name="confirmation" placeholder="Confirm Password" class="form-control" />
                </div>
              </div>
          </div>
          <div class="row">
            <div class="col-md-6 px-1">
                <div class="form-group">
                    <label>Foto</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse… <input type="file" name="foto" id="imgInp">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 px-1">
              <label>Preview</label>
              <div class="form-group">
                
                <img id='img-upload'/>
              </div>
            </div>
          </div>
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