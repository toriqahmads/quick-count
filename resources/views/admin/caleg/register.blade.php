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
  $("#tingkat").change(function()
        {
            var gender = $("#tingkat").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih tingkatan caleg!', 'danger');
            }
            else
            {
                return false;
            }
        });
  $("#partai").change(function()
        {
            var gender = $("#partai").val();
            if(gender === '0' || gender === null || gender === undefined)
            {
                showNotification('top', 'right','Harap pilih partai!', 'danger');
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
          <h5 class="title">Registrasi Data Caleg</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/admin/caleg/registerPost') }}" enctype="multipart/form-data">
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
                  <label for="exampleInputEmail1">Nama Belakang</label>
                  <input type="text" name="lname" class="form-control" placeholder="Nama Belakang" value="{{ old('lname') }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 pl-1">
                  <div class="form-group">
                    <label>Partai</label>
                    <select name="partai" id="partai" class="form-control">
                        <option value="0" selected>Pilih Partai</option>
                        @foreach($partai as $part)
                        {
                            <option value="{{ $part->id }}">{{ $part->partai }}</option>
                        }
                        @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-md-3 px-1">
                  <div class="form-group">
                    <label>Tingkatan Caleg</label>
                    <select name="tingkat" id="tingkat" class="form-control">
                        <option value="0" selected>Pilih Tingkatan</option>
                        <option value="a">Presiden</option>
                        <option value="b">DPD</option>
                        <option value="c">DPR RI</option>
                        <option value="d">DPR Provinsi</option>
                        <option value="e">DPR Kabupaten</option>
                    </select>
                  </div>
              </div>
            
              <div class="col-md-3 pr-1">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="form-control">
                      <option value="0">Pilih jenis kelamin</option>
                          <option value="l">Laki-laki</option>
                          <option value="p">Perempuan</option>
                    </select>
                  </div>
              </div>
              <div class="col-md-3 pr-1">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Pilih Dapil</label>
                    <select name="dapil" id="dapil" class="form-control">
                      <option value="0">Pilih Dapil</option>
                          <option value="1">Dapil 1</option>
                          <option value="2">Dapil 2</option>
                          <option value="3">Dapil 3</option>
                          <option value="4">Dapil 4</option>
                          <option value="5">Dapil 5</option>
                    </select>
                  </div>
                  *Untuk presiden dapil boleh dikosongkan
              </div>
              
          </div>
          <div class="row">
            <div class="col-md-6 pl-1">
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
            <div class="col-md-6 pr-1">
              <label>Preview</label>
              <div class="form-group">
                
                <img id='img-upload'/>
              </div>
            </div>
          </div>
            </div>
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