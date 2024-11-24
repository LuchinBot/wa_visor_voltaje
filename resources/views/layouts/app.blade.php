<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Voltaje en Tiempo Real')</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
    body {
        font-family: "Prompt", sans-serif;
        margin: 0;
        padding: 0;
    }

    canvas {
        width: 100%;
        height: 400px;
    }

    #consola {
        background-color: #f0f0f0;
        padding: 10px;
        margin-top: 20px;
        height: auto;
    }
    </style>
</head>

<body style="background-color: #e0e2e4;">
    <div class="container-fluid bg-white">
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
                <a href="/"
                    class="d-flex justify-content-start align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                    <span class="fs-4 text-success"><strong>Dra</strong>Voltaje</span>
                </a>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="{{ url('/') }}"
                            class="nav-link {{ Request::is('/') ? 'bg-success active' : 'text-success' }}"
                            aria-current="page">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('consultas') }}"
                            class="nav-link {{ Request::is('consultas') ? 'bg-success active' : 'text-success' }}">Consultas</a>
                    </li>
                </ul>
            </header>
        </div>
    </div>

    <div class="container py-3 text-left">
        @yield('content')
    </div>

    @yield('scripts')

</body>

</html>