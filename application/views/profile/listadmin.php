<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">List Admin</h4>
            

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
                                    <th>ID Akun</th> 
                                    <th>Username</th> 
                                    <th>Nama</th> 
                                    <th>Email</th>
                                    <th>role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($admin as $tr) { ?>

                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $tr['id'] ?></td>
                                        <td><?= $tr['user_name'] ?></td>
                                        <td><?= $tr['nama'] ?></td>
                                        <td><?= $tr['email'] ?></td>
                                        <td><?= $tr['role'] ?></td>
                                        <td>
                                            <?php if ($tr['status'] == '0') { ?>
                                                <label class="badge badge-danger">Non Active</label>
                                            <?php } ?>
                                            <?php if ($tr['status'] == '1') { ?>
                                                <label class="badge badge-primary">Active</label>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url(); ?>profile/detail/<?= $tr['id']; ?>" class="btn btn-outline-primary">View</a>
                                            <a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>profile/delete/<?= $tr['id']; ?>" class="btn btn-outline-danger">Delete</a>
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