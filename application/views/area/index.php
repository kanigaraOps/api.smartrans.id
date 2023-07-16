<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Country Area</h4>
            

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
                                    <th>ID Area</th> 
                                    <th>Nama Area</th> 
                                    <th>Time Zone</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($area as $tr) { ?>

                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td>CA - <?= $tr['id'] ?></td>
                                        <td><?= $tr['area_name'] ?></td>
                                        <td><?= $tr['timezone'] ?></td>
                                        <td><?= $tr['created_at'] ?></td>
                                        <td><?= $tr['updated_at'] ?></td>
                                        <td>
                                            <?php if ($tr['status'] == '0') { ?>
                                                <label class="badge badge-danger"><?= $tr['status']; ?></label>
                                            <?php } ?>
                                            <?php if ($tr['status'] == '1') { ?>
                                                <label class="badge badge-success"><?= $tr['status']; ?></label>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>area/detail/<?= $tr['id']; ?>" class="btn btn-outline-primary">View</a>
                                            <a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>area/delete/<?= $tr['id']; ?>" class="btn btn-outline-danger">Delete</a>
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