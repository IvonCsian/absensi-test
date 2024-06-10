<?php 
if ($mod ==''){
    header('location:../404');
    echo'kosong';
}else{
    include_once 'sw-mod/sw-header.php';
if(!isset($_COOKIE['COOKIES_MEMBER']) && !isset($_COOKIE['COOKIES_COOKIES'])){
        setcookie('COOKIES_MEMBER', '', 0, '/');
        setcookie('COOKIES_COOKIES', '', 0, '/');
        // Login tidak ditemukan
        setcookie("COOKIES_MEMBER", "", time()-$expired_cookie);
        setcookie("COOKIES_COOKIES", "", time()-$expired_cookie);
        session_destroy();
        header("location:./");
}else{
  echo'<!-- App Capsule -->
    <div id="appCapsule">
    <div class="section mt-2">
    <div class="card">
    <div class="card-body">
        <div class="row text-center">
        <div class="col-sm-4 col-md-4">
            <div class="form-group basic">
                <div class="input-wrapper">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker start_date" name="start_date" placeholder="Tanggal Awal" required>
                        <div class="input-group-addon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4  col-md-4">
            <div class="form-group basic">
                <div class="input-wrapper">
                    <div class="input-group">
                        <input type="text" name="end_date" class="form-control datepicker end_date" value="'.tanggal_ind($date).'">
                        <div class="input-group-addon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </div>
                    </div>

                </div>
            </div> 
        </div>
        <div class="col-sm-4 col-md-4 justify-content-between">
           <button type="button" class="btn btn-danger mt-1 btn-sortir-job"><ion-icon name="checkmark-outline"></ion-icon>Tampilkan</button>
           <button type="button" class="btn btn-success mt-1 btn-clear-job"><ion-icon name="repeat-outline"></ion-icon> Clear</button>
           <button type="button" class="btn btn-warning mt-1" data-toggle="modal" data-target="#modal-add"><ion-icon name="add-circle-outline"></ion-icon> Tambah Pekerjaan</button>
           
        </div>

        </div>       
    </div>
    </div>
    </div>

        <div class="section mt-2">
            <div class="section-title">Data Pekerjaan Harian</div>
            <div class="card">
                <div class="transactions">
                    <div class="loaddatajob"></div>
                </div>
            </div>
        </div>
    

        <!-- MODAL ADD -->
        <div class="modal fade modalbox" id="modal-add" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pekerjaan Harian</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form id="form-add-job" autocomplete="off">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="'.$row_user['employees_name'].'" style="background:#eee" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Pekerjaan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="tgl_job" name="tgl_job" placeholder="'.tanggal_ind($date).'" value="'.tanggal_ind($date).'" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jam Mulai</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" id="jam_start" name="jam_start" placeholder="Jam Mulai" value="" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jam Selesai</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" id="jam_end" name="jam_end" placeholder="Jam Selesai" value="">
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Deskripsi Pekerjaan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="job" name="job" placeholder="Deskripsikan dengan singkat dan jelas" value="" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>
                           
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Persentase Penyelesaian</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="persentase" name="persentase" min="1" max="100" placeholder="isikan 1 s/d 100" value="" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Sifat Pekerjaan</label>
                                        <div class="input-group">
                                            <select class="form-control" id="sifat" name="sifat" required>
                                                <option value="RUTIN">RUTIN</option>
                                                <option value="PERIODIK">PERIODIK</option>
                                                <option value="INSIDENTIL">INSIDENTIL</option>
                                            </select>

                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <button type="submit" class="btn btn-danger btn-block btn-lg mt-2">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>


        <!-- UPDATE DATA job  -->
        <div class="modal fade modalbox" id="modal-update" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pekerjaan</h5>
                        <a href="javascript:;" data-dismiss="modal">Close</a>
                    </div>
                    <div class="modal-body">
                        <form id="form-update-job" autocomplete="off">
                            <input type="text" id="job-id" name="job_id" value="" readonly required hidden="hidden">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="'.$row_user['employees_name'].'" style="background:#eee" readonly required>
                                    <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tanggal Pekerjaan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" id="job-tgl_job" name="tgl_job" placeholder="'.tanggal_ind($date).'" value="" required>
                                            <div class="input-group-addon">
                                                <ion-icon name="calendar-outline"></ion-icon>
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jam Mulai</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" id="job-jam_start" name="jam_start" placeholder="Jam Mulai" value="" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Jam Selesai</label>
                                        <div class="input-group">
                                            <input type="time" class="form-control" id="job-jam_end" name="jam_end" placeholder="Jam Selesai" value="">
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                           <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Deskripsi Pekerjaan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="job-desc" name="job" placeholder="Deskripsikan dengan singkat dan jelas" value="" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>
                           
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Persentase Penyelesaian</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="job-persentase" name="persentase" min="1" max="100" placeholder="isikan 1 s/d 100" value="" required>
                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Sifat Pekerjaan</label>
                                        <div class="input-group">
                                            <select class="form-control" id="job-sifat" name="sifat" required>
                                                <option value="RUTIN">RUTIN</option>
                                                <option value="PERIODIK">PERIODIK</option>
                                                <option value="INSIDENTIL">INSIDENTIL</option>
                                            </select>

                                            <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                                        </div>
                                    </div>
                            </div>

                            <div class="form-group basic">
                                <button type="submit" class="btn btn-danger btn-block btn-lg mt-2">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    <!-- * END UPDATE -->

</div>';

  }
  include_once 'sw-mod/sw-footer.php';
} ?>