@extends('saksi.base')
@section('content')
<script src="{{ asset('js/getreg.js') }}"></script>
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
<div class="col-md-12 content-center">
    <div class="card card-login card-plain">
        <form class="form" method="post" action="{{ url('/saksi/registPost') }}">
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
                        <input type="number" name="nik" class="form-control" placeholder="Nomor NIK" value="{{ old('nik') }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" name="telp" placeholder="Nomor HP" class="form-control" value="{{ old('telp') }}"/>
                    </div>
                </div>

                <div class="form-group">
                  <input type="text" name="alamat" placeholder="Alamat" class="form-control" value="{{ old('alamat') }}">
                </div>

                <div class="form-group">
                  <select name="gender" id="gender" class="form-control">
                    <option value="0" selected>Jenis Kelamin</option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                  </select>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6">
                      <select name="prov" id="prov" class="form-control">
                        <option value="0" selected>Provinsi</option>
                        @foreach($prov as $p)
                        {
                            <option value="{{ $p->id }}">{{ $p->prov }}</option>
                        }
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group col-sm-6">
                      <select name="kab" id="kab" class="form-control">
                        <option value="0" selected>Kabupaten</option>
                      </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-6">
                      <select name="kec" id="kec" class="form-control">
                        <option value="0" selected>Kecamatan</option>
                      </select>
                    </div>
                    <div class="form-group col-sm-6">
                      <select name="kel" id="kel" class="form-control">
                        <option value="0" selected>Kelurahan</option>
                      </select>
                    </div>
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
                <div class="input-group form-group-no-border input-lg">
                    <input type="submit" class="btn-primary btn btn-round btn-block" value="Register" />
                </div>

                <div class="pull-left">
                <h6>
                    <a href="{{ url('/saksi/login') }}" class="link">Login</a>
                </h6>
                </div>
            </div>
            
        </form>
    </div>
</div>
@endsection