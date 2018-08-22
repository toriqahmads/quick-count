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
              <img class="avatar rounded-circle img-raised" src="{{ asset('img/demak.png') }}" alt="...">
              <h5 class="title">{{ $data->tps }}</h5>
            </a>
          </div>
          <p class="description">
            {{ $data->kel }}, {{ $data->kec }}, {{ $data->kab }}, {{ $data->prov }}
          </p>
          <p class="description">
              Dapil : {{ $data->id_dapil }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection