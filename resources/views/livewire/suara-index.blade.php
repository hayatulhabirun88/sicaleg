<div class="container-fluid">
    <h1 class="text-center">PERHITUNGAN SUARA</h1>

    <div class="row" id="persentasi_suara">
    </div>

    <div class="row mt-3" id="suara">
    </div>

    <div class="row" id="persentasi_suara_tps" style="padding:10px;background-color:yellow;font-weight:bold;margin:10px;">

    </div>

    <script >
        $(document).ready(function () {
            hitung_suara();

            setInterval(() => {
                hitung_suara();
            }, 1000);

        });

        let maxAttempts = 10; // Jumlah maksimum percobaan
        let interval = 10000; 
        let attemptCount = 0; 

        function hitung_suara(){
            $.ajax({
                type: "POST",
                url: "/suara/hitung",
                data: {
                    _token:'{{ csrf_token() }}'
                },
                success: function (response) {

                    $('#suara').html(response.html.jmlSuara);
                    $('#persentasi_suara').html(response.html.persentasiSuara);
                    $('#persentasi_suara_tps').html(response.html.persentasiSuaraTPS);
                },
                error: function(xhr, status, error) {

                    attemptCount++;
                    if (attemptCount < maxAttempts) {
                        // Jika jumlah percobaan belum mencapai batas maksimum
                        setTimeout(hitung_suara, interval);
                    } else {
                        let confirmation = confirm('Periksa koneksi internet anda!, apakah anda akan merefresh halaman?');
                        if (confirmation) {
                            location.reload();
                        }
                    }
                    
                }
            });
        }
    </script>
</div>
