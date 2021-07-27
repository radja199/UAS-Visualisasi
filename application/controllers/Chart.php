<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chart extends CI_Controller
{
    public function index()
    {
        $dataUrl = base_url('assets/sales.json');
        $dataStringJson = file_get_contents($dataUrl);
        $dataJson = json_decode($dataStringJson);
        $data = $dataJson[2]->data;


        //memanggil fungsi region()
        $output['region'] = $this->region($data);
        $output['sales'] = $this->sales($data);
        $output['produk'] = $this->produk($data);
        $output['bulanan'] = $this->bulanan($data);
        $output['harga_barang_bulan'] = $this->harga_barang_bulan($data);
        $output['pengeluaran_region'] = $this->pengeluaran_region($data);

        //mengirim variabel $output ke view      
        $this->load->view('chart', $output);
        //echo json_encode($output['bulanan']);


        // echo json_encode($data);
        //$this->load->view('visin');
    }
    function region($data)
    {
        $result = array();
        foreach ($data as $row) {
            if (isset($result[$row->Region]) == false) {
                $result[$row->Region] = $row->Units;
            } else {
                $units = $result[$row->Region];
                $result[$row->Region] = $units + $row->Units;
            }
        };
        $keys = array_keys($result);
        $tabs = [['Region', 'Units']];
        foreach ($keys as $row) {
            $dt = [$row, $result[$row]];
            array_push($tabs, $dt);
        }
        return json_encode($tabs);
        // return $tabs; // pemanggilan data
        // return $result;
    }
    function sales($data)
    {
        $result = array();
        foreach ($data as $row) {
            if (isset($result[$row->Rep]) == false) {
                $result[$row->Rep] = $row->Units;
            } else {
                $units = $result[$row->Rep];
                $result[$row->Rep] = $units + $row->Units;
            }
        };
        //sorting data berdasarkan value array secara menurun
        arsort($result);
        //konversi dalam format tabulasi
        $keys = array_keys($result);
        $tabs = [['Sales', 'Units']];
        foreach ($keys as $row) {
            $dt = [$row, $result[$row]];
            array_push($tabs, $dt);
        }
        return json_encode($tabs);
    }
    function produk($data)
    {
        $result = array();
        foreach ($data as $row) {
            if (isset($result[$row->Item]) == false) {
                $result[$row->Item] = $row->Units;
            } else {
                $units = $result[$row->Item];
                $result[$row->Item] = $units + $row->Units;
            }
        };
        //sorting data berdasarkan value array secara menurun
        arsort($result);
        //konversi dalam format tabulasi
        $keys = array_keys($result);
        $tabs = [['Produk', 'Units']];
        foreach ($keys as $row) {
            $dt = [$row, $result[$row]];
            array_push($tabs, $dt);
        }
        return json_encode($tabs);
    }
    function bulanan($data)
    {
        $result = array();
        foreach ($data as $row) {
            //mengambil data tanggal
            $time = strtotime($row->OrderDate);
            $bulan = date('n', $time);
            $tahun = date('Y', $time);
            if (isset($result[$tahun]) == false) {
                $result[$tahun][$bulan] = $row->Units;
            } else {
                if (isset($result[$tahun][$bulan]) == false) {
                    $result[$tahun][$bulan] = (int)$row->Units;
                } else {
                    $result[$tahun][$bulan] = $result[$tahun][$bulan] + (int) $row->Units;
                }
            }
        };
        //mengkonversi index data $result kedalam array  
        $keys = array_keys($result);
        //membuat data inisial
        $tabs = [['Bulan']];
        //menambahkan header data sesuai dengan tahun yang ditemukan
        foreach ($keys as $row) {
            array_push($tabs[0], (string)$row);
        }
        //membuat data bulan dalam satu tahun
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des'];
        //memasukkan data penjualan bulanan kedalam tabulasi
        for ($i = 1; $i <= 12; $i++) {
            $dt = [$bulan[$i - 1]];
            foreach ($keys as $row) {
                array_push($dt, (int)$result[$row][$i]);
            }
            array_push($tabs, $dt);
        }
        return json_encode($tabs);
    }

    function harga_barang_bulan($data)
    {
        $result = array();
        foreach ($data as $row) {

            // mengambil data tanggal
            $time = strtotime($row->OrderDate);
            $bulan = date('n', $time);
            $tahun = date('Y', $time);
            if (isset($result[$tahun]) == false) {
                $result[$tahun][$bulan] = (float)$row->UnitCost;
            } else {
                if (isset($result[$tahun][$bulan]) == false) {
                    $result[$tahun][$bulan] = (float)$row->UnitCost;
                } else {
                    $result[$tahun][$bulan] = $result[$tahun][$bulan] + (float) $row->UnitCost;
                }
            }
        };


        // Mengkonversi index data $result kedalam array
        $keys = array_keys($result);
        // membuat data inisial
        $tabs = [['Bulan']];
        //menambhakan header data sesaui dengan tahun yang ditemukan
        foreach ($keys as $row) {

            array_push($tabs[0], (string)$row);
        }
        // membuat data bulan dalam satu tahun
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des'];

        // masukkan data penjualan bulanan kedalam tabulasi
        for ($i = 1; $i < 12; $i++) {
            $dt = [$bulan[$i - 1]];
            foreach ($keys as $row) {
                array_push($dt, (float)$result[$row][$i]);
            }
            array_push($tabs, $dt);
        }
        return json_encode($tabs);
    }
    function pengeluaran_region($data)
    {
        $result = array();
        foreach ($data as $row) {
            if (isset($result[$row->Rep]) == false) {
                $result[$row->Rep] = (float)$row->UnitCost;
            } else {
                (float)$unitcost = $result[$row->Rep];
                $result[$row->Rep] = (float)$unitcost + $row->UnitCost;
            }
        };
        $keys = array_keys($result);
        $tabs = [['Sales', 'Unit Cost']];
        foreach ($keys as $row) {
            $dt = [$row, $result[$row]];
            array_push($tabs, $dt);
        }
        return json_encode($tabs);
        // return $tabs; // pemanggilan data
        // return $result;
    }
}
