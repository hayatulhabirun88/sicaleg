<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>TIM PEMENANGAN</title>
    @livewireStyles
</head>

<body>
    
    @include('layout.navbar')

    @if (session()->has('success'))
        <div class="alert alert-success"> {{ session('success') }}</div>
    @endif
    <div class="container">
        <div class="row my-5">

            <div class="col-md-3 mb-3">
                <form action="{{ route('import.prosess') }}" enctype="multipart/form-data" method="post">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="file">Import Data DPT</label>
                        <input id="file" class="form-control" type="file" name="file">

                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <input type="submit" name="submit" value="Upload" class="btn btn-primary">
                </form>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td>Laki-laki</td>
                                    <td>:</td>
                                    <td>{{ number_format($laki2) }}</td>
                                </tr>
                                <tr>
                                    <td>Perempuan</td>
                                    <td>:</td>
                                    <td>{{ number_format($perempuan) }}</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td>:</td>
                                    <td>{{ number_format($total) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Kecamatan</td>
                                        <td>Laki-laki</td>
                                        <td>Perempuan</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($kecamatan as $item)
                                        <tr>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td>{{ number_format(\App\Models\Dpt::where('jenis_kelamin', 'L')->where('kecamatan', $item->kecamatan)->count()) }}
                                            </td>
                                            <td>{{ number_format(\App\Models\Dpt::where('jenis_kelamin', 'P')->where('kecamatan', $item->kecamatan)->count()) }}
                                            </td>
                                            <td>{{ number_format($item->jumlah) }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
        @livewireScripts
</body>

</html>
