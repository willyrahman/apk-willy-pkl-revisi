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

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/paper-dashboard.css?v=2.0.1') }}" rel="stylesheet" />
    <link href="{{ asset('assets/demo/demo.css') }}" rel="stylesheet" />
</head>

<body class="">
    <div class="wrapper ">
        <div class="sidebar" data-color="white" data-active-color="danger">
            @include('sidebar')
        </div>

        <div class="main-panel">
            @include('navbar')

            <div class="content">
                {{-- ROW 1: KARTU STATISTIK --}}
                <div class="row">
                    {{-- KARTU 1: DATA IBU HAMIL --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-single-02 text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Ibu Hamil</p>
                                            <p class="card-title">{{ $totalibuhamil ?? 0 }}
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats"><i class="fa fa-refresh"></i> Data Terupdate</div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU 2: DATA ODGJ --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-bulb-63 text-success"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Data ODGJ</p>
                                            <p class="card-title">{{ $totalodgj ?? 0 }}
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats"><i class="fa fa-check-square"></i> Pasien Aktif</div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU 3: DATA HIPERTENSI --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-favourite-28 text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Hipertensi</p>
                                            <p class="card-title">{{ $totalhipertensi ?? 0 }}
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats"><i class="fa fa-heartbeat"></i> Terpantau</div>
                            </div>
                        </div>
                    </div>

                    {{-- KARTU 4: DATA LANSIA (BARU) --}}
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-satisfied text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Data Lansia</p>
                                            <p class="card-title">{{ $totallansia ?? 0 }}
                                            <p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats"><i class="fa fa-user"></i> Pemeriksaan Rutin</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ROW 2: GRAFIK & INFORMASI --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Statistik Pasien</h5>
                                <p class="card-category">Proporsi Data Kesehatan</p>
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h5 class="card-title">Selamat Datang, Admin!</h5>
                                <p class="card-category">Sistem Informasi Kesehatan Terpadu</p>
                            </div>
                            <div class="card-body">
                                <p class="text-justify">
                                    Ini adalah dashboard utama untuk memantau data kesehatan masyarakat di wilayah kerja Puskesmas.
                                    Anda dapat mengelola data berikut melalui menu di samping:
                                </p>
                                <ul>
                                    <li><strong>Ibu Hamil:</strong> Pemantauan kehamilan dan risiko tinggi.</li>
                                    <li><strong>ODGJ:</strong> Pendataan pasien dengan gangguan jiwa dan jadwal kontrol.</li>
                                    <li><strong>Hipertensi:</strong> Monitoring tekanan darah dan faktor risiko.</li>
                                    <li><strong>Lansia:</strong> Data kesehatan lansia dan posyandu.</li>
                                </ul>
                                <hr>
                                <div class="alert alert-info alert-with-icon" data-notify="container">
                                    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
                                    <span data-notify="message">Jangan lupa melakukan backup data secara berkala.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('footer')
        </div>
    </div>

    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('assets/js/paper-dashboard.min.js?v=2.0.1') }}" type="text/javascript"></script>

    <script>
        $(document).ready(function() {
            var ctx = document.getElementById("chartPreferences").getContext("2d");

            // Ambil data dari PHP Variable
            var dataIbu = {
                {
                    $totalibuhamil ?? 0
                }
            };
            var dataOdgj = {
                {
                    $totalodgj ?? 0
                }
            };
            var dataHipertensi = {
                {
                    $totalhipertensi ?? 0
                }
            };
            var dataLansia = {
                {
                    $totallansia ?? 0
                }
            };

            var myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ["" + dataIbu + "%", "" + dataOdgj + "%", "" + dataHipertensi + "%", "" + dataLansia + "%"],
                    datasets: [{
                        label: "Emails",
                        pointRadius: 0,
                        pointHoverRadius: 0,
                        backgroundColor: [
                            '#ffcc00', // Kuning (Ibu Hamil)
                            '#4acccd', // Hijau Tosca (ODGJ)
                            '#ef8157', // Merah (Hipertensi)
                            '#51cbce' // Biru (Lansia)
                        ],
                        borderWidth: 0,
                        data: [dataIbu, dataOdgj, dataHipertensi, dataLansia]
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    tooltips: {
                        enabled: true
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                display: false
                            },
                            gridLines: {
                                drawBorder: false,
                                zeroLineColor: "transparent",
                                color: 'rgba(255,255,255,0.05)'
                            }
                        }],
                        xAxes: [{
                            barPercentage: 1.6,
                            gridLines: {
                                drawBorder: false,
                                color: 'rgba(255,255,255,0.1)',
                                zeroLineColor: "transparent"
                            },
                            ticks: {
                                display: false,
                            }
                        }]
                    },
                }
            });
        });
    </script>
</body>

</html>