@extends('admin.basedashboard')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Table Daftar Saksi</h4>
            <input type="text" placeholder="Cari..." class="form-control form-control-success" id="myInput"/>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="myTable">
              <thead class=" text-primary">
                <th onclick="sortTable(0)" style="cursor: pointer;">
                  No.
                </th>
                <th onclick="sortTable(1)" style="cursor: pointer;">
                  Nama
                </th>
                <th onclick="sortTable(2)" style="cursor: pointer;">
                  NIK
                </th>
                <th onclick="sortTable(3)" style="cursor: pointer;">
                  Kecamatan
                </th>
                <th onclick="sortTable(4)" style="cursor: pointer;">
                  Kelurahan
                </th>
                <th onclick="sortTable(5)" style="cursor: pointer;">
                  TPS
                </th>
                <th onclick="sortTable(6)" style="cursor: pointer;">
                  HP
                </th>
                <th>
                  Aksi
                </th>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                @foreach($req as $data)
                  <tr>
                      <td class="text-center">{{$no++}}</td>
                      <td>{{ $data->nama_depan }} {{ $data->nama_belakang }}</td>
                      <td>{{ $data->nik }}</td>
                      <td>{{ $data->kec}}</td>
                      <td>{{ $data->kel }}</td>
                      <td>{{ $data->tps }}</td>
                      <td>{{ $data->telp }}</td>
                      <td class="td-actions text-right">
                        <form method="GET" action="{{ route('view.saksi', [$data->nik, $data->id]) }}">
                          <button type="submit" rel="tooltip" title="Lihat" class="btn btn-info btn-sm btn-icon">
                              <i class="now-ui-icons users_single-02"></i>
                          </button>
                        </form>
                        <form method="GET" action="{{ route('edit.saksi', [$data->nik, $data->id]) }}">
                          <button type="submit" rel="tooltip" title="Edit" class="btn btn-success btn-sm btn-icon">
                              <i class="now-ui-icons design-2_ruler-pencil"></i>
                          </button>
                        </form>
                          <form method="POST" action="{{ route('delete.saksi', [$data->nik, $data->id]) }}">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="submit" rel="tooltip" title="Hapus" class="btn btn-danger btn-sm btn-icon">
                                <i class="now-ui-icons ui-1_simple-remove"></i>
                              </button>
                          </form>
                      </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $req->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection