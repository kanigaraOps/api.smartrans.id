<!-- partial -->
<?$nilaireported=0;$nilaiunreported=0?>
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-diamond icon-lg text-success"></i>
                        <div class="ml-3">
                            <p class="mb-0">Total</p>
                            <p class="mb-0">RP. <?echo  number_format($total/ 100, 2, ".", ".")  ?> </p>
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
                            <p class="mb-0">Total Reported</p>
                            <p class="mb-0">RP. <?echo  number_format($total_reported / 100, 2, ".", ".")  ?></p>
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
                            <p class="mb-0">Total UNREPORTED</p>
                            <p class="mb-0">RP. <?echo  number_format($total_unreported / 100, 2, ".", ".")  ?></p>
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
                            <p class="mb-0">TOTAL ORDER</p>
                            <p class="mb-0"><?echo count($transaksi)  ?></p>
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
                            <p class="mb-0">TOTAL PENUMPANG</p>
                            <p class="mb-0"><?echo $total_penumpang ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-motorbike icon-lg text-succes"></i>
                        <div class="ml-3">
                            <p class="mb-0">DRIVER AP</p>
                            <p class="mb-0"><?echo count($driver)  ?></p>
                            <span class="mr-2 font-weight-bold">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-md-center">
                        <i class="mdi mdi-motorbike icon-lg text-danger"></i>
                        <div class="ml-3">
                            <p class="mb-0">REPORTED</p>
                            <p class="mb-0"><?
                            foreach ($transaksi as $tr){
                                 $tr["report"]==1?$nilaireported++:$nilaiunreported++;
                             }
                            echo $nilaireported ?></p>
                            <span class="mr-2 font-weight-bold">

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
                            <p class="mb-0">UNREPORTED </p>
                            <p class="mb-0"><?
                             
                            echo $nilaiunreported ?></p>
                            <span class="mr-2 font-weight-bold">

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

                    <?= form_open_multipart('transaction/laporan_ap'); ?>

                    <div class="form-group">
                        <label for="tgl_lahir">Tanggal Jemput</label>
                        <input type="date" class="form-control" id="tgljemput" name="tgljemput" placeholder="Tanggal">
                    </div>
                    <div class="form-group">
                        <label for="newscategory">Status</label>
                        <select class="js-example-basic-single" name="status" style="width:100%">
                            <option value="">ALL</option>
                            <option value="1">REPORTED</option>
                            <option value="0">UNREPORTED</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mr-2" name="submit">Submit</button>
                    <button type="submit" class="btn btn-light" name="export">Export</button>
                    <!-- <button type="submit" class="btn btn-success mr-2">Export</button> -->
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
                                    <i class="mdi mdi-rotate-3d"></i>All LAPORAN</a>
                            </li>
                            <!--<li class="nav-item">-->
                            <!--    <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#topup-2-2" role="tab" aria-controls="topup-2-2" aria-selected="false">-->
                            <!--        <i class="mdi mdi-import"></i>REPORTED</a>-->
                            <!--</li>-->
                            <!--<li class="nav-item">-->
                            <!--    <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#withdraw-2-3" role="tab" aria-controls="withdraw-2-3" aria-selected="false">-->
                            <!--        <i class="mdi mdi-export"></i>UNREPORTED</a>-->
                            <!--</li>-->
                            <!--<li class="nav-item">-->
                            <!--    <a class="nav-link" id="tab-2-4" data-toggle="tab" href="#topup-2-4" role="tab" aria-controls="topup-2-4" aria-selected="false">-->
                            <!--        <i class="mdi mdi-export"></i>FILTER</a>-->
                            <!--</li>-->
                            <li class="nav-item">
                                <a class="nav-link" id="tab-2-5" data-toggle="tab" href="#AP-2-5" role="tab" aria-controls="AP-2-5" aria-selected="false">
                                    <i class="mdi mdi-export"></i>AP</a>
                            </li>
                        </ul>
                        </ul>
                        <div class="tab-content">

                            <!-- all wallet -->
                            <div class="tab-pane fade show active" id="allwallet-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">All LAPORAN</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice No</th>
                                                                <th>Transaction Date</th>
                                                                <th>Transaction Time</th>
                                                                <th>Location</th>
                                                                <th>Item Sequence</th>
                                                                <th>Item Nama</th>
                                                                <th>Item Code</th>
                                                                <th>Quantity</th>
                                                                <th>Price per unit</th>
                                                                <th>Price amount</th>
                                                                <th>VAT</th>
                                                                <th>Total Price Amount</th>
                                                                <th>Total VAT</th>
                                                                <th>Transaction amount </th>
                                                                <th>pasenger </th>
                                                                <th>Retase </th>
                                                                <th>Omset </th>
                                                                <th>KM </th>
                                                                <th>Driver </th>
                                                                <th>Tujuan </th>
                                                                <th>Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($transaksi as $tr) { ?>

                                                                <tr>
                                                                    <td><?= $i; ?></td>
                                                                    <td><?= date_format(new DateTime($tr['waktu_order']), "Y-m-d") ?></td>
                                                                    <td><?= $tr['waktu_order'] ?></td>
                                                                    <td><?= $tr['aplikator'] ?></td>

                                                                    <td><?= $i ?></td>
                                                                    <td><?= $tr['fitur'] ?></td>
                                                                    <td><?= $tr['id_order'] ?></td>
                                                                    <td><?= 1 ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp.
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $tr['pasenger'] ?></td>
                                                                    <td><?= $tr['retase'] ?></td>
                                                                    <td><?= $tr['percent'] ?></td>
                                                                    <td><?= (int)$tr['km']/100 ?></td>
                                                                    <td><?= $tr['nama_driver'] ?></td>
                                                                    <td><?= $tr['alamat_tujuan'] ?></td>
                                                                    <td><?= $tr['report'] == 1 ? "REPORTED" : "UNREPORTED" ?></td>
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
                                        <h4 class="card-title">REPORTED</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice No</th>
                                                                <th>Transaction Date</th>
                                                                <th>Transaction Time</th>
                                                                <th>Location</th>
                                                                <th>Item Sequence</th>
                                                                <th>Item Nama</th>
                                                                <th>Item Code</th>
                                                                <th>Quantity</th>
                                                                <th>Price per unit</th>
                                                                <th>Price amount</th>
                                                                <th>VAT</th>
                                                                <th>Total Price Amount</th>
                                                                <th>Total VAT</th>
                                                                <th>Transaction amount </th>
                                                                <th>pasenger </th>
                                                                <th>Retase </th>
                                                                <th>Omset </th>
                                                                <th>KM </th>
                                                                <th>Driver </th>
                                                                <th>Tujuan </th>
                                                                <th>Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($reported as $tr) { ?>

                                                                <tr>
                                                                    <td><?= $i; ?></td>
                                                                    <td><?= date_format(new DateTime($tr['waktu_order']), "Y-m-d") ?></td>
                                                                    <td><?= $tr['waktu_order'] ?></td>
                                                                    <td><?= $tr['aplikator'] ?></td>

                                                                    <td><?= $i ?></td>
                                                                    <td><?= $tr['fitur'] ?></td>
                                                                    <td><?= $tr['id_order'] ?></td>
                                                                    <td><?= 1 ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp.
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $tr['pasenger'] ?></td>
                                                                    <td><?= $tr['retase'] ?></td>
                                                                    <td><?= $tr['percent'] ?></td>
                                                                    <td><?= (int)$tr['km']/100 ?></td>
                                                                    <td><?= $tr['nama_driver'] ?></td>
                                                                    <td><?= $tr['alamat_tujuan'] ?></td>
                                                                    <td><?= $tr['report'] == 1 ? "REPORTED" : "UNREPORTED" ?></td>

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
                            <!-- end of top up -->

                            <!-- withdraw driver -->
                            <div class="tab-pane fade" id="withdraw-2-3" role="tabpanel" aria-labelledby="tab-2-3">
                                <div class="card">
                                    <div class="card-body">
                                        <br>
                                        <h4 class="card-title">Withdraw Driver</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice No</th>
                                                                <th>Transaction Date</th>
                                                                <th>Transaction Time</th>
                                                                <th>Location</th>
                                                                <th>Item Sequence</th>
                                                                <th>Item Nama</th>
                                                                <th>Item Code</th>
                                                                <th>Quantity</th>
                                                                <th>Price per unit</th>
                                                                <th>Price amount</th>
                                                                <th>VAT</th>
                                                                <th>Total Price Amount</th>
                                                                <th>Total VAT</th>
                                                                <th>Transaction amount </th>
                                                                <th>pasenger </th>
                                                                <th>Retase </th>
                                                                <th>Omset </th>
                                                                <th>KM </th>
                                                                <th>Driver </th>
                                                                <th>Tujuan </th>
                                                                <th>Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($unreported as $tr) { ?>

                                                                <tr>
                                                                    <td><?= $i; ?></td>
                                                                    <td><?= date_format(new DateTime($tr['waktu_order']), "Y-m-d") ?></td>
                                                                    <td><?= $tr['waktu_order'] ?></td>
                                                                    <td><?= $tr['aplikator'] ?></td>

                                                                    <td><?= $i ?></td>
                                                                    <td><?= $tr['fitur'] ?></td>
                                                                    <td><?= $tr['id_order'] ?></td>
                                                                    <td><?= 1 ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp.
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $tr['pasenger'] ?></td>
                                                                    <td><?= $tr['retase'] ?></td>
                                                                    <td><?= $tr['percent'] ?></td>
                                                                    <td><?= (int)$tr['km']/100 ?></td>
                                                                    <td><?= $tr['nama_driver'] ?></td>
                                                                    <td><?= $tr['alamat_tujuan'] ?></td>
                                                                    <td><?= $tr['report'] == 1 ? "REPORTED" : "UNREPORTED" ?></td>

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
                            
                            
                            
                            
                            <div class="tab-pane fade" id="topup-2-4" role="tabpanel" aria-labelledby="tab-2-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">FILTER</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing1" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Invoice No</th>
                                                                <th>Transaction Date</th>
                                                                <th>Transaction Time</th>
                                                                <th>Location</th>
                                                                <th>Item Sequence</th>
                                                                <th>Item Nama</th>
                                                                <th>Item Code</th>
                                                                <th>Quantity</th>
                                                                <th>Price per unit</th>
                                                                <th>Price amount</th>
                                                                <th>VAT</th>
                                                                <th>Total Price Amount</th>
                                                                <th>Total VAT</th>
                                                                <th>Transaction amount </th>
                                                                <th>pasenger </th>
                                                                <th>Retase </th>
                                                                <th>Omset </th>
                                                                <th>Km </th>
                                                                <th>Driver </th>
                                                                <th>Tujuan </th>
                                                                <th>Status </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($filter as $tr) { ?>

                                                                <tr>
                                                                    <td><?= $i; ?></td>
                                                                    <td><?= date_format(new DateTime($tr['waktu_order']), "Y-m-d") ?></td>
                                                                    <td><?= $tr['waktu_order'] ?></td>
                                                                    <td><?= $tr['aplikator'] ?></td>

                                                                    <td><?= $i ?></td>
                                                                    <td><?= $tr['fitur'] ?></td>
                                                                    <td><?= $tr['id_order'] ?></td>
                                                                    <td><?= 1 ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp.
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                    <td>0</td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr['total'] / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $tr['pasenger'] ?></td>
                                                                    <td><?= $tr['retase'] ?></td>
                                                                    <td><?= $tr['percent'] ?></td>
                                                                     <td><?= (int)$tr['km']/100 ?></td>
                                                                    <td><?= $tr['nama_driver'] ?></td>
                                                                    <td><?= $tr['alamat_tujuan'] ?></td>
                                                                    <td><?= $tr['keterangan']  ?></td>

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
                            <!-- end of top up -->
                            
                            <div class="tab-pane fade " id="AP-2-5" role="tabpanel" aria-labelledby="tab-2-5">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">AP</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing2" class="table">
                                                        <thead>
			                                                    <th>No</th>
                                                                <th>Invoice No</th>
                                                                <th>Transaction Date</th>
                                                                <th>Transaction Time</th>
                                                                <th>Item Sequence</th>
                                                                <th>Item Nama</th>
                                                                <th>Item Code</th>
                                                                <th>Quantity</th>
                                                                <th>Price per unit</th>
                                                                <th>Price Amount</th>
                                                                <th>Total Price Amount</th>
                                                                <th>VAT</th>
                                                                <th>Transaction Amount</th>
                                                                <th>Total VAT</th>
                                                                <th>Discount </th>
                                                                <th>TAX </th>
                                                                <th>Total Discount </th>
                                                                <th>Total Tax </th>
                                                                <th>Total Service Charge </th>
                                                                <th>Currency </th>
                                                                <th>Action </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 1;
                                                            foreach ($ap as $tr) { ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= $tr->invoice_number ?></td>
                                                                    <td><?= $tr->transaction_date ?></td>
                                                                    <td><?= $tr->transaction_time ?></td>
                                                                    <td><?= $tr->sequence ?></td>
                                                                    <td><?= $tr->item_name ?></td>
                                                                    <td><?= $tr->item_code ?></td>
                                                                    <td><?= $tr->item_quantity ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr->item_price_unit / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr->item_price_amount / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp.
                                                                        <?= number_format($tr->item_total_price_amount / 100, 2, ".", ".") ?></td>
                                                                    <td>Rp .
                                                                        <?= number_format($tr->item_vat , 2, ".", ".") ?></td>
                                                                        <td>Rp .
                                                                        <?= number_format($tr->transaction_amount , 2, ".", ".") ?></td>
                                                                                                                                                <td>Rp .
                                                                        <?= number_format($tr->item_total_vat , 2, ".", ".") ?></td>
                                                                        <td>Rp .
                                                                        <?= number_format($tr->item_discount , 2, ".", ".") ?></td>
                                                                        <td>Rp .
                                                                        <?= number_format($tr->item_tax, 2, ".", ".") ?></td>
                                                                         <td>Rp .
                                                                        <?= number_format($tr->item_total_discount, 2, ".", ".") ?></td>
                                                                        <td>Rp .
                                                                        <?= number_format($tr->item_total_tax , 2, ".", ".") ?></td>
                                                                        <td>Rp .
                                                                        <?= number_format($tr->item_total_service_charge / 100, 2, ".", ".") ?></td>
                                                                        <td><?= $tr->currency ?></td>
                                                                        <td>
                                                                        <a href="<?= base_url(); ?>transaction/detailap/<?= $tr->invoice_number ?>">
                                                                            <button class="btn btn-outline-primary mr-2">Edit</button>
                                                                        </a>
                                                                        </td>
                                                                         </tr>
                                                                <?php $i++;
                                                            } ?>
                                                        </tbody>-
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- withdraw driver -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div>