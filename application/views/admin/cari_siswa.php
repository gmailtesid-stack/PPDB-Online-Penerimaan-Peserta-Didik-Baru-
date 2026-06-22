<div class="content-wrapper">
  <div class="content">
    <?php echo $this->session->flashdata('msg'); ?>

    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title"><b><i class="icon-search4"></i> CARI SISWA</b></h5>
          <hr style="margin:0px;">
        </div>

        <div class="panel-body">
          <!-- Form Pencarian -->
          <form method="GET" action="<?php echo base_url('panel_admin/cari'); ?>" class="form-inline">
            <div class="form-group" style="margin-right:10px;">
              <input type="text"
                     name="q"
                     class="form-control"
                     placeholder="Nama, No. Pendaftaran, NISN, atau NIK"
                     value="<?php echo htmlspecialchars($keyword ?? ''); ?>"
                     style="width:320px;"
                     autofocus>
            </div>
            <div class="form-group" style="margin-right:10px;">
              <select name="thn" class="form-control">
                <?php for ($i = date('Y'); $i >= 2021; $i--): ?>
                  <option value="<?php echo $i; ?>" <?php if ($v_thn == $i) echo 'selected'; ?>>
                    Tahun <?php echo $i; ?>
                  </option>
                <?php endfor; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">
              <i class="icon-search4"></i> Cari
            </button>
            <?php if ($keyword): ?>
              <a href="<?php echo base_url('panel_admin/cari'); ?>" class="btn btn-default" style="margin-left:5px;">
                <i class="icon-cross2"></i> Reset
              </a>
            <?php endif; ?>
          </form>
        </div>

        <?php if ($keyword && $v_siswa): ?>
        <div class="table-responsive">
          <table class="table table-sm table-striped table-hover" width="100%">
            <thead>
              <tr>
                <th width="40">No.</th>
                <th>No. Pendaftaran</th>
                <th>NISN</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Tgl Daftar</th>
                <th>Status Verifikasi</th>
                <th>Status Kelulusan</th>
                <th class="text-center" width="160">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              $results = $v_siswa->result();
              if (count($results) === 0):
              ?>
                <tr>
                  <td colspan="9" class="text-center text-muted" style="padding:30px;">
                    <i class="icon-info3"></i> Tidak ada data yang cocok dengan "<strong><?php echo htmlspecialchars($keyword); ?></strong>"
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($results as $baris): ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><code><?php echo htmlspecialchars($baris->no_pendaftaran); ?></code></td>
                  <td><?php echo htmlspecialchars($baris->nisn); ?></td>
                  <td><?php echo htmlspecialchars($baris->nik); ?></td>
                  <td><b><?php echo htmlspecialchars($baris->nama_lengkap); ?></b></td>
                  <td><?php echo date('d/m/Y', strtotime($baris->tgl_siswa)); ?></td>
                  <td class="text-center">
                    <?php if ($baris->status_verifikasi == 1): ?>
                      <label class="label label-success">Terverifikasi</label>
                    <?php else: ?>
                      <label class="label label-warning">Belum Diverifikasi</label>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <?php if ($baris->status_pendaftaran == 'lulus'): ?>
                      <label class="label label-success">Lulus</label>
                    <?php elseif ($baris->status_pendaftaran == 'tidak lulus'): ?>
                      <label class="label label-danger">Tidak Lulus</label>
                    <?php else: ?>
                      <label class="label label-default">Proses</label>
                    <?php endif; ?>
                  </td>
                  <td class="text-center">
                    <a href="<?php echo base_url('panel_admin/verifikasi_cetak/' . $baris->no_pendaftaran); ?>"
                       class="btn btn-xs btn-info" target="_blank" title="Cetak">
                      <i class="icon-printer2"></i>
                    </a>
                    <a href="<?php echo base_url('panel_admin/verifikasi'); ?>"
                       class="btn btn-xs btn-success" title="Lihat Verifikasi">
                      <i class="icon-eye"></i>
                    </a>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <?php if (count($results) > 0): ?>
        <div class="panel-footer text-muted" style="padding:8px 15px;">
          Ditemukan <strong><?php echo count($results); ?></strong> data
          untuk kata kunci "<strong><?php echo htmlspecialchars($keyword); ?></strong>"
          tahun <?php echo $v_thn; ?>.
        </div>
        <?php endif; ?>

        <?php elseif ($keyword): ?>
        <div class="panel-body text-center text-muted" style="padding:40px;">
          <i class="icon-info3" style="font-size:40px;"></i>
          <p style="margin-top:10px;">Tidak ada data ditemukan untuk "<strong><?php echo htmlspecialchars($keyword); ?></strong>"</p>
        </div>
        <?php else: ?>
        <div class="panel-body text-center text-muted" style="padding:40px;">
          <i class="icon-search4" style="font-size:40px;"></i>
          <p style="margin-top:10px;">Masukkan nama, nomor pendaftaran, NISN, atau NIK untuk mencari data siswa.</p>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<script>
// Auto-fokus input saat halaman dibuka
document.addEventListener('DOMContentLoaded', function () {
  var inp = document.querySelector('input[name="q"]');
  if (inp) inp.focus();
});
</script>
