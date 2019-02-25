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
                  No
                </th>
                <th onclick="sortTable(0)" style="cursor: pointer;">
                  Nama
                </th>
                <th onclick="sortTable(1)" style="cursor: pointer;">
                  Parti
                </th>
                <th onclick="sortTable(2)" style="cursor: pointer;">
                  Total Suara
                </th>
              </thead>
              <tbody>
                <?php $x =1; ?>
                @foreach($hasil as $data)
                  @foreach($data as $data)
                  <tr>
                      <td>{{ $x }}</td>
                      <td>{{ $data->nama_depan }} {{ $data->nama_belakang }}</td>
                      <td>{{ $data->partai }}</td>
                      <td>{{ $data->total_suara }}</td>
                  </tr>
                  <?php $x++; ?>
                  @endforeach
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
    </div>
</div>