@extends('admin.basedashboard')
@section('content')
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
          <h5 class="title">Edit Data Caleg</h5>
        </div>
        <div class="card-body">
          <form class="form" method="post" action="{{ url('/caleg/updateCalegProfile') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label>Nama Depan</label>
                  <input type="text" name="fname" class="form-control" placeholder="Nama Depan" value="{{ $data->nama_depan }}">
                </div>
              </div>
              <div class="col-md-6 pr-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Belakang</label>
                  <input type="text" name="lname" class="form-control" placeholder="Nama Belakang" value="{{ $data->nama_belakang }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                  <select name="gender" class="form-control" id="gender">
                    <option value="0">Pilih jenis kelamin</option>
                    @if($data->gender == "l")
                      {
                        <option value="{{ $data->gender }}" selected>Laki-laki</option>
                        <option value="p">Perempuan</option>
                      }
                      @else
                      {
                       	<option value="{{ $data->gender }}" selected>Perempuan</option>
                        <option value="l">Laki-laki</option>
                      }
                      @endif
                  </select>
                </div>
              </div>

              <div class="col-md-6 pr-1">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Pilih Dapil</label>
                    <select name="dapil" id="dapil" class="form-control">
                      <option value="0">Pilih Dapil</option>
                          <option value="1"<?php echo $data->id_dapil == 1 ? 'selected' : ''; ?>>Dapil 1</option>
                          <option value="2"<?php echo $data->id_dapil == 2 ? 'selected' : ''; ?>>Dapil 2</option>
                          <option value="3"<?php echo $data->id_dapil == 3 ? 'selected' : ''; ?>>Dapil 3</option>
                          <option value="4"<?php echo $data->id_dapil == 4 ? 'selected' : ''; ?>>Dapil 4</option>
                          <option value="5"<?php echo $data->id_dapil == 5 ? 'selected' : ''; ?>>Dapil 5</option>
                    </select>
                  </div>
                  *Untuk presiden dapil boleh dikosongkan
              </div>
            </div>
            <div class="row">

            </div>
            <div class="row">
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Partai</label>
                  <select name="partai" class="form-control" id="partai">
                    <option value="0">Partai</option>
                    @foreach($partais as $partai)
                    {
                      @if($partai->id != $data->id_partai)
                      {
                        <option value="{{ $partai->id }}">{{ $partai->partai }}</option>
                      }
                      @else
                      {
                        <option value="{{ $partai->id }}" selected>{{ $partai->partai }}</option>
                      }
                      @endif
                    }
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6 pl-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Tingkatan</label>
                  <select name="tingkat" class="form-control" id="tingkat">
                    <option value="0">Tingkatan</option>
                        @if($data->tingkat == 'a')
                        <option value="a" selected>Presiden</option>
                        <option value="b">DPD</option>
                        <option value="c">DPR RI</option>
                        <option value="d">DPR Provinsi</option>
                        <option value="e">DPR Kabupaten</option>
                          @elseif($data->tingkat == 'b')
                        <option value="a">Presiden</option>
                        <option value="b" selected>DPD</option>
                        <option value="c">DPR RI</option>
                        <option value="d">DPR Provinsi</option>
                        <option value="e">DPR Kabupaten</option>
                          @elseif($data->tingkat == 'c')
                        <option value="a">Presiden</option>
                        <option value="b">DPD</option>
                        <option value="c" selected>DPR RI</option>
                        <option value="d">DPR Provinsi</option>
                        <option value="e">DPR Kabupaten</option>
                          @elseif($data->tingkat == 'd')
                        <option value="a">Presiden</option>
                        <option value="b">DPD</option>
                        <option value="c">DPR RI</option>
                        <option value="d" selected>DPR Provinsi</option>
                        <option value="e">DPR Kabupaten</option>
                          @else
                        <option value="a">Presiden</option>
                        <option value="b">DPD</option>
                        <option value="c">DPR RI</option>
                        <option value="d">DPR Provinsi</option>
                        <option value="e" selected>DPR Kabupaten</option>
                          @endif
                    </select>
                </div>
              </div>
              
            </div>
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="foto" value="{{ $data->foto }}">
            <div class="row">
            <div class="col-md-6 pl-1">
                <div class="form-group">
                    <label>Foto</label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse… <input type="file" name="fotos" id="imgInp">
                            </span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pr-1">
              <label>Preview</label>
              <div class="form-group">
                <img id='img-upload' src="{{ asset('img/caleg') }}/{{ $data->foto }}"/>
              </div>
            </div>
          </div>
            <div class="input-group form-group-no-border input-lg">
                <input type="submit" class="btn-primary btn btn-round btn-block" value="Simpan Perubahan" />
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card card-user">
        <div class="image">
          <img src="{{ asset('img/bg5.jpg') }}" alt="...">
        </div>
        <div class="card-body">
          <div class="author">
            <a href="#">
              <img class="avatar border-gray" src="{{ asset('img/caleg') }}/{{$data->foto}}" alt="...">
              <h5 class="title">{{ $data->nama_depan }} {{ $data->nama_belakang }}</h5>
            </a>
          </div>
          <p class="description">
              Dapil : {{ $data->id_dapil }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready( function() {
      $(document).on('change', '.btn-file :file', function() {
    var input = $(this),
      label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [label]);
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function(){
        readURL(this);
    });   
  });
</script>
@endsection