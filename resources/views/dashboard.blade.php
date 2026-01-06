<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Dashboard Inventory Kesehatan</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">

    {{-- Pastikan path asset ini benar sesuai folder public Anda --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('assets/demo/demo.css') }}" rel="stylesheet" />
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            @include('sidebar')
        </div>

        <div class="main-panel">
            @include('navbar')

            <div class="content">
                {{-- KARTU STATISTIK --}}
                <div class="row">
                    @php
                    $cards = [
                    [
                    'title' => 'Ibu Hamil',
                    'count' => $totalibuhamil ?? 0,
                    'icon' => 'nc-single-02',
                    'color' => 'text-warning',
                    'footer' => 'Data Terupdate',
                    'desc' => 'Data pemantauan kesehatan ibu selama masa kehamilan hingga persalinan.'
                    ],
                    [
                    'title' => 'Data ODGJ',
                    'count' => $totalodgj ?? 0,
                    'icon' => 'nc-bulb-63',
                    'color' => 'text-success',
                    'footer' => 'Pasien Aktif',
                    'desc' => 'Pendataan dan pemantauan rutin untuk pasien dengan gangguan jiwa.'
                    ],
                    [
                    'title' => 'Hipertensi',
                    'count' => $totalhipertensi ?? 0,
                    'icon' => 'nc-favourite-28',
                    'color' => 'text-danger',
                    'footer' => 'Terpantau',
                    'desc' => 'Catatan tekanan darah dan faktor risiko pasien penyakit tidak menular.'
                    ],
                    [
                    'title' => 'Data Lansia',
                    'count' => $totallansia ?? 0,
                    'icon' => 'nc-satisfied',
                    'color' => 'text-primary',
                    'footer' => 'Pemeriksaan Rutin',
                    'desc' => 'Data pelayanan kesehatan rutin untuk masyarakat lanjut usia.'
                    ],
                    [
                    'title' => 'Data Balita',
                    'count' => $totalbalita ?? 0,
                    'icon' => 'nc-controller-modern',
                    'color' => 'text-info',
                    'footer' => 'Tumbuh Kembang',
                    'desc' => 'Pemantauan pertumbuhan, imunisasi, dan status gizi anak balita.'
                    ]
                    ];
                    @endphp

                    @foreach($cards as $card)
                    <div class="col-lg-4 col-md-6 col-sm-6 mb-4"> {{-- Diubah ke col-lg-4 agar teks penjelasan lebih rapi --}}
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center"><i class="nc-icon {{ $card['icon'] }} {{ $card['color'] }}"></i></div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">{{ $card['title'] }}</p>
                                            <p class="card-title">{{ $card['count'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                {{-- Penjelasan Data 1 Baris --}}
                                <p class="card-category text-dark small" style="text-transform: none;">{{ $card['desc'] }}</p>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats">{{ $card['footer'] }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- GRAFIK --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Statistik Pasien</h5>
                                <p class="card-category">Visualisasi perbandingan jumlah data pasien yang terdaftar di sistem.</p>
                            </div>
                            <div class="card-body">
                                <canvas id="chartPreferences" width="400" height="400"></canvas>
                            </div>
                            <div class="card-footer">
                                <div class="legend">
                                    <i class="fa fa-circle text-warning"></i> Ibu Hamil
                                    <i class="fa fa-circle text-success"></i> ODGJ
                                    <i class="fa fa-circle text-danger"></i> Hipertensi
                                    <i class="fa fa-circle text-primary"></i> Lansia
                                    <i class="fa fa-circle" style="color: #6bd098;"></i> Balita
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}!</h5>
                                <p class="card-category">Akses utama manajemen informasi kesehatan terpadu Puskesmas Pekapuran Laut.</p>
                            </div>
                            <div class="card-body">
                                <p>Sistem ini digunakan untuk mencatat dan mengolah data pelayanan kesehatan secara terpadu di Puskesmas Pekapuran Laut.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>

    {{-- Script JS --}}
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    {{-- Chart JS Wajib Dimuat Sebelum Script Custom --}}
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            // Ambil elemen canvas
            var ctx = document.getElementById("chartPreferences");
            if (!ctx) return;

            // Menggunakan Number() dan quotes agar tidak dirusak auto-formatter
            var dataIbu = Number("{{ $totalibuhamil ?? 0 }}");
            var dataOdgj = Number("{{ $totalodgj ?? 0 }}");
            var dataHipertensi = Number("{{ $totalhipertensi ?? 0 }}");
            var dataLansia = Number("{{ $totallansia ?? 0 }}");
            var dataBalita = Number("{{ $totalbalita ?? 0 }}");

            var myChart = new Chart(ctx.getContext("2d"), {
                type: 'pie',
                data: {
                    labels: ["Ibu Hamil", "ODGJ", "Hipertensi", "Lansia", "Balita"],
                    datasets: [{
                        backgroundColor: ['#ffcc00', '#4acccd', '#ef8157', '#51cbce', '#6bd098'],
                        borderWidth: 0,
                        data: [dataIbu, dataOdgj, dataHipertensi, dataLansia, dataBalita]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    }
                }
            });
        });
    </script>
</body>

</html>