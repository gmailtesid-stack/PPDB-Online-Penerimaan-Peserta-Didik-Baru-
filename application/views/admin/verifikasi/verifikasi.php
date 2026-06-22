<div class="content-wrapper">
  <div class="content">
    <?php
    echo $this->session->flashdata('msg');
    ?>
    <div class="row">
      <div class="panel panel-flat">
        <div class="panel-heading">
          <h5 class="panel-title"><b>VERIFIKASI DATA</b></h5>
          <hr style="margin:0px;">
          <div class="heading-elements">
            <ul class="icons-list">
              <li><a data-action="collapse"></a></li>
            </ul>
          </div>

          <br>
          <a href="panel_admin/edit_materi" class="btn btn-danger"><b>MATERI & JADWAL UJIAN</b></a>
          <div class="col-md-3" style="float: right; margin-right: 25px;">
            <div class="input-group">
              <div class="input-group-addon"><i class="icon-calendar22"></i></div>
              <select class="form-control" name="thn" onchange="thn()">
                <?php for ($i = date('Y'); $i >= 2021; $i--) { ?>
                  <option value="<?php echo $i; ?>" <?php if ($v_thn == $i) { echo "selected"; } ?>>Tahun <?php echo $i; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </div>
        <div class="table-responsive">
          <table class="table datatable-basic table-sm table-striped" width="100%">
            <thead>
              <tr>
                <th width="30px;">No.</th>
                <th>No. Pendaftaran</th>
                <th>NISN</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Status Verifikasi</th>
                <th class="text-center" width="180">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($v_siswa->result() as $baris) { ?>
                <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo $baris->no_pendaftaran; ?></td>
                  <td><?php echo $baris->nisn; ?></td>
                  <td><?php echo $baris->nik; ?></td>
                  <td><?php echo $baris->nama_lengkap; ?></td>
                  <td align="center">
                    <?php if ($baris->status_verifikasi == 1) { ?>
                      <label class="label label-success">Terverifikasi</label>
                    <?php } else { ?>
                      <label class="label label-warning">Belum diVerifikasi</label>
                    <?php } ?>
                  </td>
                  <td align="center">
                    <a href="#" data-toggle="modal" data-target="#berkas<?php echo $baris->no_pendaftaran; ?>" class="btn btn-primary btn-xs" title="Lihat Berkas"><i class="icon-folder"></i> Berkas</a>

                    <?php if ($baris->status_verifikasi == 0) { ?>
                      <a href="panel_admin/verifikasi/cek/<?php echo $baris->no_pendaftaran; ?>" class="btn btn-info btn-xs" title="Verifikasi" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-checkmark4"></i></a>
                    <?php } else { ?>
                      <a href="panel_admin/verifikasi/cek/<?php echo $baris->no_pendaftaran; ?>" class="btn btn-danger btn-xs" title="Batal Verifikasi" onclick="return confirm('Apakah Anda yakin?')"><i class="icon-cross3"></i></a>
                    <?php } ?>
                  </td>
                </tr>

                <div class="modal fade" id="berkas<?php echo $baris->no_pendaftaran; ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color: #4CAF50; color: white;">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h5 class="modal-title" style="color: white;">Berkas: <?php echo $baris->nama_lengkap; ?></h5>
                      </div>
                      <div class="modal-body text-center">
                        
                        <h4>Pas Foto</h4>
                        <?php if($baris->pas_foto){ ?> <img src="<?php echo base_url(); ?>assets/berkas/<?php echo $baris->pas_foto; ?>" width="300"><br><br> <?php } else { echo "<p class='text-danger'>Tidak ada file</p>"; } ?>
                        
                        <h4>Foto KK</h4>
                        <?php if($baris->foto_kk){ ?> <img src="<?php echo base_url(); ?>assets/berkas/<?php echo $baris->foto_kk; ?>" width="100%"><br><br> <?php } else { echo "<p class='text-danger'>Tidak ada file</p>"; } ?>
                        
                        <h4>Foto KTP Wali</h4>
                        <?php if($baris->foto_ktp){ ?> <img src="<?php echo base_url(); ?>assets/berkas/<?php echo $baris->foto_ktp; ?>" width="100%"><br><br> <?php } else { echo "<p class='text-danger'>Tidak ada file</p>"; } ?>
                        
                        <h4>Foto SKL</h4>
                        <?php if($baris->foto_skl){ ?> <img src="<?php echo base_url(); ?>assets/berkas/<?php echo $baris->foto_skl; ?>" width="100%"><br><br> <?php } else { echo "<p class='text-danger'>Tidak ada file</p>"; } ?>
                        
                        <h4>Foto Ijazah</h4>
                        <?php if($baris->foto_ijazah){ ?> <img src="<?php echo base_url(); ?>assets/berkas/<?php echo $baris->foto_ijazah; ?>" width="100%"><br><br> <?php } else { echo "<p class='text-danger'>Tidak ada file</p>"; } ?>
                        
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
              } ?>
            </tbody>
          </table>
        </div>
      </div>
      </div>
    <script type="text/javascript">
      function thn() {
        var thn = $('[name="thn"]').val();
        window.location = "panel_admin/verifikasi/thn/" + thn;
      }

      $('[name="thn"]').select2({
        placeholder: "- Tahun -"
      });
    </script>