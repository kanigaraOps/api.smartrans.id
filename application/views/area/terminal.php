<div class="content-wrapper">
        <div class="card">

    </div>
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Zona</h4>


            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Zona</th>
                                    <th>Base Fare</th>
                                    <th>KM</th>
                                     <th>surcharge</th>
                                    <th>distance</th>
                                    <th>extra charge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($zona??[] as $tr) { ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $tr['nama'] ?></td>
                                        <td><?php echo $tr['zona'] ?></td>
                                        <td><?php echo$tr['base_fare'] ?></td>
                                        <td><?php echo $tr['km'] ?></td>
                                         <td><?php echo $tr['surcharge'] ?></td>
                                        <td><?php echo$tr['distance'] ?></td>
                                        <td><?php echo $tr['extra_charge'] ?></td>
                                        <td>
                                            <a href="<?= base_url(); ?>area/detail/<?= $tr['id']; ?>" class="btn btn-outline-primary">View</a>
                                               
                                            
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