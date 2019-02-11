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
              <img class="avatar rounded-circle img-raised" src="{{ asset('img/partai') }}/{{$data->foto}}" alt="{{$data->foto}}">
              <h5 class="title">{{ $data->partai }}</h5>
            </a>
          </div>
          <p class="description">
            Nama Partai : {{ $data->partai }}
          </p>
          <p class="description">
            Nomor Urut : {{ $data->no_urut }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection