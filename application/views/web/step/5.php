<div class="panel">
  <div class="panel-heading" style="background: #275555ff; color: honeydew;">
    <h2 align="center" style="margin-top: 10px;">FORM ISIAN<br><b>DATA SEKOLAH ASAL</b> </h2>
    <!-- <hr> -->
  </div>
  <div class="panel-body">

    <div class="form-group" style="padding-bottom:30px;">
      <label class="col-sm-3 control-label" style="text-align:right; margin-top:6px">Nama Sekolah <span class="text-danger">*</span></label>
      <div class="col-sm-9 prepend-icon">
        <input type="text" name="nama_sekolah" class="form-control bg-blue" placeholder="Nama Sekolah" maxlength="100" data-parsley-group="block4" data-radio="iradio_square-blue" data-parsley-errors-container='div[id="error-nama_sekolah"]' required>
        <i class="fa fa-university" style="margin-left:15px;"></i>
        <div id="error-nama_sekolah" style=" background:#FFBABA;color: #D8000C; width:auto;border-radius:5px;padding-left:10px;"></div>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" style="text-align:right; margin-top:6px">Jenjang sekolah <span class="text-danger">*</span></label>
      <div class="col-sm-9" style="margin-top:3px;">
        <select class="form-control bg-blue class" data-placeholder="Pilih jenjang sekolah sebelumnya" name="jenjang_sekolah" data-parsley-group="block4" data-parsley-errors-container='div[id="error-jenjang_sekolah"]'>
          <option value="">Pilih Jenjang Sekolah</option>
          <option value="1">SMP</option>
          <option value="2">MTs</option>
          <option value="3">Paket B</option>
        </select>
        <div id="error-jenjang_sekolah" style=" background:#FFBABA;color: #D8000C; width:auto;border-radius:5px;padding-left:10px;"></div>
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label" style="text-align:right; margin-top:6px">Status sekolah <span class="text-danger">*</span></label>
      <div class="col-sm-9" style="margin-top:3px;">
        <select class="form-control bg-blue class" data-placeholder="Pilih status sekolah sebelumnya" name="status_sekolah" data-parsley-group="block4" data-parsley-errors-container='div[id="error-status_sekolah"]'>
          <option value="">Pilih Status Sekolah</option>
          <option value="NEGERI">NEGERI</option>
          <option value="SWASTA">SWASTA</option>
        </select>
        <div id="error-status_sekolah" style=" background:#FFBABA;color: #D8000C; width:auto;border-radius:5px;padding-left:10px;"></div>
      </div>
    </div>

    <div class="form-group" style="padding-bottom:30px;">
      <label class="col-sm-3 control-label" style="text-align:right; margin-top:6px">NPSN Sekolah <span class="text-danger">*</span></label>
      <div class="col-sm-9 prepend-icon" style="margin-top:1px;">
        <input type="text" name="npsn_sekolah" class="form-control bg-blue class" onkeypress="return hanyaAngka(this);" maxlength="10" placeholder="NPSN Sekolah sebelumnya" data-parsley-group="block4" data-parsley-errors-container='div[id="error-npsn_sekolah"]'>
        <i class="" style="margin-left:15px;"></i>
        <div id="error-npsn_sekolah" style=" background:#FFBABA;color: #D8000C; width:auto;border-radius:5px;padding-left:10px;"></div>
      </div>
    </div>

  </div>
</div>

<div class="col-md-12">
  <div>