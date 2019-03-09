 <div class="row">
    <div class="col-md-12">
        <div class="card-body">
        <div class="row">
          <h3>Tabel Hasil Pembagian</h3>
        </div>
          <div class="table-responsive">
            <table class="table" id="myTable">
              <thead class=" text-primary">
                <th onclick="sortTable(0)" style="cursor: pointer;">
                  Partai
                </th>
                <?php $x = 1; ?>
                @foreach($divisor as $div)
                <th onclick="sortTable(<?php echo $x; ?>)" style="cursor: pointer;">
                  {{$div}}
                </th>
                  <?php $x++; ?>
                @endforeach
              </thead>
              <tbody>
                @foreach($data as $partai => $divisor)
                  <tr>
                    <th>{{ $partai }}</td>
                    @foreach($divisor as $div => $suara)
                      <td>{{ $suara }}</td>
                    @endforeach
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
        <form method="GET" action="" class="form">
          <div class="input-group form-group-no-border input-lg">
            <input type="submit" id="hitung" class="btn-primary btn btn-round btn-block" value="Hitung Kursi" />
          </div>
        </form>
      </div>
    </div>
</div>