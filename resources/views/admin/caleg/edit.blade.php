@extends('admin.basedashboard')
@section('content')
<script src="{{ asset('js/getregcaleg.js')}}" type="text/javascript"></script>

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
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label>Nama Depan</label>
                  <input type="text" name="fname" class="form-control" placeholder="Nama Depan" value="{{ $data->nama_depan }}">
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nama Belakang</label>
                  <input type="text" name="lname" class="form-control" placeholder="Nama Belakang" value="{{ $data->nama_belakang }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Jenis Kelamin</label>
                  <select name="gender" class="form-control" id="gender">
                    <option value="0">Pilih jenis kelamin</option>
                      <option value="l" <?php echo $data->gender == 'l' ? 'selected' : ''; ?>>Laki-laki</option>
                       <option value="p" <?php echo $data->gender == 'p' ? 'selected' : ''; ?>>Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Partai</label>
                  <select name="partai" class="form-control" id="partai">
                    <option value="0">Partai</option>
                    @foreach($partais as $partai)
                        <option value="{{ $partai->id }}" <?php echo $data->id_partai == $partai->id ? 'selected' : ''; ?>>{{ $partai->partai }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Tingkatan</label>
                  <select name="tingkat" class="form-control" id="tingkat">
                    <option value="0">Tingkatan</option>
                        <option value="a" <?php echo $data->tingkat == 'a' ? 'selected' : ''; ?>>Presiden</option>
                        <option value="b" <?php echo $data->tingkat == 'b' ? 'selected' : ''; ?>>DPD</option>
                        <option value="c" <?php echo $data->tingkat == 'c' ? 'selected' : ''; ?>>DPR RI</option>
                        <option value="d" <?php echo $data->tingkat == 'd' ? 'selected' : ''; ?>>DPR Provinsi</option>
                        <option value="e" <?php echo $data->tingkat == 'e' ? 'selected' : ''; ?>>DPR Kabupaten</option>
                    </select>
                </div>
              </div>
              <div class="col-md-6 px-1">
                <div class="form-group">
                  <label for="exampleFormControlSelect1">Nomor urut</label>
                  <input type="number" name="no_urut" class="form-control" placeholder="Nomor urut calon" value="{{ $data->no_urut }}" required>
                </div>
              </div>
            </div>
            <div class="row">
            @if(isset($data->id_prov))
              <div class="col-md-3 px-1 prov">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Provinsi</label>
                    <select name="prov" id="prov" class="form-control">
                      <option value="0">Pilih provinsi</option>
                      @foreach($provinsi as $province)
                        <option value="{{$province->id}}" <?php echo $data->id_prov == $province->id ? 'selected' : ''; ?>>{{$province->prov}}</option>
                      @endforeach
                    </select>
                </div>
              </div>
            @else
              <div class="col-md-3 px-1 prov" hidden="true">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Provinsi</label>
                    <select name="prov" id="prov" class="form-control">
                    </select>
                </div>
              </div>
            @endif
            @if(isset($data->id_kab))
            <div class="col-md-3 px-1 kab">
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Kabupaten</label>
                  <select name="kab" id="kab" class="form-control">
                    <option value="0">Pilih kabupaten</option>
                    @foreach($kab as $kabupaten)
                      <option value="{{$kabupaten->id}}" <?php echo $data->id_kab == $kabupaten->id ? 'selected' : ''; ?>>{{$kabupaten->kab}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            @else
            <div class="col-md-3 px-1 kab" hidden="true">
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Kabupaten</label>
                  <select name="kab" id="kab" class="form-control">
                  </select>
              </div>
            </div>
            @endif
            @if(isset($data->id_kec))
            <div class="col-md-3 px-1 kec">
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Kecamatan</label>
                  <select name="kec" id="kec" class="form-control">
                    <option value="0">Pilih kecamatan</option>
                    @foreach($kec as $kec)
                      <option value="{{$kec->id_kec}}" <?php echo $data->id_kec == $kec->id_kec ? 'selected' : ''; ?>>{{$kec->kec}}</option>
                    @endforeach
                  </select>
              </div>
            </div>
            @else
            <div class="col-md-3 px-1 kec" hidden="true">
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Kecamatan</label>
                  <select name="kec" id="kec" class="form-control">
                  </select>
              </div>
            </div>
            @endif
            @if(isset($data->id_dapil))
            <div class="col-md-3 px-1 dapil">
                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Pilih Dapil</label>
                    <select name="dapil" id="dapil" class="form-control">
                      <option value="0">Pilih Dapil</option>
                      @foreach($dapil as $dap)
                          @if($data->id_dapil == $dap->id)<option value="{{ $dap->id }}" selected>{{ $dap->dapil }}</option>
                          @endif
                      @endforeach
                    </select>
                  </div>
              </div>
            @else
            <div class="col-md-3 px-1 dapil" hidden="true">
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Dapil</label>
                  <select name="dapil" id="dapil" class="form-control">
                    <option value="0" selected>Pilih dapil</option>
                  </select>
              </div>
            </div>
            @endif
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
          @if(isset($data->id_dapil))
          <p class="description">
              Dapil : @foreach($dapil as $dap) @if($data->id_dapil == $dap->id){{$dap->dapil}}@endif @endforeach
          </p>
          @endif
          <p class="description">
            Tingkat :
            @if($data->tingkat == 'a')
              Presiden
            @elseif($data->tingkat == 'b')
              DPD
            @elseif($data->tingkat == 'c')
              DPR RI
            @elseif($data->tingkat == 'd')
              DPR Provinsi
            @else
              DPR Kabupaten
            @endif
          </p>
          <p class="description">
            Partai : {{$data->partai}}
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