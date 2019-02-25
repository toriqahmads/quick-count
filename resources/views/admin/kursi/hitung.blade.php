 <div class="row">
    <div class="col-md-12">
        <div class="card-body">
        <div class="row">
          <h3>Tabel Hasil Penghitungan Kursi</h3>
        </div>
          <div class="table-responsive">
            <table class="table" id="myTable">
              <thead class=" text-primary">
                <th onclick="sortTable(0)" style="cursor: pointer;">
                  Partai
                </th>
                <th onclick="sortTable(1)" style="cursor: pointer;">
                  Kursi
                </th>
              </thead>
              <tbody>
                @foreach($hasil['kursi'] as $parta => $suara)
                  <tr>
                      <td>{{ $parta }}</td>
                      <td>{{ $suara }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        <form id="winnerform" method="POST" action="{{ url('/kursi/winner') }}" class="form" enctype="multipart/form-data">
          <div class="input-group form-group-no-border input-lg">
            {{ csrf_field() }}
            @foreach($hasil['kursi'] as $parta => $suara)
              @foreach($partai as $part)
                @if($part->partai == $parta)
                <input type="hidden" name="kursi[{{$part->id}}]" value="{{$suara}}">
                @endif
              @endforeach
            @endforeach
            <input type="submit" id="winner" class="btn-primary btn btn-round btn-block" value="Tampilkan Caleg Terpilih" />
          </div>
        </form>
      </div>
    </div>
</div>