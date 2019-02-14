@extends('saksi.basedashboard')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-user">
        <div class="image">
          <img src="{{ asset('img/bg5.jpg') }}" alt="...">
        </div>
        <div class="card-body">
          <div class="author">
            <a href="#">
              <img class="avatar rounded-circle img-raised" src="{{ asset('img/saksi') }}/{{$data->foto}}" alt="...">
              <h5 class="title">{{ $data->nama_depan }} {{ $data->nama_belakang }}</h5>
            </a>
            <p class="description">
              NIK : {{ $data->nik }}
            </p>
            <p class="description">
              HP : {{ $data->telp }}
          </p>
          </div>
          <p class="description">
            {{ $data->alamat }}, {{ $data->kel }}, {{ $data->kec }}, {{ $data->kab }}, {{ $data->prov }}
          </p>
          <!--<p class="description">
              ID Dapil Kecamatan : {{ $data->dapil_kec }}
          </p>
          <p class="description">
              ID Dapil Kabupaten : {{ $data->dapil_kab }}
          </p>
          <p class="description">
              ID Dapil Provinsi : {{ $data->dapil_prov }}
          </p>-->
          <p class="description">
              TPS : {{ $data->tps }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection