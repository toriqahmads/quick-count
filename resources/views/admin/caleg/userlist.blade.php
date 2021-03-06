@extends('admin.basedashboard')
@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Table Daftar Caleg</h4>
          <div class="col-md-3 px-1">
              <div class="form-group">
                <label>Tingkatan Caleg</label>
                <select name="tingkat" id="tingkat" class="form-control">
                    <option value="0" <?php echo Request::segment(3) == '0' ? 'selected' : ''; ?>>Pilih Tingkatan</option>
                    <option value="a" <?php echo Request::segment(3) == 'a' ? 'selected' : ''; ?>>Presiden</option>
                    <option value="b" <?php echo Request::segment(3) == 'b' ? 'selected' : ''; ?>>DPD</option>
                    <option value="c" <?php echo Request::segment(3) == 'c' ? 'selected' : ''; ?>>DPR RI</option>
                    <option value="d" <?php echo Request::segment(3) == 'd' ? 'selected' : ''; ?>>DPR Provinsi</option>
                    <option value="e" <?php echo Request::segment(3) == 'e' ? 'selected' : ''; ?>>DPR Kabupaten</option>
                </select>
              </div>
          </div>
          <div class="input-group">
            <input type="text" placeholder="Cari..." class="form-control form-control-success" id="myInput"/>
            <div class="input-group-append">
              <div class="input-group-text">
                <i class="now-ui-icons ui-1_zoom-bold"></i>
              </div>
            </div>
          </div>
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
                  Partai
                </th>
                <th onclick="sortTable(3)" style="cursor: pointer;">
                  Tingkatan
                </th>
                <th onclick="sortTable(4)" style="cursor: pointer;">
                  Dapil
                </th>
                <th>
                  Aksi
                </th>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                @foreach($req as $data)
                  <tr id="{{$data->id}}">
                      <td>{{$no++}}</td>
                      <td>{{ $data->nama_depan }} {{ $data->nama_belakang }}</td>
                      <td>{{ $data->partai}}</td>
                      <td>@if($data->tingkat == 'a')
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
                      </td>
                      <td>@foreach($dapil as $dap) @if($data->id_dapil == $dap->id){{$dap->dapil}}@endif @endforeach</td>
                      <td>
                        <form method="GET" action="{{ route('view.caleg', [$data->id]) }}" class="btn btn-info btn-sm btn-icon">
                          <button type="submit" rel="tooltip" title="Lihat" class="btn btn-info btn-sm btn-icon">
                              <i class="now-ui-icons users_single-02"></i>
                          </button>
                        </form>
                        <form method="GET" action="{{ route('edit.caleg', [$data->id]) }}" class="btn btn-success btn-sm btn-icon">
                          <button type="submit" rel="tooltip" title="Edit" class="btn btn-success btn-sm btn-icon">
                              <i class="now-ui-icons design-2_ruler-pencil"></i>
                          </button>
                        </form>
                          <form id="hapuscaleg{{$data->id}}" method="POST" action="{{ route('delete.caleg', [$data->id]) }}" class="btn btn-danger btn-sm btn-icon">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <button type="submit" rel="tooltip" title="Hapus" class="hapus btn btn-danger btn-sm btn-icon">
                                <i class="now-ui-icons ui-1_simple-remove"></i>
                              </button>
                          </form>
                      </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          {{ $req->appends(['tingkat' => Request::segment(3)])->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="{{ asset('js/delete-caleg.js')}}"></script>
  <script src="{{ asset('js/listcaleg.js')}}"></script>
@endsection