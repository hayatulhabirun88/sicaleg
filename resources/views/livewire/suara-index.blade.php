<div class="container-fluid">
    <h1 class="text-center">PERHITUNGAN SUARA</h1>

    <div class="row" id="suara">
    </div>

    <script >
        $(document).ready(function () {
            hitung_suara();

            setInterval(() => {
                hitung_suara();
            }, 5000);



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

                    $('#suara').html(response.html);
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
