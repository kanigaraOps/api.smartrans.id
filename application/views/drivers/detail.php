<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-4 side-left d-flex align-items-stretch">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                            <div class="row">
                                <h4 class="col-auto mr-auto card-title">Drivers Info</h4>
                                <a class="col-auto btn btn-danger text-white" href="<?= base_url(); ?>driver">
                                    <i class="mdi mdi-keyboard-backspace text-white"></i>Back</a>
                            </div>

                            <img src="<?= base_url('images/fotodriver/') . $driver['foto'] ?>">
                            <p class="name"><?= $driver['nama_driver'] ?>
                                <?php if ($driver['gender'] == 2) { ?>
                                    <i class="mdi mdi-gender-male text-info"></i>
                                <?php } else { ?>
                                    <i class="mdi mdi-gender-female text-info"></i>
                                <?php } ?>
                            </p>
                            <h4 class="text-center text-success">
                                <i class="mdi mdi-wallet mr-1 text-success "></i>Wallet Deposit</h4>
                            <p class="text-center"><?= $currency['app_currency'] ?>
                                <?= number_format($driver['saldo'] / 100, 2, ".", ".") ?></p>
                            <h4 class="text-center text-warning">
                                <i class="mdi mdi-wallet mr-1 text-warning "></i>Wallet Transaction</h4>
                            <p class="text-center"><?= $currency['app_currency'] ?>
                                <?= number_format($driver['saldotrx'] / 100, 2, ".", ".") ?></p>    

                            <a class="d-block text-center text-dark" href="#">id card : 
                                <?= $driver['no_ktp'] ?></a>
                            <a class="d-block text-center text-dark" href="#"><?= $driver['email'] ?></a>
                            <a class="d-block text-center text-dark" href="#"><?= $driver['no_telepon'] ?></a>

                            <?php if ($driver['status'] == 0) { ?>
                                <a class="d-block text-center" href=" <?= base_url(); ?>newregistration/confirm/<?= $driver['id'] ?>"> <button class="btn btn-outline-primary mr-2">Confirm</button>
                                </a>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-12 stretch-card">
                    <div class="card">
                        <div class="card-body overview">
                            <ul class="achivements">
                                <li>
                                    <p class="text-success">Id</p>
                                    <p><?= $driver['id'] ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Order</p>
                                    <p><?= $countorder ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Rating</p>
                                    <p><?= number_format($driver['rating'], 1) ?></p>
                                </li>
                                <li>
                                    <p class="text-success">Status</p>
                                    <p>
                                        <?php if ($driver['status'] == 3) {
                                            echo 'Banned';
                                        } elseif ($driver['status'] == 0) {
                                            echo 'New Registration';
                                        } else {
                                            if ($driver['status_job'] == 1) {
                                                echo 'Active';
                                            }
                                            if ($driver['status_job'] == 2) {
                                                echo 'Pick Up';
                                            }
                                            if ($driver['status_job'] == 3) {
                                                echo 'Work';
                                            }
                                            if ($driver['status_job'] == 4) {
                                                echo 'Non Active';
                                            }
                                            if ($driver['status_job'] == 5) {
                                                echo 'Log out';
                                            }
                                        } ?>
                                    </p>
                                </li>
                            </ul>
                            <div class="wrapper about-user">
                                <h4 class="card-title mt-4 mb-3">Address</h4>
                                <p><?= $driver['alamat_driver'] ?></p>
                            </div>
                            <div class="info-links">
                                <i class="mdi mdi-update text-gray">Update On
                                </i>
                                <p><?= $driver['update_at'] ?></p>
                                <i class="mdi mdi-account-check text-gray">Created On:
                                </i>
                                <p><?= $driver['created_at'] ?></p>
                                <i class="mdi mdi-calendar text-gray">Date Of Birth:
                                </i>
                                <p><?= $driver['tgl_lahir'] ?></p>
                            </div>
                            <br>
                            <div class="row">
                                <span class="col-4 text-center">Job Type<p class=" text-danger text-center"><?= $driver['driver_job'] ?></p>
                                </span>
                                <span class="col-4 text-center">Vehicle<p class=" text-danger text-center"><?= $driver['merek'] ?>
                                        <?= $driver['tipe'] ?>
                                        <?= $driver['warna'] ?></p>
                                </span>
                                <span class="col-4 text-center">No.Vechile<p class=" text-danger text-center"><?= $driver['nomor_kendaraan'] ?></p>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 side-right stretch-card">
            <div class="card">

                <div class="card-body">
                    <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                            <?php echo $this->session->flashdata('hapus'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">Detail Drivers</h4>
                        <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-expanded="true">Info</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="service-tab" data-toggle="tab" href="#job" role="tab" aria-controls="service">Job & Vehicle</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="avatar-tab" data-toggle="tab" href="#avatar" role="tab" aria-controls="avatar">Profile Picture</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="files-tab" data-toggle="tab" href="#files" role="tab" aria-controls="files">Files</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="security-tab" data-toggle="tab" href="#security" role="tab" aria-controls="security">Password</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="transactionhistory-tab" data-toggle="tab" href="#transactionhistory" role="tab" aria-controls="transactionhistory">Transaction History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallet" role="tab" aria-controls="wallet">Wallet Deposit</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="wallet-tab" data-toggle="tab" href="#wallettrx" role="tab" aria-controls="wallet">Wallet Transaction</a>
                            </li>
                        </ul>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent">

                            <!-- driver info form -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <?= form_open_multipart('driver/ubahid'); ?>
                                <input type="hidden" name="id" value="<?= $driver['id'] ?>">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="nama_driver" value="<?= $driver['nama_driver'] ?>" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $driver['email'] ?>" required>
                                </div>

                                <label class="text-small">Phone Number</label>
                                <div class="row">
                                    <div class="form-group col-2">
                                        <input type="tel" id="txtPhone" class="form-control" name="countrycode" value="<?= $driver['countrycode'] ?>" required>
                                    </div>
                                    <div class=" form-group col-10">
                                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $driver['phone'] ?>" required>
                                    </div>
                                </div>

                                <div class=" form-group">
                                        <label for="birthdate">Date of Birth</label>
                                        <input type="date" class="form-control" name="tgl_lahir" value="<?= $driver['tgl_lahir'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select class="js-example-basic-single" style="width:100%" name="gender">
                                            <option value="Male" <?php if ($driver['gender'] == 'Male') { ?>selected<?php } ?>>Male</option>
                                            <option value="Female" <?php if ($driver['gender'] == 'Female') { ?>selected<?php } ?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <select class="js-example-basic-single" style="width:100%" name="alamat_driver">

                                    <?php foreach ($countryarea as $ca) { ?>
                                    <option id="<?= $ca['id'] ?>" value="<?= $ca['id'] ?>" <?php if ($ca['id'] == $driver['region_code']) { ?>selected<?php } ?>><?= $ca['area_name'] ?></option>
                                    <?php } ?>
                                </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="address">Services</label>
                                    <br>
                                     <label>
                                            <input type="checkbox" class="minimal" value="1" name="paskas" <? if($driver['paskas']=='1'){echo "checked";} ?>>
                                           Paskas
                                        </label>
                                    <label>
                                            <input type="checkbox" class="minimal" value="1" name="ap" <? if($driver['ap']=='1'){echo "checked";} ?>>
                                           AP
                                        </label>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="pool" <? if($driver['pool']=='1'){echo "checked";} ?>>
                                            Pool
                                        </label>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="berkah" <? if($driver['berkah']=='1'){echo "checked";} ?>>
                                            Berkah
                                        </label>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="rent" <? if($driver['berkah']=='1'){echo "checked";} ?>>
                                            Smart Rent
                                        </label>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="kurir" <? if($driver['berkah']=='1'){echo "checked";} ?>>
                                            Kurir
                                        </label>
                                    </div>
                                    
                                    <div class="form-group">
                                    <label for="address">Berkah</label>
                                    <br>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="kanigara" <? if($driver['kanigara']=='1'){echo "checked";} ?>>
                                            Kanigara Trans
                                        </label>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="smartrans" <? if($driver['smartrans']=='1'){echo "checked";} ?>>
                                            Smartrans
                                        </label>
                                        <label>
                                            <input type="checkbox" class="minimal" value="1" name="ayuindah" <? if($driver['ayuindah']=='1'){echo "checked";} ?>>
                                            Ayu Indah
                                        </label>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success mr-2">Update</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                    <?= form_close(); ?>
                            </div>
                                <!-- tab content ends -->

                                <!-- jjob vehicle form -->
                                <div class="tab-pane fade" id="job" role="tabpanel" aria-labelledby="service">
                                    <?= form_open_multipart('driver/ubahkendaraan'); ?>
                                    <input type="hidden" name="id" value="<?= $driver['id'] ?>">
                                    <input type="hidden" name="id_k" value="<?= $driver['id_k'] ?>">
                                    <div class="form-group">
                                        <label for="Job Service">Vehicle</label>
                                        <select class="js-example-basic-single" name="jenis" style="width:100%">\
                                            <?php foreach ($driverjob as $drj) { ?>
                                                <option value="<?= $drj['id'] ?>" <?php if ($driver['job'] == $drj['id']) { ?>selected<?php } ?>><?= $drj['driver_job'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="brand">Vehicle Brand</label>
                                        <input type="text" class="form-control" name="merek" id="brand" value="<?= $driver['merek'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="variantvehicle">Vehicle Variant</label>
                                        <input type="text" class="form-control" name="tipe" id="variantvehicle" value="<?= $driver['tipe'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vehiclecolor">Vehicle Color</label>
                                        <input type="text" class="form-control" name="warna" id="vehiclecolor" value="<?= $driver['warna'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="vehicleregistration">Vehicle Registration Number</label>
                                        <input type="text" class="form-control" name="nomor_kendaraan" id="vehicleregistration" value="<?= $driver['nomor_kendaraan'] ?>" required>
                                    </div>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                                <!-- tab content ends -->

                                <div class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab">
                                    <?= form_open_multipart('driver/ubahfoto'); ?>
                                    <input type="hidden" name="id" value="<?= $driver['id'] ?>">
                                    <label>Profile Picture</label>
                                    <input type="file" class="dropify" name="foto" data-max-file-size="3mb" data-default-file="<?= base_url('images/fotodriver/') . $driver['foto'] ?>" />

                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                    <?= form_close(); ?>
                                </div>

                                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab">

                                    <?= form_open_multipart('driver/ubahcard'); ?>

                                    <input type="hidden" name="id" value="<?= $driver['id'] ?>">

                                    <div class="form-group">
                                        <label for="idcard">Nomor KTP</label>
                                        <input type="text" class="form-control" name="no_ktp" value="<?= $driver['no_ktp'] ?>" required>
                                    </div>

                                    <div>
                                        <label>Foto KTP</label>
                                        <input type="file" class="dropify" name="foto_ktp" data-max-file-size="3mb" data-default-file="<?= base_url('images/fotoberkas/ktp/') . $driver['foto_ktp'] ?>" />
                                        <br>
                                    </div>
                                    <div class="form-group">
                                        <label for="idcard">Nomor SIM</label>
                                        <input type="text" class="form-control" name="id_sim" value="<?= $driver['id_sim'] ?>" required>
                                    </div>
                                    <div>
                                        <label>Foto SIM</label>
                                        <input type="file" class="dropify" name="foto_sim" data-max-file-size="3mb" data-default-file="<?= base_url('images/fotoberkas/sim/') . $driver['foto_sim'] ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="idcard">Masa Berlaku</label>
                                        <input type="text" class="form-control" name="masa_berlaku" value="<?= $driver['stnk_berlaku'] ?>" required>
                                    </div>
                                    <div>
                                        <label>Foto STNK</label>
                                        <input type="file" class="dropify" name="foto_stnk" data-max-file-size="3mb" data-default-file="<?= base_url('images/fotoberkas/stnk/') . $driver['foto_stnk'] ?>" />
                                    </div>

                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                    <?= form_close(); ?>
                                </div>

                                <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                                    <?= form_open_multipart('driver/ubahpassword'); ?>
                                    <div class="form-group">
                                        <input type="hidden" name="id" value="<?= $driver['id'] ?>">
                                        <label for="new-password">Change password</label>
                                        <input type="password" class="form-control" id="new-password" name="password" placeholder="Enter you new password" required>
                                    </div>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                        <button class="btn btn-outline-danger">Cancel</button>
                                    </div>
                                    <?= form_close(); ?>
                                </div>

                                <div class="tab-pane fade" id="transactionhistory" role="tabpanel" aria-labelledby="transactionhistory-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Transaction Inv</th>
                                                            <th>Service</th>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($transaksi as $tr) { ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td>#INV-<?= $tr['id'] ?></td>
                                                                <td><?= $tr['fitur'] ?></td>
                                                                <td><?= $tr['waktu_order'] ?></td>
                                                                <td class="text-success">
                                                                    <?= $currency['app_currency'] ?>
                                                                    <?= number_format($tr['biaya_akhir'] / 100, 2, ".", ".") ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($tr['status'] == '2') { ?>
                                                                        <label class="badge badge-primary"><?= $tr['status_transaksi']; ?></label>
                                                                    <?php } ?>
                                                                    <?php if ($tr['status'] == '3') { ?>
                                                                        <label class="badge badge-success"><?= $tr['status_transaksi']; ?></label>
                                                                    <?php } ?>
                                                                    <?php if ($tr['status'] == '5') { ?>
                                                                        <label class="badge badge-danger"><?= $tr['status_transaksi']; ?></label>
                                                                    <?php } ?>
                                                                    <?php if ($tr['status'] == '4') { ?>
                                                                        <label class="badge badge-info"><?= $tr['status_transaksi']; ?></label>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?= base_url(); ?>dashboard/detail/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-primary">View</a>
                                                                </td>
                                                            <?php $i++;
                                                        } ?>
                                                            </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing2" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Id DEP</th>
                                                            <th>Type</th>
                                                            <th>Detail</th>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Transfer</th>
                                                            <th>Status</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($wallet as $wl) { ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $wl['id']; ?></td>
                                                                <td><?= $wl['type']; ?></td>
                                                                <td><?= $wl['bank']; ?></td>
                                                                <td><?= $wl['waktu']; ?></td>

                                                                <?php if ($wl['type'] == 'topup' or $wl['type'] == 'Order+') { ?>
                                                                    <td class="text-success">
                                                                        <?= $currency['app_currency'] ?>
                                                                        <?= number_format($wl['jumlah'] / 100, 2, ".", ".") ?>
                                                                    </td>

                                                                <?php } else { ?>
                                                                    <td class="text-danger">
                                                                        <?= $currency['app_currency'] ?>
                                                                        <?= number_format($wl['jumlah'] / 100, 2, ".", ".") ?>
                                                                    </td>
                                                                <?php } ?>

                                                                <td class="text-danger">
                                                                        <?= $currency['app_currency'] ?>
                                                                        <?= number_format($wl['transfer'] * 100 / 100, 2, ".", ".") ?>
                                                                </td>

                                                                <?php if ($wl['status'] == '0') { ?>
                                                                        <td>
                                                                            <label class="badge badge-secondary text-dark">Pending</label>
                                                                        </td>
                                                                    <?php }
                                                                    if ($wl['status'] == '1') { ?>
                                                                        <td>
                                                                            <label class="badge badge-success">Success</label>
                                                                        </td>
                                                                    <?php }
                                                                    if ($wl['status'] == '2') { ?>
                                                                        <td>
                                                                            <label class="badge badge-danger">Canceled</label>
                                                                        </td>
                                                                    <?php } ?>


                                                            </tr>
                                                        <?php $i++;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="wallettrx" role="tabpanel" aria-labelledby="wallet-tab">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing2" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Id TRX</th>
                                                            <th>Type</th>
                                                            <th>Detail</th>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($wallettrx as $wl) { ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $wl['id']; ?></td>
                                                                <td><?= $wl['type']; ?></td>
                                                                <td><?= $wl['bank']; ?></td>
                                                                <td><?= $wl['waktu']; ?></td>

                                                                <?php if ($wl['type'] == 'topup' or $wl['type'] == 'Order+') { ?>
                                                                    <td class="text-success">
                                                                        <?= $currency['app_currency'] ?>
                                                                        <?= number_format($wl['jumlah'] / 100, 2, ".", ".") ?>
                                                                    </td>

                                                                <?php } else { ?>
                                                                    <td class="text-danger">
                                                                        <?= $currency['app_currency'] ?>
                                                                        <?= number_format($wl['jumlah'] / 100, 2, ".", ".") ?>
                                                                    </td>
                                                                <?php } ?>

                                                                <?php if ($wl['status'] == '0') { ?>
                                                                        <td>
                                                                            <label class="badge badge-secondary text-dark">Pending</label>
                                                                        </td>
                                                                    <?php }
                                                                    if ($wl['status'] == '1') { ?>
                                                                        <td>
                                                                            <label class="badge badge-success">Success</label>
                                                                        </td>
                                                                    <?php }
                                                                    if ($wl['status'] == '2') { ?>
                                                                        <td>
                                                                            <label class="badge badge-danger">Canceled</label>
                                                                        </td>
                                                                    <?php } ?>



                                                            </tr>
                                                        <?php $i++;
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->

    <script type="text/javascript">
        $(function() {
            var code = "<?= $driver['countrycode'] ?>"; // Assigning value from model.
            $('#txtPhone').val(code);
            $('#txtPhone').intlTelInput({
                autoHideDialCode: true,
                autoPlaceholder: "ON",
                dropdownContainer: document.body,
                formatOnDisplay: true,
                hiddenInput: "full_number",
                initialCountry: "auto",
                nationalMode: true,
                placeholderNumberType: "MOBILE",
                preferredCountries: ['US'],
                separateDialCode: false
            });
            console.log(code)
        });
    </script>