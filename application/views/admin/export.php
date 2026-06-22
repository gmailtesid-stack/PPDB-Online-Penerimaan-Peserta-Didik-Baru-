<?php 
// PAKSA BROWSER UNTUK DOWNLOAD FILE EXCEL
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Pendaftar_PPDB_".$v_thn.".xls");
header("Pragma: no-cache");
header("Expires: 0");
error_reporting(0); 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Data Siswa</title>
    <style>
        table { border-collapse: collapse; width: 100%; font-family: Calibri, sans-serif; }
        /* Warna background abu-abu (#CCCCCC), teks hitam, dan RATA KIRI */
        th { background-color: #CCCCCC; color: #000000; padding: 8px; border: 1px solid #000000; font-weight: bold; text-align: left; }
        /* RATA KIRI untuk semua isi data */
        td { padding: 5px; border: 1px solid #000000; text-align: left; }
    </style>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>NO</th>
                <th>NO. PENDAFTARAN</th>
                <th>TANGGAL PENDAFTARAN</th>
                <th>NISN</th>
                <th>NIK</th>
                <th>NAMA LENGKAP</th>
                <th>JENIS KELAMIN</th>
                <th>TEMPAT, TANGGAL LAHIR</th>
                <th>AGAMA</th>
                <th>NAMA AYAH</th>
                <th>NAMA IBU</th>
                <th>NO. HANDPHONE (HP)</th>
                <th>ASAL SEKOLAH</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($v_siswa->result() as $baris): 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $baris->no_pendaftaran; ?></td>
                
                <td><?php echo date('d-m-Y', strtotime(str_replace('/', '-', $baris->tgl_siswa))); ?></td>
                
                <td>'<?php echo $baris->nisn; ?></td>
                <td>'<?php echo $baris->nik; ?></td>
                <td><?php echo ucwords($baris->nama_lengkap); ?></td>
                <td><?php echo $baris->jk; ?></td>
                <td><?php echo $baris->tempat_lahir . ", " . $baris->tgl_lahir; ?></td>
                <td><?php echo $baris->agama; ?></td>
                <td><?php echo $baris->nama_ayah; ?></td>
                <td><?php echo $baris->nama_ibu; ?></td>
                <td>'<?php echo $baris->no_hp_siswa; ?></td>
                <td><?php echo $baris->nama_sekolah; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>