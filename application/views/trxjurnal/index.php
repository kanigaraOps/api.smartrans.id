<div class="content-wrapper">
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Transaksi</h4>       
            <div class="row">
                <div class="col-4">
                <div class="card">
                <div class="card-body">
                    
                    <?= form_open_multipart('trxjurnal/index'); ?>

                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Jemput</label>
                        <input type="date" class="form-control" id="tgljemput" name="tgljemput" placeholder="Tanggal">
                    </div>

                    <div class="form-group">
                        <select class="js-example-basic-single" name="bulan" style="width:100%">
                            <option value="ALL" >Bulan</option> 
                            <option value="01" >JAN</option>
                            <option value="02" >FEB</option>
                            <option value="03" >MAR</option>
                            <option value="04" >APR</option>
                            <option value="05" >MEI</option>
                            <option value="06" >JUN</option>
                            <option value="07" >JUL</option>
                            <option value="08" >AUG</option>
                            <option value="09" >SEP</option>
                            <option value="10" >OKT</option>
                            <option value="11" >NOV</option>
                            <option value="12" >DES</option>
                        </select> 
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
            <h4 class="card-title">Data Jurnal Transaksi</h4>
            

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
                                    <th>STBD</th>
                                    <th>Base Fare</th>
                                    <th>Distance</th>
                                    <th>Surge</th>
                                    <th>Ex. Charge</th>
                                    <th>Upping</th>
                                    <th>Disc</th>
                                    <th>Tol</th>
                                    <th>Payment</th>
                                    <th>Comp Earn</th>
                                    <th>Driver Earn</th>
                                    <th>Deduct</th>
                                    <th>Driver Payout</th>
                                    <th>Act</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($transaksi_jurnal as $tr) { ?>

                                    <tr>
                                        <td><?= $i ?></td>

                                        <td>INV -  <?= $tr['id_transaksi'] ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['sub_total_before_discount'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['base_fare'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['distance'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['surge_amount'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['extra_charges'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['tawar'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['discount_amount'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['toll_amount'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['customer_paid_amount'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['company_earning'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['driver_earning'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['amount_deducted_from_driver_wallet'] / 100, 2, ".", ".") ?></td>
                                        <td><?= $currency['app_currency'] ?>
                                            <?= number_format($tr['driver_total_payout_amount'] / 100, 2, ".", ".") ?></td>
                                        <td>
                                            <a href="<?= base_url(); ?>dashboard/detail/<?= $tr['id_transaksi']; ?>" class="btn btn-outline-primary">View</a>
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