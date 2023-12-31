<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-4 side-left d-flex align-items-stretch">
            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                            <?php if ($transaksi['status'] == '12') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-primary"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <?php if ($transaksi['status'] == '0') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-primary"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <?php if ($transaksi['status'] == '1') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-primary"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <?php if ($transaksi['status'] == '2') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-primary"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <?php if ($transaksi['status'] == '3') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-success"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <?php if ($transaksi['status'] == '4') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-info"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <?php if ($transaksi['status'] == '5') { ?>
                                <h4 class="card-title">Status<p class="ml-2 badge badge-danger"><?= $transaksi['status_transaksi'] ?></p>
                                </h4>
                            <?php } ?>
                            <br>
                            <div class="row">

                                <?php if ($transaksi['home'] == 4) { ?>

                                    <div class="col-4">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mdi-account mr-2 text-muted"></i>User</h6>
                                        <img src="<?= base_url('images/pelanggan/') . $transaksi['fotopelanggan']; ?>">
                                        <p class="name"><?= $transaksi['fullnama'] ?></p>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['email_pelanggan'] ?></a>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['telepon_pelanggan'] ?></a>
                                    </div>

                                    <div class="col-4">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mdi-store mr-2 text-muted"></i>Merchant</h6>
                                        <img src="<?= base_url('images/merchant/') . $transaksi['foto_merchant']; ?>">
                                        <p class="name"><?= $transaksi['nama_merchant'] ?></p>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['alamat_merchant'] ?></a>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['telepon_merchant'] ?></a>
                                    </div>

                                    <div class="col-4">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mdi-motorbike mr-2 text-muted"></i>Driver</h6>
                                        <img src="<?= base_url('images/fotodriver/') . $transaksi['foto']; ?>">
                                        <p class="name"><?= $transaksi['nama_driver'] ?></p>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['email'] ?></a>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['no_telepon'] ?></a>
                                    </div>


                                <?php } else { ?>

                                    <div class="col-6">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mdi-account mr-2 text-muted"></i>User</h6>
                                        <img src="<?= base_url('images/pelanggan/') . $transaksi['fotopelanggan']; ?>">
                                        <p class="name"><?= $transaksi['fullnama'] ?></p>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['email_pelanggan'] ?></a>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['telepon_pelanggan'] ?></a>
                                    </div>

                                    <div class="col-6">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mdi-motorbike mr-2 text-muted"></i>Driver</h6>
                                        <img src="<?= base_url('images/fotodriver/') . $transaksi['foto']; ?>">
                                        <p class="name"><?= $transaksi['nama_driver'] ?></p>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['email'] ?></a>
                                        <a class="d-block text-center text-dark" href="#"><?= $transaksi['no_telepon'] ?></a>
                                    </div>

                                <?php } ?>

                            </div>
                            <br>
                            <div class="row">
                            <div class="col-6">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mr-2 text-muted"></i>Area</h6>
                                    </div>

                                    <div class="col-6">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mr-2 text-muted"></i><?= $transaksi['region_code'] ?></h6>                                       
                                    </div>
                            </div>

                        </div>
                    </div>
                </div>

                <?php if ($transaksi['status'] <> '100') { ?>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                        <?= form_open_multipart('dashboard/shootdriver'); ?>
                            <div class="row">                            
                                    <div class="col-8">
                                    <label for="id_driver">Drivers</label>
                                    <input type="hidden" class="form-control" id="idtrx" name="idtrx" value="<?= $transaksi['id'] ?>">
                                        <select class="js-example-basic-single" style="width:100%" name="id_driver">
                                            <?php foreach ($driver as $drv) {?>
                                                <option value="<?= $drv['id'] ?>"><?= $drv['nama_driver'] ?> (<?= $drv['nomor_kendaraan'] ?>) 
                                                 </option>
                                            <?php 
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-2">
                                        <h6 class="text-center text-muted">
                                            <i class="mdi mr-2 text-muted"></i> </h6>
                                            <button type="submit" name="submit" value="shoot" class="btn btn-success mr-2">Shoot</button>
                                    </div>                                 
                            </div>
                            <br>
                            <div class="row"> 
                                <div class="col-3">
                                            <button type="submit" name="submit"value="free" class="btn btn-warning mr-2">Free</button>
                                </div>
                                <div class="col-9">
                                <p class="d-block text-center text-dark">Untuk melelang kembali VC </p>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-3">
                                            <button type="submit" name="submit"value="fix" class="btn btn-success mr-2">Fix</button>
                                </div>
                                <div class="col-9">
                                <p class="d-block text-center text-dark">Detail Voucher apk driver (Force Close) </p>
                                </div>
                            </div>
                            <?php if ($transaksi['status'] != 5 and $transaksi['status'] != 4) { ?>
                            <div class="row"> 
                                <div class="col-3">
                                            <button type="submit" name="submit"value="finish" class="btn btn-danger mr-2">Finish</button>
                                </div>
                                <div class="col-9">
                                <p class="d-block text-center text-dark">Hanya mengubah Status VC, Finish + Potongan gunakan Tombol Finish di kanan bawah </p>
                                </div>
                            </div>
                            <?php }?>
     
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
                <?php } ?>

                <?php if ($transaksi['home'] == 3) { ?>

                    <div class="col-12 stretch-card">
                        <div class="card">
                            <div class="card-body overview">

                                <div class=" col-12">
                                    <div>
                                        <p class="text-center">
                                            <i class="mdi mdi-account-location icon-lg text-primary "></i>
                                        </p>
                                        <h6 class="text-center">Pick Up</h6>
                                        <p class="text-center"><?= $transaksi['alamat_asal'] ?></p>
                                    </div>
                                </div>

                                <br>



                                <div class=" col-12 d-flex align-items-center justify-content-center">
                                    <div>
                                        <h6 class="text-center"><?= $transaksi['fitur'] ?></h6>
                                        <hr class="text-center">
                                        </hr>
                                        <p class="text-center">

                                            <?php if ($transaksi['home'] == '3') {
                                                if ($transaksi['jarak'] == '0') {
                                                    echo $transaksi['estimasi_time'];
                                                }
                                            } else {
                                                $jarak = $transaksi['jarak'];
                                                $jarakbulat = number_format($jarak, 1);
                                                echo $jarakbulat;
                                                echo ' ';
                                                echo $transaksi['keterangan_biaya'];
                                            } ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row info-links">
                                    <div class="col-4 align-items-center justify-content-md-center">
                                        <i class="mdi mdi-update text-gray">Order Time:
                                        </i>
                                        <p><?= $transaksi['waktu_order'] ?></p>
                                    </div>
                                    <div class=" col-4 d-flex align-items-center justify-content-md-center"></div>
                                    <div class="col-4 align-items-center justify-content-center">
                                        <i class="mdi mdi-update text-gray">Finish Time:
                                        </i>
                                        <p><?= $transaksi['waktu_selesai'] ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                <?php } else { ?>

                    <div class="col-12 stretch-card">
                        <div class="card">
                            <div class="card-body overview">
                                <div class="row">

                                    <div class=" col-4">
                                        <div>
                                            <p class="text-center">
                                                <?php if ($transaksi['home'] == 4 ) { ?>
                                                    <i class="mdi mdi-store icon-lg text-primary "></i>
                                                <?php } else { ?>
                                                    <i class="mdi mdi-account-location icon-lg text-primary "></i>
                                                <?php } ?>
                                            </p>
                                            <h6 class="text-center">Pick Up</h6>
                                            <p class="text-center"><?= $transaksi['alamat_asal'] ?></p>
                                        </div>
                                    </div>

                                    <div class=" col-4 d-flex align-items-center justify-content-center">
                                        <div>
                                            <h6 class="text-center"><?= $transaksi['fitur'] ?></h6>
                                            <hr class="text-center">
                                            </hr>
                                            <p class="text-center">

                                                <?php if ($transaksi['home'] == '3') {
                                                    if ($transaksi['jarak'] == '0') {
                                                        echo $transaksi['estimasi_time'];
                                                    }
                                                } else if ($transaksi['home'] == '2') {
                                                    echo '';
                                                } else {
                                                    $jarak = $transaksi['jarak'];
                                                    $jarakbulat = number_format($jarak, 1);
                                                    echo $jarakbulat;
                                                    echo ' ';
                                                    echo $transaksi['keterangan_biaya'];
                                                } ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class=" col-4">
                                        <div>
                                            <p class="text-center">
                                                <i class="mdi mdi-map-marker icon-lg text-danger "></i>
                                            </p>
                                            <h6 class="text-center">Drop Point</h6>
                                            <p class="text-center"><?= $transaksi['alamat_tujuan'] ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row info-links">
                                    <div class="col-4 align-items-center justify-content-md-center">
                                        <i class="mdi mdi-update text-gray">Order Time:
                                        </i>
                                        <p><?= $transaksi['waktu_order'] ?></p>
                                    </div>
                                    <div class=" col-4 d-flex align-items-center justify-content-md-center"></div>
                                    <div class="col-4 align-items-center justify-content-center">
                                        <i class="mdi mdi-update text-gray">Finish Time:
                                        </i>
                                        <p><?= $transaksi['waktu_selesai'] ?></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>
        <div class="col-lg-8 side-right stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <h3 class="text-right my-5">Invoice&nbsp;&nbsp;#INV-<?= $transaksi['id'] ?>
                            <span class="ml-2 badge badge-warning" style="font-size:100%;">
                                <i class="mdi mdi-star mr-1"></i><?= $transaksi['rate'] ?></span></h3>
                        <h6 class="text-right">Users Reviews</h6>
                        <h6 class="text-left">Aplikator</h6>
                        <?= $transaksi['aplikator'] ?>
                        <h6 class="text-left">Metode Pembayaran</h6>
                        <?= $transaksi['payment'] ?>
                        <h6 class="text-left">Notes</h6>
                        <?= $transaksi['notes'] ?>
                        <p class="text-right text-muted">
                            <?= $transaksi['catatan'] ?></p>
                        <hr>

                        <?php if ($transaksi['home'] == 4) { ?>
                            <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                                <div class="table-responsive w-100">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <th>Featured</th>
                                                <th>item</th>
                                                <th>qty</th>
                                                <th class="text-right">Total</th>
                                                <!-- <th class="text-right">Total</th> -->
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr>
                                                <td class="text-left"><?= $transaksi['fitur'] ?>
                                                    Service</td>

                                                <td>
                                                    <?php foreach ($transitem as $item) { ?>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><?= $item['nama_item'] ?></li>
                                                        </ul>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php foreach ($transitem as $item) { ?>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item"><?= $item['jumlah_item'] ?></li>
                                                        </ul>
                                                    <?php } ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php foreach ($transitem as $item) { ?>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <?= $currency['app_currency'] ?>
                                                                <?= number_format($item['total_harga']/100,2,".",".") ?>
                                                            </li>
                                                        </ul>
                                                    <?php } ?>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="container-fluid mt-5 w-100">
                                <p class="text-right mb-2">Amount of shopping:
                                    <?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['total_belanja']/100,2,".",".") ?></p>
                                <p class="text-right mb-2">Delivery cost (<?= $transaksi['jarak'] ?> KM):
                                    <?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['harga']/100,2,".",".") ?></p>
                                <p class="text-right mb-2">Sub - Total amount:
                                    <?php $subtotal = $transaksi['harga'] + $transaksi['total_belanja']; ?>

                                    <?= $currency['app_currency'] ?>
                                    <?= number_format($subtotal/100,2,".",".") ?></p>
                                <p class="text-right mb-2">Discount
                                    <span class="text-danger">
                                        (<?php if ($transaksi['pakai_wallet'] == '1') {
                                                echo $transaksi['nilai'];
                                            } else {
                                                echo 0;
                                            } ?>
                                        %)</span>
                                    :<?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['kredit_promo']/100,2,".",".") ?></p>
                                <br>
                                <p class="text-right mb-2 mt-4">Payment Method :
                                    <?php if ($transaksi['pakai_wallet'] == '0') { ?>
                                        <span class="badge badge-success"><?= 'CASH'; ?>
                                        <?php } else { ?>
                                            <span class="badge badge-primary"><?= 'wallet';
                                                                            } ?>
                                            </span>
                                </p>
                                <h4 class="text-right mb-5">Total :
                                    <?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['biaya_akhir']/100,2,".",".") ?></h4>
                                <hr>
                            </div>



                        <?php } else { ?>
                            <div class="container-fluid mt-5 d-flex justify-content-center w-100">
                                <div class="table-responsive w-100">
                                    <table class="table">
                                        <thead>
                                            <tr class="bg-dark text-white">
                                                <th>Featured</th>
                                                <?php if ($transaksi['home'] != '2') { ?>
                                                    <th class="text-right">Item</th>
                                                <?php } ?>
                                                <th class="text-right">-/+</th>
                                                <th class="text-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="text-right">
                                                <td class="text-left"><?= $transaksi['fitur'] ?>
                                                    Service</td>
                                                <?php if ($transaksi['home'] != '2') { ?>
                                                    <td>
                                                        <?php if ($transaksi['home'] == '3') {
                                                            if ($transaksi['jarak'] == '0') {
                                                                echo $transaksi['estimasi_time'];
                                                                echo $transaksi['keterangan_biaya'];
                                                            }
                                                        } else {
                                                            $jarak = $transaksi['jarak'];
                                                            $jarakbulat = number_format($jarak, 1);
                                                            echo $jarakbulat;
                                                            echo ' ';
                                                            echo $transaksi['keterangan_biaya'];   
                                                        } ?>
                                                    </td>
                                                <?php } ?>
                                                <td></td>
                                                <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['harga']/100,2,".",".") ?></td>
                                            </tr>
                                            <tr class="text-right">
                                                <td class="text-left">Base Fare</td>
                                                <td> </td>
                                                <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['base_fare']/100,2,".",".") ?></td>
                                                <td></td>
                                            </tr>
                                            <tr class="text-right">
                                                <td class="text-left">Distance Charge</td>
                                                <td> </td>
                                                <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['distance']/100,2,".",".") ?></td>
                                                <td></td>
                                            </tr>
                                            <tr class="text-right">
                                                <td class="text-left">Surge Charge</td>
                                                <td> </td>
                                                <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['surge_amount']/100,2,".",".") ?></td>
                                                <td></td>
                                            </tr>
                                            <tr class="text-right">
                                                <td class="text-left">Extra Charge</td>
                                                <td> </td>
                                                <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['extra_charges']/100,2,".",".") ?></td>
                                                <td></td>
                                            </tr>
                                            <tr class="text-right">
                                                <td class="text-left">Tawar</td>
                                                <td> </td>
                                                 <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['tawar']/100,2,".",".") ?></td>
                                                <td></td>
                                            </tr>
                                            <tr class="text-right">
                                                <td class="text-left">Tol</td>
                                                <td> </td>
                                                <td><?= $currency['app_currency'] ?>
                                                    <?= number_format($transaksi['toll_amount']/100,2,".",".") ?></td>
                                                <td></td>
                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                            </div>



                            <div class="container-fluid mt-5 w-100">
                                <p class="text-right mb-2">Sub - Total amount:
                                    <?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['harga']/100,2,".",".") ?></p>
                                <p class="text-right mb-2">Discount
                                    <span class="text-danger">
                                        (<?php if ($transaksi['pakai_wallet'] == '1') {
                                                echo $transaksi['nilai'];
                                            } else {
                                                echo 0;
                                            } ?>
                                        %)</span>
                                    :<?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['kredit_promo']/100,2,".",".") ?></p>
                                <br>
                                <p class="text-right mb-2 mt-4">Payment Method :
                                    <?php if ($transaksi['pakai_wallet'] == '0') { ?>
                                        <span class="badge badge-success"><?= 'CASH'; ?>
                                        <?php } else { ?>
                                            <span class="badge badge-primary"><?= 'wallet';
                                                                            } ?>
                                            </span>
                                </p>
                                <h4 class="text-right mb-5">Total :
                                    <?= $currency['app_currency'] ?>
                                    <?= number_format($transaksi['biaya_akhir']/100,2,".",".") ?></h4>
                                <hr>
                            </div>
                        <?php } ?>
                        <div class="container-fluid w-100">
                            <?php if ($transaksi['status'] != 5 and $transaksi['status'] != 4) { ?>
                                <a href="<?= base_url(); ?>dashboard/cancletransaction/<?= $transaksi['id'] ?>/<?= $transaksi['id_driver'] ?>" class="btn btn-danger float-right mt-4 ml-2">
                                    <i class="mdi mdi-cancel mr-1"></i>Cancel Transaction</a>
                                <a href="<?= base_url(); ?>dashboard/finishtransaction/<?= $transaksi['id'] ?>/<?= $transaksi['id_driver'] ?>" class="btn btn-success float-right mt-4 ml-2">
                                    <i class="mdi mdi-cancel mr-1"></i>Finish</a>
                            <?php } ?>

                            <a href="<?= base_url(); ?>" class="btn btn-primary float-right mt-4">
                                <i class="mdi mdi-keyboard-backspace mr-1"></i>Back</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->