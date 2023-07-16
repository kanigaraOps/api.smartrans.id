<div class="content-wrapper">
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Transaksi</h4>       
            <div class="row">
                <div class="col-4">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search</h4>
                    <?= form_open_multipart('transactionltr/search'); ?>

                    <div class="form-group">
                        <label for="newscategory">Aplikasi</label>
                        <select class="js-example-basic-single" name="aplikasi" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="TRAVELOKA" >TRAVELOKA</option>
                            <option value="TIKET.COM" >TIKET.COM</option>
                            <option value="MOVIC" >MOVIC</option>
                            <option value="KLOOK" >KLOOK</option>
                            <option value="SMARTRANS" >SMARTRANS</option>
                            <option value="DARMAWISATA INDONESIA" >DARMAWISATA INDONESIA</option>
                        </select>
                    </div>  

                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Jemput</label>
                        <input type="date" class="form-control" id="tgljemput" name="tgljemput"  value="<?php echo date("Y-m-d"); ?>">
                    </div>

                </div>
                </div>
                </div>

                <div class="col-4">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search</h4>
                    <?= form_open_multipart('transactionltr/index'); ?>

                    <div class="form-group">
                        <label for="newscategory">Services</label>
                        <select class="js-example-basic-single" name="fitur" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="34" >AIRPORT TRANSFER</option>
                            <option value="20" >RENT CAR</option>
                        </select>
                    </div>  

                    <div class="form-group">
                        <label for="newscategory">Area</label>
                        <select class="js-example-basic-single" name="area" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="11" >JAKARTA</option>
                            <option value="14" >SURABAYA</option>
                            <option value="18" >BANDUNG</option>
                            <option value="21" >YOGYAKARTA</option>
                            <option value="10" >MANADO</option>
                            <option value="25" >MAKASSAR</option>

                        </select>
                    </div> 

                </div>
                </div>
                </div>

                <div class="col-4">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Search</h4>

                    <div class="form-group">
                        <label for="newscategory">Status</label>
                        <select class="js-example-basic-single" name="status" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="0" >NEW</option>
                            <option value="12" >ASSIGNED</option>
                            <option value="2" >ACCEPTED</option>
                            <option value="3" >START</option>
                            <option value="4" >FINISH</option>
                            <option value="5" >CANCEL</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">ID Booking</label>
                        <input type="text" class="form-control" id="idbook" name="idbook" placeholder="ID Booking Aplikasi">
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                    <?= form_close(); ?>
                </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Transaksi</h4>
            

            <div class="row">
                <div class="col-12">
                    <?php if ($this->session->flashdata()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                            <?php echo $this->session->flashdata('cancel'); ?>
                            <?php echo $this->session->flashdata('hapus'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Transaksi</th> 
                                    <th>ID Order</th> 
                                    <th>Customer</th>
                                    <th>Driver</th>
                                    <th>Area</th>
                                    <th>Service</th>
                                    <th>Notes</th>
                                    <th>Pickup Time</th>
                                    <th>Pick Up</th>
                                    <th>Destination</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($transaksi as $tr) { ?>

                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td>INV - <?= $tr['id_transaksi'] ?></td>
                                        <td><?= $tr['id_order'] ?></td>
                                        <td><?= $tr['fullnama'] ?></td>
                                        <td><?= $tr['nama_driver'] ?></td>
                                        <td><?= $tr['area_name'] ?></td>
                                        <td><?= $tr['fitur'] ?></td>
                                        <td><?= $tr['notes'] ?></td>
                                        <td><?= $tr['waktu_order'] ?></td>
                                        <td style="max-width:300px;"><?= $tr['alamat_asal'] ?></td>
                                        <td style="max-width:300px;"><?= $tr['alamat_tujuan'] ?></td>
                                        <td>
                                        
                                        <?php if ($tr['pakai_wallet'] == '0') {
                                                echo 'CASH';
                                            } else {
                                                echo 'WALLET';
                                            } ?><br><br>
                                            <?= $currency['app_currency'] ?>
                                            <?= number_format($tr['biaya_akhir'] / 100, 2, ".", ".") ?>

                                        </td>
                                        <td>
                                            <?php if ($tr['status'] == '0') { ?>
                                                <label class="badge badge-info"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
                                            <?php if ($tr['status'] == '1') { ?>
                                                <label class="badge badge-info"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
                                            <?php if ($tr['status'] == '12') { ?>
                                                <label class="badge badge-primary"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
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
                                            <?php if ($this->session->userdata('role')== 'super admin'){ ?>
                                            <a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>dashboard/delete/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-danger">Delete</a>
                                            <?php } ?>
                                        </td> 
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