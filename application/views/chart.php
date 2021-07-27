<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Visin Google Charts</title>
    <link rel="stylesheet" href="<?php echo base_url('vendor/uikit/css/'); ?>uikit.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        // Mengambil API visualisasi.
        google.charts.load('current', {
            'packages': ['corechart']
        });
        //mengambil data dari variabel PHP
        var region = [];
        region['dataStr'] = '<?php echo $region; ?>';
        region['dataArray'] = JSON.parse(region['dataStr']);

        var sales = [];
        sales['dataStr'] = '<?php echo $sales; ?>';
        sales['dataArray'] = JSON.parse(sales['dataStr']);

        var produk = [];
        produk['dataStr'] = '<?php echo $produk; ?>';
        produk['dataArray'] = JSON.parse(produk['dataStr']);

        var bulanan = [];
        bulanan['dataStr'] = '<?php echo $bulanan; ?>';
        bulanan['dataArray'] = JSON.parse(bulanan['dataStr']);



        var harga_barang_bulan = [];
        harga_barang_bulan['dataStr'] = '<?php echo $harga_barang_bulan; ?>';
        harga_barang_bulan['dataArray'] = JSON.parse(harga_barang_bulan['dataStr']);

        var pengeluaran_region = [];
        pengeluaran_region['dataStr'] = '<?php echo $pengeluaran_region; ?>';
        pengeluaran_region['dataArray'] = JSON.parse(pengeluaran_region['dataStr']);

        //menggambar grafik
        google.charts.setOnLoadCallback(function() {
            drawChart(region['dataArray'], 'pie', 'region');
            drawChart(sales['dataArray'], 'bar', 'sales');
            drawChart(produk['dataArray'], 'bar', 'produk');
            drawChart(bulanan['dataArray'], 'line', 'bulanan');
            drawChart(harga_barang_bulan['dataArray'], 'line', 'harga_barang_bulan');
            drawChart(pengeluaran_region['dataArray'], 'line', 'pengeluaran_region');
        });
        // Menentukan data yang akan ditampilkan
        function drawChart(dataArray, type, container) {
            // Membuat data tabel yang sesuai dengan format google chart dari sumber data array javascript
            var data = new google.visualization.arrayToDataTable(dataArray, false);
            // Tentukan pengaturan chart
            var options = {
                legend: 'bottom',
                titlePosition: 'none',
                titleTextStyle: {
                    fontSize: 18
                },
                chartArea: {
                    width: '80%',
                    height: '70%'
                }
            };
            if (type == 'pie') {
                var chart = new google.visualization.PieChart(document.getElementById(container));
            }
            if (type == 'column') {
                var chart = new google.visualization.ColumnChart(document.getElementById(container));
            }
            if (type == 'bar') {
                var chart = new google.visualization.BarChart(document.getElementById(container));
            }
            if (type == 'line') {

                var chart = new google.visualization.LineChart(document.getElementById(container));
            }
            chart.draw(data, options);
        }
    </script>
</head>

<body>
    <!-- <div class="uk-flex uk-flex-column uk-flex-middle uk-flex-center uk-height-viewport" style="background-color:#ccc; height:300px;">
        <div id="diagram-pie"></div>
    </div> -->
    <script src="<?php echo base_url('vendor/uikit/js/'); ?>uikit.js"></script>
    <nav class="uk-navbar-container uk-margin" uk-navbar>
        <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="#">Analisis Penjualan & Total Biaya pengeluaran</a>
        </div>
    </nav>
    <div class="uk-container">
        <div class="uk-child-width-1-2@s" uk-grid uk-height-match="target: > div > .uk-card">

            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body" uk-scrollspy="cls: uk-animation-slide-top; repeat: true">
                    <h3 class="uk-card-title">Hasil Penjualan Oleh Sales</h3>
                    <div id="sales" style="height:350px;"></div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body" uk-scrollspy="cls: uk-animation-slide-right; repeat: true>
                    <h3 class=" uk-card-title">Penjualan Berdasarkan Region</h3>
                    <div id="region" style="height:350px;"></div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body" uk-scrollspy="cls: uk-animation-slide-bottom; repeat: true">
                    <h3 class="uk-card-title">Produk Terlaris</h3>
                    <div id="produk" style="height:350px;"></div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body" uk-scrollspy="cls: uk-animation-slide-left; repeat: true>
                    <h3 class=" uk-card-title">Penjualan Bulanan</h3>
                    <div id="bulanan" style="height:350px;"></div>
                </div>
            </div>



        </div>
        <div class="uk-child-width-1@s" uk-grid uk-height-match="target: > div > .uk-card">
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    <h3 class="uk-card-title">Harga satu barang setiap tahun berdasarkan bulan tertentu</h3>
                    <div id="harga_barang_bulan" style="height:350px;"></div>
                </div>
            </div>

        </div>
        <div class="uk-child-width-1@s" uk-grid uk-height-match="target: > div > .uk-card">
            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                    <h3 class="uk-card-title">Total pengeluran biaya pembuatan barang berdasarkan sales</h3>
                    <div id="pengeluaran_region" style="height:350px;"></div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>