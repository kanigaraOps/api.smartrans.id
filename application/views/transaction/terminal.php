<div class="content-wrapper">
        <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body">

                            <?= form_open_multipart('transaction/terminal'); ?>
                            <div class="form-group">
                                <label for="retase">DRIVER AP</label>
                                <input type="number" class="form-control" id="driver" name="driver" value=<? echo (int)$driver->ap?>>
                            </div>

                            <button type="submit" class="btn btn-success mr-2" name="submit">Submit</button>
                            <button type="submit" disabled="disabled" class="btn btn-light" name="export">Cancel</button>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Terminal</h4>


            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Minimum</th>
                                    <th>Fee Company</th>
                                    <th>Base Fare</th>
                                    <th>Distance</th>
                                    <th>Surge</th>
                                    <th>Retase</th>
                                    <th>Omset</th>
                                    <th>30KM</th>
                                    <th>50KM</th>
                                    <th>100KM</th>
                                    <th>150KM</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($terminal as $tr) { ?>

                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $tr['nama'] ?></td>
                                        <td><?= $tr['minimum_wallet_amount'] ?></td>
                                        <td><?= $tr['fee_company'] ?></td>
                                        <td><?= $tr['base_fare'] ?></td>
                                        <td><?= $tr['distance'] ?></td>
                                        <td><?= $tr['surge'] ?></td>
                                        <td><?= $tr['retase'] ?></td>
                                        <td><?= $tr['omset'] ?></td>
                                        <td><?= $tr['KM30'] ?></td>
                                        <td><?= $tr['KM50'] ?></td>
                                        <td><?= $tr['KM100'] ?></td>
                                        <td><?= $tr['KM150'] ?></td>
                                        <td>
                                            <a href="<?= base_url(); ?>transaction/detail/<?= $tr['id']; ?>" class="btn btn-outline-primary">View</a>
                                               
                                            
                                        </td>
                                        
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