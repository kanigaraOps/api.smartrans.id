<!-- partial -->
<div class="content-wrapper">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Transaksi </h4>       
            <div class="row">
                <div class="col-4">
                <div class="card">
                <div class="card-body">
                <?= form_open_multipart('users/index'); ?>
                    <div class="form-group">
                        <label for="newscategory">Status</label>
                        <select class="js-example-basic-single" name="status" style="width:100%">
                            <option value="" >Status</option>
                            <option value="1" >Active</option>
                            <option value="0" >Blocked</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Search</label>
                        <input type="text" class="form-control" id="string" name="string" placeholder="Nama, HP, Email">
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
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div>
                    <a class="btn btn-info" href="<?= base_url(); ?>users/tambah">
                        <i class="mdi mdi-plus-circle-outline"></i>Add Users</a>
                </div>
                <br>
                <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('demo'); ?>
                        <?php echo $this->session->flashdata('hapus'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('ubah') or $this->session->flashdata('tambah')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('ubah'); ?>
                        <?php echo $this->session->flashdata('tambah'); ?>
                    </div>
                <?php endif; ?>
                <h4 class="card-title">Users</h4>
                <div class="tab-minimal tab-minimal-success">
                    <div class="tab-content">

                        <!-- all users -->
                        <div class="tab-pane fade show active" id="allusers-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Users</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Users Id</th>
                                                            <th>Profile Pic</th>
                                                            <th>Full Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($user as $us) { ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $us['id'] ?></td>
                                                                <td>
                                                                    <img src="<?= base_url('images/pelanggan/') . $us['fotopelanggan']; ?>">
                                                                </td>
                                                                <td><?= $us['fullnama'] ?></td>
                                                                <td><?= $us['email'] ?></td>
                                                                <td><?= $us['no_telepon'] ?></td>
                                                                <td>
                                                                    <?php if ($us['status'] == 1) { ?>
                                                                        <label class="badge badge-success">Active</label>
                                                                    <?php } else { ?>
                                                                        <label class="badge badge-dark">Blocked</label>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?= base_url(); ?>users/detail/<?= $us['id'] ?>">
                                                                        <button class="btn btn-outline-primary mr-2">View</button>
                                                                    </a>
                                                                    <?php if ($us['status'] == 0) { ?>
                                                                        <a href="<?= base_url(); ?>users/userunblock/<?= $us['id'] ?>">
                                                                            <button class="btn btn-outline-success text-red mr-2">Unblock</button>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="<?= base_url(); ?>users/userblock/<?= $us['id'] ?>">
                                                                            <button class="btn btn-outline-dark text-dark mr-2">Block</button>
                                                                        </a>
                                                                    <?php } ?>
                                                                    <a href="<?= base_url(); ?>users/hapususers/<?= $us['id'] ?>">
                                                                        <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                    </a>
                                                                </td>
                                                            <?php $i++;
                                                        } ?>
                                                            </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of all users -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-wrapper ends -->