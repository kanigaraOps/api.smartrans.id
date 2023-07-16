<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-12 side-right stretch-card">
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

                        <h4 class="card-title mb-0">Detail Voucher</h4>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent"> 

                            <!-- driver info form -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <?= form_open_multipart('transactionltr/editdata'); ?>
                                <input type="hidden" name="id" value="<?= $transaksi['id'] ?>">
                                <input type="hidden" name="notes" value="<?= $transaksi['notes'] ?>">
                                <div class="row">
                                    <div class=" form-group col-3">
                                    <label class="text-small">KODE VOUCHER</label>
                                    <input type="text" class="form-control" id="kode" name="kode"  value="<?= $transaksi['id_order'] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">JENIS ORDER</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis"  value="<?= $transaksi['order_fitur'] == 34 || $transaksi['order_fitur'] == 38 ? "SHUTTLE" : "RENTCAR" ?>"  >
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">APLIKATOR</label>
                                    <input type="text" class="form-control" id="aplikator" name="aplikator"  value="<?= $transaksi['aplikator'] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">FLEET</label>
                                    <input type="text" class="form-control" id="fleet" name="fleet"  value="<?= $transaksi['fleet'] ?>" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-5">
                                    <label class="text-small">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"  value="<?= $transaksi['fullnama'] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">Handphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"  value="<?= $transaksi['telepon_pelanggan'] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Area</label>
                                    <input type="text" class="form-control" id="region" name="region"  value="<?= $transaksi['regional'] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Kode Reg</label>
                                    <input type="text" class="form-control" id="kode_reg" name="kode_reg"  value="<?= $transaksi['region_code'] ?>" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Tanggal dan Jam</label>
                                    <input type="text" class="form-control" id="pickuptime" name="pickuptime"  value="<?= $transaksi['waktu_order'] ?>" required>
                                    </div>
                                    <div class=" form-group col-4">
                                    <label class="text-small">Tipe Mobil</label>
                                    <input type="text" class="form-control" id="typecar" name="typecar"  value="<?= explode("/",$transaksi['notes'])[1] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Qty</label>
                                    <input type="text" class="form-control" id="qty" name="qty"  value="1" disabled>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Durasi</label>
                                    <input type="text" class="form-control" id="durasi" name="durasi"  value="<?= $transaksi['order_fitur'] == 34 || $transaksi['order_fitur'] == 38? "0" : explode("/",$transaksi['notes'])[5] ?>" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Flight No</label>
                                    <input type="text" class="form-control" id="flight" name="flight"  value="<?= explode("/",$transaksi['notes'])[2] ?>" disabled>
                                    </div>
                                    <div class=" form-group col-4" hidden>
                                    <label class="text-small">Rute</label>
                                    <input type="text" class="form-control" id="rute" name="rute"  value="<?= $transaksi['status_transaksi'] ?>" >
                                    </div>
                                    <div class=" form-group col-4">
                                    <label class="text-small">Nett Driver</label>
                                    <input type="text" class="form-control" id="nd" name="nd"  value="<?= $transaksi['harga']/100 ?>" required>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class=" form-group col-6">
                                    <label class="text-small">Jemput</label>
                                    <textarea id="jemput" name="jemput" rows="6" class="form-control" required> <?= $transaksi['alamat_asal'] ?></textarea>
                                    </div>
                                    <div class=" form-group col-6">
                                    <label class="text-small">Tujuan / Pembelian Tambahan Rentcar</label> 
                                    <textarea id="tujuan" name="tujuan" rows="6" class="form-control" required> <?= $transaksi['alamat_tujuan'] ?></textarea>
                                    </div>
                                </div>      
                                    <button id="publish" type="submit" class="btn btn-success mr-2">Edit</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                    
                                <?= form_close(); ?>
                            </div>
                                <!-- tab content ends -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->




