<!-- partial -->
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-diamond icon-lg text-success"></i>
                        <div class="ml-3">
                            <p class="mb-0">Current App Revenue</p>
                            <?php
                            $walletvalue = $topup['total'] - $withdraw['total'] - ($ordermin['total'] - $orderplus['total']);
                            $apprevenue = ($ordermin['total'] - $orderplus['total']) - $jumlahdiskon['diskon'];
                            ?>
                            <h3><?= $currency['duit'] ?>
                                <?= number_format($apprevenue / 100, 2, ".", ".") ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-rotate-3d icon-lg text-success"></i>
                        <div class="ml-3">
                            <p class="mb-0">Current Wallet Amount</p>
                            <?php
                            $walletvalue = $topup['total'] - $withdraw['total'] - ($ordermin['total'] - $orderplus['total']);
                            ?>
                            <h3><?= $currency['duit'] ?>
                                <?= number_format($walletvalue / 100, 2, ".", ".") ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-ticket-percent icon-lg text-danger"></i>
                        <div class="ml-3">
                            <p class="mb-0">Current Discount Spent</p>
                            <?php
                            $walletvalue = $topup['total'] - $withdraw['total'] - ($ordermin['total'] - $orderplus['total']);
                            ?>
                            <h3><?= $currency['duit'] ?>
                                <?= number_format($jumlahdiskon['diskon'] / 100, 2, ".", ".") ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-import icon-lg text-primary"></i>
                        <div class="ml-3">
                            <p class="mb-0">Current Top Up Amount</p>
                            <h6><?= $currency['duit'] ?>
                                <?= number_format($topup['total'] / 100, 2, ".", ".") ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-export icon-lg text-danger"></i>
                        <div class="ml-3">
                            <p class="mb-0">Curent Withdraw Amount</p>
                            <h6><?= $currency['duit'] ?>
                                <?= number_format($withdraw['total'] / 100, 2, ".", ".") ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-motorbike icon-lg text-info"></i>
                        <div class="ml-3">
                            <p class="mb-0">Curent Transaction Amount</p>
                            <span class="mr-2 font-weight-bold">
                                <i class="badge badge-success mr-1">IN</i><?= $currency['duit'] ?>
                                <?= number_format($orderplus['total'] / 100, 2, ".", ".") ?></span>
                            <span class="font-weight-bold">
                                <i class="badge badge-danger mr-1">OUT</i><?= $currency['duit'] ?>
                                <?= number_format($ordermin['total'] / 100, 2, ".", ".") ?>
                                <i></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <?= form_open_multipart('wallet/index'); ?>

                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal</label>
                        <input type="date" class="form-control" id="tgl" name="tgl" placeholder="Tanggal">
                    </div>
                    
                    <div class="form-group">
                        <label for="newscategory">Bulan</label>
                        <select class="js-example-basic-single" name="bulan" style="width:100%">
                            <option value="ALL">ALL</option>
                            <option value="01">JAN</option>
                            <option value="02">FEB</option>
                            <option value="03">MAR</option>
                            <option value="04">APR</option>
                            <option value="05">MEI</option>
                            <option value="06">JUN</option>
                            <option value="07">JUL</option>
                            <option value="08">AUG</option>
                            <option value="09">SEP</option>
                            <option value="10">OKT</option>
                            <option value="11">NOV</option>
                            <option value="12">DES</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                    <?= form_close(); ?>

                </div>
                
                
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata()) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="tab-minimal tab-minimal-success">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#allwallet-2-1" role="tab" aria-controls="allwallet-2-1" aria-selected="true">
                                    <i class="mdi mdi-rotate-3d"></i>All Wallet</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#topup-2-2" role="tab" aria-controls="topup-2-2" aria-selected="false">
                                    <i class="mdi mdi-import"></i>Topup</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#withdraw-2-3" role="tab" aria-controls="withdraw-2-3" aria-selected="false">
                                    <i class="mdi mdi-export"></i>Withdraw Driver</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#withdraw-2-4" role="tab" aria-controls="withdraw-2-3" aria-selected="false">
                                    <i class="mdi mdi-export"></i>Deduct Timer Driver</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-4" data-toggle="tab" href="#transaction-2-4" role="tab" aria-controls="transaction-2-4" aria-selected="false">
                                    <i class="mdi mdi-motorbike"></i>Transaction</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-6" data-toggle="tab" href="#mutasi-2-6" role="tab" aria-controls="mutasi-2-6" aria-selected="false">
                                    <i class="mdi mdi-export"></i>Mutasi BCA</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-7" data-toggle="tab" href="#mutasi-2-7" role="tab" aria-controls="mutasi-2-7" aria-selected="false">
                                    <i class="mdi mdi-export"></i>GV Notif</a>
                            </li>
                        </ul>
                        </ul>
                        <div class="tab-content">

                            <!-- all wallet -->
                            <div class="tab-pane fade show active" id="allwallet-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">All Wallet</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Invoice</th>
                                                                <th>Date</th>
                                                                <th>Driver/Users</th>
                                                                <th>Name</th>
                                                                <th>Amount</th>
                                                                <th>Type</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($wallet as $wlt) { ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= $wlt['id'] ?></td>
                                                                    <td><?= $wlt['waktu'] ?></td>

                                                                    <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                    if ($caracter == 'P') { ?>
                                                                        <td class="text-primary">User</td>
                                                                    <?php } elseif ($caracter == 'M') { ?>
                                                                        <td class="text-success">Merchant</td>
                                                                    <?php } else { ?>
                                                                        <td class="text-warning">Driver</td>

                                                                    <?php } ?>

                                                                    <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>
                                                                    <?php if ($wlt['type'] == 'topup' or $wlt['type'] == 'topupqris' or $wlt['type'] == 'Order+') { ?>
                                                                        <td class="text-success">
                                                                            <?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?>
                                                                        </td>

                                                                    <?php } else { ?>
                                                                        <td class="text-danger">
                                                                            <?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?>
                                                                        </td>
                                                                    <?php } ?>

                                                                    <?php if ($wlt['type'] == 'topup' or $wlt['type'] == 'topupqris' or $wlt['type'] == 'Order+') { ?>
                                                                        <td>
                                                                            <label class="badge badge-outline-success"><?= $wlt['type'] ?></label>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>
                                                                            <label class="badge badge-outline-danger"><?= $wlt['type'] ?></label>
                                                                        </td>
                                                                    <?php } ?>

                                                                    <?php if ($wlt['status'] == '0') { ?>
                                                                        <td>
                                                                            <label class="badge badge-secondary text-dark">Pending</label>
                                                                        </td>
                                                                    <?php }
                                                                    if ($wlt['status'] == '1') { ?>
                                                                        <td>
                                                                            <label class="badge badge-success">Success</label>
                                                                        </td>
                                                                    <?php }
                                                                    if ($wlt['status'] == '2') { ?>
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
                            <!-- end of all wallet -->

                            <!-- top up -->
                            <div class="tab-pane fade" id="topup-2-2" role="tabpanel" aria-labelledby="tab-2-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <a class="btn btn-info" href="<?= base_url(); ?>wallet/tambahtopup"><i class="mdi mdi-plus-circle-outline"></i>Add Top Up</a>
                                        </div>
                                        <br>
                                        <h4 class="card-title">All Top Up</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing1" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Invoice</th>
                                                                <th>Date</th>
                                                                <th>Driver/User</th>
                                                                <th>Name</th>
                                                                <th>amount</th>
                                                                <th>Bank</th>
                                                                <th>Nama Rek</th>
                                                                <th>No Rek</th>
                                                                <th>Kode Unik</th>
                                                                <th>Transfer</th>
                                                                <?php if ($this->session->userdata('role') == 'super admin' || $this->session->userdata('role') == 'finance') { ?>
                                                                <th>Pembayaran</th>
                                                                    <th>aprovel</th>
                                                                <?php } ?>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            if ($this->session->userdata('role') != 'super admin'|| $this->session->userdata('role') == 'finance') {
                                                            $i = 1;
                                                            foreach ($wallet as $wlt) {
                                                                if ($wlt['type'] == 'topup' || $wlt['type'] == 'topupqris') { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $wlt['id'] ?></td>
                                                                        <td><?= $wlt['waktu'] ?></td>

                                                                        <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                        if ($caracter == 'P') { ?>
                                                                            <td class="text-primary">User</td>
                                                                        <?php } elseif ($caracter == 'M') { ?>
                                                                            <td class="text-success">Merchant</td>
                                                                        <?php } else { ?>
                                                                            <td class="text-warning">Driver</td>

                                                                        <?php } ?>

                                                                        <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>
                                                                        <td class="text-success"><?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $wlt['bank'] ?></td>
                                                                        <td><?= $wlt['nama_pemilik'] ?></td>

                                                                        <?php if ($wlt['bank'] == 'QRIS') { ?>
                                                                            <td>"QR CODE"</td>
                                                                        <?php } else { ?>
                                                                            <td><?= $wlt['rekening'] ?></td>
                                                                        <?php } ?>

                                                                        <td class="text-success">
                                                                            <?= $wlt['kode_unik'] ?>
                                                                        </td>

                                                                        <td class="text-success">
                                                                            <?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['transfer'] * 100 / 100, 2, ".", ".") ?>
                                                                        </td>

                                                                        <?php if ($wlt['status'] == '0') { ?>
                                                                            <td>
                                                                                <label class="badge badge-secondary text-dark">Pending</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '1') { ?>
                                                                            <td>
                                                                                <label class="badge badge-success">Success</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '2') { ?>
                                                                            <td>
                                                                                <label class="badge badge-danger">Canceled</label>
                                                                            </td>
                                                                        <?php } ?>
                                                                         <td><?php echo $wlt['topupvia'] ?></td>
                                                                            <td><?php if( $wlt['aprovel']=="AUTOTOPUP"){echo "AUTOTOPPUP";}else{ echo $wlt['aprovel']; } ?></td>
                                                                        <td>
                                                                            <?php if ($wlt['status'] == '0' && $this->session->userdata('role') == 'finance'||$wlt['status'] == '0' && $this->session->userdata('role') == 'super admin') { ?>
                                                                                <!--<a href="<?= base_url(); ?>wallet/tconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>">-->
                                                                                <!--    <button class="btn btn-outline-primary">Confirm</button></a>--> 
                                                                                    
                                                                                <!--<a href="<?= base_url(); ?>wallet/tconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>/CASH">-->
                                                                                <!--    <button class="btn btn-outline-success">Cash</button></a>-->
                                                                                <!--<a href="<?= base_url(); ?>wallet/tconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>/TRANSFER">-->
                                                                                <!--    <button class="btn btn-outline-primary">Transfer</button></a>-->
                                                                                <a href="<?= base_url(); ?>wallet/tcancel/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>">
                                                                                    <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger">Cancel</button></a>
                                                                            <?php } else { ?>
                                                                                <span class="btn btn-outline-muted">Completed</span>
                                                                            <?php } ?>

                                                                        </td>
                                                                    </tr>
                                                            <?php $i++;
                                                            }
                                                            }
                                                            }else{
                                                            $i = 1;
                                                            foreach ($wallet as $wlt) {
                                                                if ($wlt['type'] == 'topup' || $wlt['type'] == 'topupqris') { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $wlt['id'] ?></td>
                                                                        <td><?= $wlt['waktu'] ?></td>

                                                                        <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                        if ($caracter == 'P') { ?>
                                                                            <td class="text-primary">User</td>
                                                                        <?php } elseif ($caracter == 'M') { ?>
                                                                            <td class="text-success">Merchant</td>
                                                                        <?php } else { ?>
                                                                            <td class="text-warning">Driver</td>

                                                                        <?php } ?>

                                                                        <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>
                                                                        <td class="text-success"><?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $wlt['bank'] ?></td>
                                                                        <td><?= $wlt['nama_pemilik'] ?></td>

                                                                        <?php if ($wlt['bank'] == 'QRIS') { ?>
                                                                            <td>"QR CODE"</td>
                                                                        <?php } else { ?>
                                                                            <td><?= $wlt['rekening'] ?></td>
                                                                        <?php } ?>

                                                                        <td class="text-success">
                                                                            <?= $wlt['kode_unik'] ?>
                                                                        </td>

                                                                        <td class="text-success">
                                                                            <?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['transfer'] * 100 / 100, 2, ".", ".") ?>
                                                                        </td>
                                                                            <td><?php echo $wlt['topupvia']; ?></td>
                                                                            <td><?php if( $wlt['aprovel']=="AUTOTOPUP"){echo "AUTOTOPPUP";}else{ echo $wlt['aprovel']; } ?></td>

                                                                        <?php if ($wlt['status'] == '0') { ?>
                                                                            <td>
                                                                                <label class="badge badge-secondary text-dark">Pending</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '1') { ?>
                                                                            <td>
                                                                                <label class="badge badge-success">Success</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '2') { ?>
                                                                            <td>
                                                                                <label class="badge badge-danger">Canceled</label>
                                                                            </td>
                                                                        <?php } ?>
                                                                        <td>
                                                                            <?php if ($wlt['status'] == '0' && $this->session->userdata('role') == 'super admin' || $wlt['status'] == '0' && $this->session->userdata('role') == 'finance') { ?>
                                                                                <!--<a href="<?= base_url(); ?>wallet/tconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>">-->
                                                                                <!--    <button class="btn btn-outline-primary">Confirm</button></a>-->
                                                                                    
                                                                                <!--<a href="<?= base_url(); ?>wallet/tconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>/CASH">-->
                                                                                <!--    <button class="btn btn-outline-success">Cash</button></a>-->
                                                                                <!--<a href="<?= base_url(); ?>wallet/tconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>/TRANSFER">-->
                                                                                <!--    <button class="btn btn-outline-primary">Transfer</button></a>-->
                                                                                    
                                                                                <a href="<?= base_url(); ?>wallet/tcancel/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>">
                                                                                    <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger">Cancel</button></a>
                                                                            <?php } else { ?>
                                                                                <span class="btn btn-outline-muted">Completed</span>
                                                                            <?php } ?>

                                                                        </td>
                                                                    </tr>
                                                            <?php $i++;
                                                                
                                                                }
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of top up -->

                            <!-- withdraw driver -->
                            <div class="tab-pane fade" id="withdraw-2-3" role="tabpanel" aria-labelledby="tab-2-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <a class="btn btn-info" href="<?= base_url(); ?>wallet/tambahwithdraw"><i class="mdi mdi-plus-circle-outline"></i>Add Withdraw</a>
                                        </div>
                                        <br>
                                        <h4 class="card-title">Withdraw Driver</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Invoice</th>
                                                                <th>Date</th>

                                                                <th>Driver/Users</th>
                                                                <th>Name</th>
                                                                <th>Email</th>
                                                                <th>amount</th>
                                                                <th>Bank</th>
                                                                <th>Account Name</th>
                                                                <th>Account Number</th>
                                                                
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($wallettrx as $wlt) {
                                                                if ($wlt['type'] == 'withdraw') { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $wlt['id'] ?></td>
                                                                        <td><?= $wlt['waktu'] ?></td>

                                                                        <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                        if ($caracter == 'P') { ?>
                                                                            <td class="text-primary">User</td>
                                                                        <?php } elseif ($caracter == 'M') { ?>
                                                                            <td class="text-success">Merchant</td>
                                                                        <?php } else { ?>
                                                                            <td class="text-danger">Driver</td>

                                                                        <?php } ?>

                                                                        <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>
                                                                        <td><?= $wlt['email'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>
                                                                        <td class="text-success"><?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $wlt['bank'] ?></td>
                                                                        <td><?= $wlt['nama_pemilik'] ?></td>
                                                                        <?php if ($wlt['bank'] == 'QRIS') { ?>
                                                                            <td>"QR CODE"</td>
                                                                        <?php } else { ?>
                                                                            <td><?= $wlt['rekening'] ?></td>
                                                                        <?php } ?>
                                                                        <?php if ($wlt['status'] == '0') { ?>
                                                                            <td>
                                                                                <label class="badge badge-secondary text-dark">Pending</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '1') { ?>
                                                                            <td>
                                                                                <label class="badge badge-success">Success</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '2') { ?>
                                                                            <td>
                                                                                <label class="badge badge-danger">Canceled</label>
                                                                            </td>
                                                                        <?php } ?>



                                                                        <td>
                                                                            <?php if ($wlt['status'] == '0') { ?>
                                                                                <a href="<?= base_url(); ?>wallet/wconfirmtrx/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>">
                                                                                    <button class="btn btn-outline-primary">Confirm</button></a>
                                                                                <a href="<?= base_url(); ?>wallet/wcanceltrx/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>">
                                                                                    <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger">Cancel</button></a>
                                                                            <?php } else { ?>
                                                                                <span class="btn btn-outline-muted">Completed</span>
                                                                            <?php } ?>

                                                                        </td>


                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of withdraw driver -->

                            <!-- withdraw user -->
                            <div class="tab-pane fade" id="withdraw-2-4" role="tabpanel" aria-labelledby="tab-2-4">
                                <div class="card">
                                    <div class="card-body">
                                        <br>
                                        <h4 class="card-title">Deduct Timer</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Invoice</th>
                                                                <th>Date</th>
                                                                <th>Driver/Users</th>
                                                                <th>Name</th>
                                                                <th>amount</th>
                                                                <th>Bank</th>
                                                                <th>Account Name</th>
                                                                <th>Account Number</th>
                                                                <?php if ($this->session->userdata('role') == 'super admin') { ?>
                                                                    <th>aprovel</th>
                                                                <?php } ?>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($wallet as $wlt) {
                                                                if ($wlt['type'] == 'withdraw') { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $wlt['id'] ?></td>
                                                                        <td><?= $wlt['waktu'] ?></td>

                                                                        <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                        if ($caracter == 'P') { ?>
                                                                            <td class="text-primary">User</td>
                                                                        <?php } elseif ($caracter == 'M') { ?>
                                                                            <td class="text-success">Merchant</td>
                                                                        <?php } else { ?>
                                                                            <td class="text-warning">Driver</td>

                                                                        <?php } ?>

                                                                        <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>

                                                                        <td class="text-danger"><?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $wlt['bank'] ?></td>
                                                                        <td><?= $wlt['nama_pemilik'] ?></td>
                                                                        <?php if ($wlt['bank'] == 'QRIS') { ?>
                                                                            <td>"QR CODE"</td>
                                                                        <?php } else { ?>
                                                                            <td><?= $wlt['rekening'] ?></td>
                                                                        <?php } ?>
                                                                        <?php if ($this->session->userdata('role') == 'super admin') { ?>
                                                                            <td><?php echo $wlt['aprovel'] ?></td>
                                                                        <?php } ?>
                                                                        <?php if ($wlt['status'] == '0') { ?>
                                                                            <td>
                                                                                <label class="badge badge-secondary text-dark">Pending</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '1') { ?>
                                                                            <td>
                                                                                <label class="badge badge-success">Success</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '2') { ?>
                                                                            <td>
                                                                                <label class="badge badge-danger">Canceled</label>
                                                                            </td>
                                                                        <?php } ?>



                                                                        <td>
                                                                            <?php if ($wlt['status'] == '0') { ?>
                                                                                <a href="<?= base_url(); ?>wallet/wconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>">
                                                                                    <button class="btn btn-outline-primary">Confirm</button></a>
                                                                                <a href="<?= base_url(); ?>wallet/wcancel/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>">
                                                                                    <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger">Cancel</button></a>
                                                                            <?php } else { ?>
                                                                                <span class="btn btn-outline-muted">Completed</span>
                                                                            <?php } ?>

                                                                        </td>


                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of withdraw user -->

                            <!-- withdraw merchant -->
                            <div class="tab-pane fade" id="withdraw-2-5" role="tabpanel" aria-labelledby="tab-2-5">
                                <div class="card">
                                    <div class="card-body">
                                        <div>
                                            <a class="btn btn-info" href="<?= base_url(); ?>wallet/tambahwithdraw"><i class="mdi mdi-plus-circle-outline"></i>Add Withdraw</a>
                                        </div>
                                        <br>
                                        <h4 class="card-title">Withdraw User</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Invoice</th>
                                                                <th>Date</th>
                                                                <th>Driver/Users</th>
                                                                <th>Name</th>
                                                                <th>amount</th>
                                                                <th>Bank</th>
                                                                <th>Account Name</th>
                                                                <th>Account Number</th>
                                                                <?php if ($this->session->userdata('role') == 'super admin') { ?>
                                                                    <th>aprovel</th>
                                                                <?php } ?>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($wallet as $wlt) {
                                                                if ($wlt['type'] == 'withdraw') { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $wlt['id'] ?></td>
                                                                        <td><?= $wlt['waktu'] ?></td>

                                                                        <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                        if ($caracter == 'P') { ?>
                                                                            <td class="text-primary">User</td>
                                                                        <?php } elseif ($caracter == 'M') { ?>
                                                                            <td class="text-success">Merchant</td>
                                                                        <?php } else { ?>
                                                                            <td class="text-warning">Driver</td>

                                                                        <?php } ?>

                                                                        <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>

                                                                        <td class="text-danger"><?= $currency['duit'] ?>
                                                                            <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $wlt['bank'] ?></td>
                                                                        <td><?= $wlt['nama_pemilik'] ?></td>
                                                                        <?php if ($wlt['bank'] == 'QRIS') { ?>
                                                                            <td>"QR CODE"</td>
                                                                        <?php } else { ?>
                                                                            <td><?= $wlt['rekening'] ?></td>
                                                                        <?php } ?>
                                                                        <?php if ($this->session->userdata('role') == 'super admin') { ?>
                                                                            <td><?php $wlt['aprovel'] ?></td>
                                                                        <?php } ?>
                                                                        <?php if ($wlt['status'] == '0') { ?>
                                                                            <td>
                                                                                <label class="badge badge-secondary text-dark">Pending</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '1') { ?>
                                                                            <td>
                                                                                <label class="badge badge-success">Success</label>
                                                                            </td>
                                                                        <?php }
                                                                        if ($wlt['status'] == '2') { ?>
                                                                            <td>
                                                                                <label class="badge badge-danger">Canceled</label>
                                                                            </td>
                                                                        <?php } ?>



                                                                        <td>
                                                                            <?php if ($wlt['status'] == '0') { ?>
                                                                                <a href="<?= base_url(); ?>wallet/wconfirm/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>/<?= $wlt['jumlah'] ?>">
                                                                                    <button class="btn btn-outline-primary">Confirm</button></a>
                                                                                <a href="<?= base_url(); ?>wallet/wcancel/<?= $wlt['id'] ?>/<?= $wlt['id_user'] ?>">
                                                                                    <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger">Cancel</button></a>
                                                                            <?php } else { ?>
                                                                                <span class="btn btn-outline-muted">Completed</span>
                                                                            <?php } ?>

                                                                        </td>


                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of withdraw merchant -->

                            <!-- transaction -->
                            <div class="tab-pane fade" id="transaction-2-4" role="tabpanel" aria-labelledby="tab-2-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">All Transaction</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing3" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Transaction Inv</th>
                                                                <th>Service</th>
                                                                <th>Date</th>
                                                                <th>Driver/Users</th>
                                                                <th>Name</th>
                                                                <th>Amount</th>
                                                                <th>Type</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($wallet as $wlt) {
                                                                if ($wlt['type'] == 'Order+' or $wlt['type'] == 'Order-') { ?>
                                                                    <tr>
                                                                        <td><?= $i ?></td>
                                                                        <td><?= $wlt['id'] ?></td>
                                                                        <td><?= $wlt['bank'] ?></td>
                                                                        <td><?= $wlt['waktu'] ?></td>

                                                                        <?php $caracter = substr($wlt['id_user'], 0, 1);
                                                                        if ($caracter == 'P') { ?>
                                                                            <td class="text-primary">User</td>
                                                                        <?php } elseif ($caracter == 'M') { ?>
                                                                            <td class="text-success">Merchant</td>
                                                                        <?php } else { ?>
                                                                            <td class="text-warning">Driver</td>

                                                                        <?php } ?>

                                                                        <td><?= $wlt['nama_driver'] ?><?= $wlt['fullnama'] ?><?= $wlt['nama_mitra'] ?></td>

                                                                        <?php if ($wlt['type'] == 'Order+') { ?>
                                                                            <td class="text-success"><?= $currency['duit'] ?>
                                                                                <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <?php } else { ?>
                                                                            <td class="text-danger"><?= $currency['duit'] ?>
                                                                                <?= number_format($wlt['jumlah'] / 100, 2, ".", ".") ?></td>
                                                                        <?php } ?>

                                                                        <?php if ($wlt['type'] == 'Order+') { ?>
                                                                            <td>
                                                                                <label class="badge badge-primary">IN</label>
                                                                            </td>
                                                                        <?php } else { ?>
                                                                            <td>
                                                                                <label class="badge badge-danger">OUT</label>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of transaction -->

                                </div>
                            </div>
                            
                            <!-- mutasi bca-->
                            <div class="tab-pane fade" id="mutasi-2-6" role="tabpanel" aria-labelledby="tab-2-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Mutasi BCA</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing4" class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID Mutasi</th>
                <th>Keterangan</th>
                <th>Amount</th>
                <th>DB/CR</th>
                <th>Req_ID (Wallet)</th>
                <th>Created</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($mutasi as $mts) {
                // if ($mts['type'] == 'Order+' or $mts['type'] == 'Order-') { 
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $mts['id'] ?></td>
                        <td><?= $mts['keterangan'] ?></td>
                        <td class="text-success"><?= $currency['duit'] ?>
                                <?= number_format($mts['amount'], 2, ".", ".") ?></td>
                        <td><?= $mts['dbcr'] ?></td>
                        <td><?= $mts['req_id'] ?></td>
                        <td><?= $mts['created'] ?></td>
                        <?php if ($mts['req_id'] == 0) { ?>
                            <td>
                                <label class="badge badge-primary">NEW</label>
                            </td>
                        <?php } else if($mts['req_id'] == 1 || $mts['req_id'] == 2) { ?>
                            <td>
                                <label class="badge badge-danger">EXPIRED</label>
                            </td>
                            
                        <?php } else { ?>
                        <td>
                            <label class="badge badge-success">PAIRED</label>
                            </td>
                        <?php } ?>
                    </tr>
            <?php $i++;
                // } 
            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of mutasi -->

                                </div>
                            </div>
                            
                            <!-- mutasi gv-->
                            <div class="tab-pane fade" id="mutasi-2-7" role="tabpanel" aria-labelledby="tab-2-7">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">GV Notification</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing5" class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Status GV</th>
                <th>Merchant ID</th>
                <th>Bussiness ID</th>
                <th>Invoice No</th>
                <th>Amount</th>
                <th>MDR</th>
                <th>Issuer Name</th>
                <th>Cust Name</th>
                <th>Datetime GV</th>
                <th>Created</th>
                <th>Pairing</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1;
            foreach ($gvnotif as $mts) {
                // if ($mts['type'] == 'Order+' or $mts['type'] == 'Order-') { 
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $mts['status'] ?></td>
                        <td><?= $mts['merchant_id'] ?></td>
                        <td><?= $mts['bussiness_id'] ?></td>
                        <td><?= $mts['invoice_no'] ?></td>
                        <td class="text-success"><?= $currency['duit'] ?>
                                <?= number_format($mts['amount'], 2, ".", ".") ?></td>
                        <td><?= $mts['mdr'] ?></td>
                        <td><?= $mts['issuer_name'] ?></td>
                        <td><?= $mts['customer_name'] ?></td>
                        <td><?= $mts['datetime'] ?></td>
                        <td><?= $mts['created'] ?></td>
                        <td><?= $mts['id_wallet'] ?></td>
                    </tr>
            <?php $i++;
                // } 
            } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end of mutasi -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>