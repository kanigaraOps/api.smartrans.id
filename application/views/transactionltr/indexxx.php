<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Transaksi</h4>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">

                            <?= form_open_multipart('transaction/index'); ?>

                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Jemput</label>
                                <input type="date" class="form-control" id="tgljemput" name="tgljemput" placeholder="Tanggal">
                            </div>

                            <div class="form-group">
                                <label for="newscategory">Services</label>
                                <select class="js-example-basic-single" name="fitur" style="width:100%">
                                    <option value="">ALL</option>
                                    <option value="34">Airport Transfer</option>
                                    <option value="20">Smart Rent</option>
                                    <option value="16">Smart Car</option>
                                    <option value="15">Smart Bike</option>
                                    <option value="21">Smart Food</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body">

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

                            <div class="form-group">
                                <label for="newscategory">Area</label>
                                <select class="js-example-basic-single" name="area" style="width:100%">
                                    <option value="">ALL</option>
                                    <option value="11">JAKARTA</option>
                                    <option value="14">SURABAYA</option>
                                    <option value="18">BANDUNG</option>
                                    <option value="21">YOGYAKARTA</option>
                                    <option value="10">MANADO</option>
                                    <option value="25">MAKASSAR</option>

                                </select>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="newscategory">Status</label>
                                <select class="js-example-basic-single" name="status" style="width:100%">
                                    <option value="">ALL</option>
                                    <option value="1">NEW</option>
                                    <option value="12">ASSIGNED</option>
                                    <option value="2">ACCEPTED</option>
                                    <option value="3">START</option>
                                    <option value="4">FINISH</option>
                                    <option value="5">CANCEL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="omset">Omset</label>
                                <input type="number" class="form-control" id="omset" name="omset" placeholder="omset">
                            </div>
                            <div class="form-group">
                                <label for="retase">Retase</label>
                                <input type="number" class="form-control" id="retase" name="retase" placeholder="retase">
                            </div>

                            <!-- <div class="form-group">
                                <input type="number" class="form-control" id="idbook" name="idbook" placeholder="ORANG">
                            </div> -->
                            <button type="submit" class="btn btn-success mr-2" name="submit">Submit</button>
                            <button type="submit" class="btn btn-light" name="export">Export</button>
                            <!-- <button type="submit" class="btn btn-success mr-2">Export</button> -->
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
                                    <th>Aplikator</th>
                                    <th>Pickup Time</th>
                                    <th>Pick Up</th>
                                    <th>Destination</th>
                                    <th>Price</th>
                                    <th>Payment Method</th>
                                    <th>Staff</th>
                                    <?php if ($this->session->userdata('role') == 'super admin' || $this->session->userdata('role') == 'finance') { ?>
                                    <th>release by</th>
                                    <?php } ?>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <?php if ($this->session->userdata('role') == 'super admin'|| $this->session->userdata('role') == 'finance') { ?>
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
                                        <td><?= $tr['aplikator'] ?></td>
                                        <td><?= $tr['waktu_order'] ?></td>
                                        <td style="max-width:300px;"><?= $tr['alamat_asal'] ?></td>
                                        <td style="max-width:300px;"><?= $tr['alamat_tujuan'] ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['biaya_akhir'] / 100, 2, ".", ".") ?></td>
                                        <td>
                                            <?php if ($tr['pakai_wallet'] == '0') {
                                                echo 'CASH';
                                            } else {
                                                echo 'WALLET';
                                            } ?>
                                        </td>
                                        <td><?= $tr['nama'] ?></td>
                                        <td><?= $tr['release'] ?></td>
                                        <td>
                                            <?php if ($tr['status'] == '20') { ?>
                                                <label class="badge badge-info"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
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
                                        
                                        <?php if ($tr['status'] == '20'){ ?>
                                            <a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>transactionltr/publish/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-info">Publish</a>
                                            <?php } ?>
                                            
                                            <?php if ($this->session->userdata('role')== 'super admin'){ ?>
                                            <a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>dashboard/delete/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-danger">Delete</a>
                                            <?php } ?>
                                            

                                                <!--<a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>dashboard/delete/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-danger">Delete</a>-->
                                            
                                        </td>
                                    </tr>
                                <?php $i++;
                                } ?>
                            </tbody>
                             <?php }else{ ?>                            
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
                                        <td><?= $tr['aplikator'] ?></td>
                                        <td><?= $tr['waktu_order'] ?></td>
                                        <td style="max-width:300px;"><?= $tr['alamat_asal'] ?></td>
                                        <td style="max-width:300px;"><?= $tr['alamat_tujuan'] ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['biaya_akhir'] / 100, 2, ".", ".") ?></td>
                                        <td>
                                            <?php if ($tr['pakai_wallet'] == '0') {
                                                echo 'CASH';
                                            } else {
                                                echo 'WALLET';
                                            } ?>
                                        </td>
                                        <td><?= $tr['nama'] ?></td>
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
                                                <label class="badge badge-warning"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
                                            <?php if ($tr['status'] == '5') { ?>
                                                <label class="badge badge-danger"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
                                            <?php if ($tr['status'] == '4') { ?>
                                                <label class="badge badge-success"><?= $tr['status_transaksi']; ?></label>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>dashboard/detail/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-primary">Views</a>
                                        </td>
                                    </tr>
                                <?php $i++;
                                } ?>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>