<!-- partial -->
<div class="content-wrapper">
<div class="card">
        <div class="card-body">
            <h4 class="card-title">Data Driver</h4>       
            <div class="row">
                <div class="col-4">
                <div class="card">
                <div class="card-body">                    
                    <?= form_open_multipart('driver/index'); ?>                    
                    <div class="form-group">
                        <label >Search</label>
                        <input type="text" class="form-control" id="string" name="string" placeholder="Nama">
                    </div> 
                    <div class="form-group">
                        <label >Job</label>
                        <select class="js-example-basic-single" name="job" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="8" >Car</option>
                            <option value="7" >Bike</option>
                        </select>
                    </div>  
                </div>
                </div>
                </div>

                <div class="col-4">
                <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="newscategory">Area</label>
                        <select class="js-example-basic-single" name="area" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="11" >CGK</option>
                            <option value="12" >JABODETABEK</option>
                            <option value="14" >SURABAYA</option>
                            <option value="18" >BANDUNG</option>
                            <option value="21" >YOGYAKARTA</option>
                            <option value="10" >MANADO</option>
                            <option value="25" >MAKASSAR</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="newscategory">AP</label>
                        <select class="js-example-basic-single" name="ap" style="width:100%">
                            <option value="" >ALL</option>
                            <option value="1" >YA</option>
                        </select>
                    </div> 

                </div>
                </div>
                </div>

                <div class="col-4">
                <div class="card">
                <div class="card-body">

                    <div class="form-group">
                        <label for="newscategory">Status</label>
                        <select class="js-example-basic-single" name="status" style="width:100%">
                            <option value="1" >Active</option>
                            <option value="4" >Non Active</option>
                            <option value="3" >Work</option>
                            <option value="5" >Log Out</option>
                            <option value="6" >Suspended</option>
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

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if ($this->session->flashdata('tambah') or $this->session->flashdata('ubah')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('tambah'); ?>
                        <?php echo $this->session->flashdata('ubah'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('demo'); ?>
                        <?php echo $this->session->flashdata('hapus'); ?>
                    </div>
                <?php endif; ?>
                <h4 class="card-title">Drivers</h4>
                <div class="tab-minimal tab-minimal-success">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="alldrivers-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Drivers</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>drivers Id</th>
                                                            <th>Profile Pic</th>
                                                            <th>Full Name</th>
                                                            <th>Phone</th>
                                                            <th>Area</th>
                                                            <th>Rating</th>
                                                            <th>Deposit</th>
                                                            <th>Job Service</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($driver as $drv) {
                                                            if ($drv['status'] != 0) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?= $i ?>
                                                                    </td>
                                                                    <td><?= $drv['id'] ?></td>
                                                                    <td>
                                                                        <img src="<?= base_url('images/fotodriver/') . $drv['foto']; ?>">
                                                                    </td>
                                                                    <td><?= $drv['nama_driver'] ?></td>
                                                                    <td><?= $drv['no_telepon'] ?></td>
                                                                    <td><?= $drv['area_name'] ?></td>
                                                                    <td><?= number_format($drv['rating'], 1) ?></td>
                                                                    <td><?= number_format($drv['saldo'] / 100, 2, ".", ".") ?></td>
                                                                    <td><?= $drv['driver_job'] ?></td>
                                                                    <td>
                                                                        <?php if ($drv['status'] == 3) { ?>
                                                                            <label class="badge badge-dark">Banned</label>
                                                                        <?php } elseif ($drv['status'] == 0) { ?>
                                                                            <label class="badge badge-secondary text-dark">New Reg</label>
                                                                            <?php } else {
                                                                            if ($drv['status_job'] == 1) { ?>
                                                                                <label class="badge badge-primary">Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 2) { ?>
                                                                                <label class="badge badge-info">Pick'up</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 3) { ?>
                                                                                <label class="badge badge-success">work</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 4) { ?>
                                                                                <label class="badge badge-danger">Non Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 5) { ?>
                                                                                <label class="badge badge-danger">Log Out</label>
                                                                        <?php }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?= base_url(); ?>driver/detail/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-primary mr-2">View</button>
                                                                        </a>
                                                                        <?php
                                                                        if ($drv['status'] != 0) {

                                                                            if ($drv['status'] != 3) { ?>
                                                                                <a href="<?= base_url(); ?>driver/block/<?= $drv['id'] ?>"><button class="btn btn-outline-dark text-red mr-2">Block</button></a>
                                                                            <?php } else { ?>
                                                                                <a href="<?= base_url(); ?>driver/unblock/<?= $drv['id'] ?>"><button class="btn btn-outline-success text-red mr-2">Unblock</button></a>
                                                                        <?php }
                                                                        } ?>
                                                                        <a href="<?= base_url(); ?>driver/hapus/<?= $drv['id'] ?>">
                                                                            <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                        </a>

                                                                    </td>
                                                                </tr>
                                                        <?php $i++;
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-wrapper ends -->