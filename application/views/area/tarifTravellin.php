<div class="content-wrapper">
        <div class="card">

    </div>
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Travellin</h4>


            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Wilayah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($zona??[] as $tr) { ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $tr['nama']  ?></td>
                                        <td><?php echo $tr['wilayah']?></td>
                                        <td><?php echo $tr['harga'] ?></td>
                                        <td>
                                            <a href="<?= base_url(); ?>area/detailtariftravelin/<?= $tr['id']; ?>" class="btn btn-outline-primary">View</a>
                                               
                                            
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