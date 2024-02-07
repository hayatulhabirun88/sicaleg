<div class="container">
    <div class="row my-3">
        <div class="col-md-12">
            <h3 class="text-center">Laporan Target dan Pencapaian Dukungan Suara Per Daerah Pemilihan</h3>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-md-5">
            <h5 class="text-center">DAPIL 1 (Kecamatan Murhum, Betoambari dan Batupoaro)</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th scope="col">Nama Caleg</th>
                          <th scope="col">Dukungan</th>
                          <th scope="col">Target</th>
                          <th scope="col">Pencapaian</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dapil1 as $d1)
                    <tr>
                        <td>{{ $d1['caleg']}}</td>
                        <td>{{ number_format($d1['total'])}}</td>
                        <td>{{ number_format($targetdapil1) }} </td>
                        <td>{{ number_format((($d1['total'] / $targetdapil1) * 100), 2  ) }} % 
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ number_format((($d1['total'] / $targetdapil1) * 100), 2  ) }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{ number_format((($d1['total'] / $targetdapil1) * 100), 2  ) }}%"></div>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-7">
            <div>
                <canvas id="myChart1" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-md-5">
            <h5 class="text-center">DAPIL 2 (Kecamatan Bungi, Kokalukuna, Lea-lea dan Sorawolio)</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th scope="col">Nama Caleg</th>
                          <th scope="col">Dukungan</th>
                          <th scope="col">Target</th>
                          <th scope="col">Pencapaian</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dapil2 as $d2)
                    <tr>
                        <td>{{ $d2['caleg']}}</td>
                        <td>{{ number_format($d2['total'])}}</td>
                        <td>{{ number_format($targetdapil2) }} </td>
                        <td>{{ number_format((($d2['total'] / $targetdapil2) * 100), 2  ) }} % 
                            
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ number_format((($d2['total'] / $targetdapil2) * 100), 2  ) }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: {{ number_format((($d2['total'] / $targetdapil2) * 100), 2  ) }}%"></div>
                            </div>
                        
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-7">
            <div>
                <canvas id="myChart2"  height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-md-5">
            <h5 class="text-center">DAPIL 3 (Kecamatan Wolio)</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                          <th scope="col">Nama Caleg</th>
                          <th scope="col">Dukungan</th>
                          <th scope="col">Target</th>
                          <th scope="col">Pencapaian</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($dapil3 as $d3)
                    <tr>
                        <td>{{ $d3['caleg']}}</td>
                        <td>{{ number_format($d3['total'])}}</td>
                        <td>{{ number_format($targetdapil3) }} </td>
                        <td>{{ number_format((($d3['total'] / $targetdapil3) * 100), 2  ) }} % 
                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="{{ number_format((($d3['total'] / $targetdapil3) * 100), 2  ) }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: {{ number_format((($d3['total'] / $targetdapil3) * 100), 2  ) }}%"></div>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-7">
            <div>
                <canvas id="myChart3"  height="280"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('myChart1');
        const ctx2 = document.getElementById('myChart2');
        const ctx3 = document.getElementById('myChart3');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($pendukung['dapilcaleg1']) ?>,
                datasets: [{
                    label: '# Perolehan Dukungan Daerah Pemilihan 1 ',
                    data: <?php echo json_encode($pendukung['dapiltotal1']) ?>,
                    backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
					],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($pendukung['dapilcaleg2']) ?>,
                datasets: [{
                    label: '# Perolehan Dukungan Daerah Pemilihan 2 ',
                    data: <?php echo json_encode($pendukung['dapiltotal2']) ?>,
                    backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
					],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($pendukung['dapilcaleg3']) ?>,
                datasets: [{
                    label: '# Perolehan Dukungan Daerah Pemilihan 3 ',
                    data: <?php echo json_encode($pendukung['dapiltotal3']) ?>,
                    backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
					],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>
