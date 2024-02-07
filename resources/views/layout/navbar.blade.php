<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Hi {{ Auth::user()->name }} !</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="/suara">Suara</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="/input-suara">Input Suara</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="/">Data Dpt</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " aria-current="page" href="/pendukung">Pendukung</a>
                </li>

                @if (Auth::user()->level == 'admin')
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/caleg">Caleg</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/saksi">Saksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/tps">Tps</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/pengguna">Pengguna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " aria-current="page" href="/get-import">Import</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Report
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/report">Per Dapil</a></li>
                            <li><a class="dropdown-item" href="/report/pertps">Per TPS</a></li>
                            <li><a class="dropdown-item" href="/report/percaleg">Per Caleg</a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    
                    <a class="nav-link " aria-current="page" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
