@extends('admin.basedashboard')
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
              <img class="avatar border-gray" src="{{ asset('img/') }}/default_avatar.jpg" alt="...">
              <h5 class="title">{{ $data->nama_depan }} {{ $data->nama_belakang }}</h5>
            </a>
          </div>
          <p class="description">
            {{ $data->kel }}, {{ $data->kec }}, {{ $data->kab }}, {{ $data->prov }}
          </p>
          <p class="description">
              Dapil : {{ $data->id_dapil }}
          </p>
          <p class="description">
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
        </div>
      </div>
    </div>
  </div>
</div>
@endsection