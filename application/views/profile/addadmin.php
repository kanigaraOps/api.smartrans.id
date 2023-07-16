<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">Admin Profile</h4>
                        <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                            <li class="nav-item">
                                <span class="nav-link active" id="info-tab" data-toggle="tab" role="tab" aria-controls="info" aria-expanded="true">Create</span>
                            </li>
                        </ul>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <?= form_open_multipart('profile/tambah'); ?>
                                <div class="form-group">
                                    <label>Image Profile</label>
                                    <input type="file" class="dropify" data-max-file-size="1mb" name="image" />
                                    <div class="form-group mt-5">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">User Name</label>
                                        <input type="text" class="form-control" name="user_name" id="user_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email"  required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Password</label>
                                        <input type="password" class="form-control" name="password" id="email" placeholder="change password here" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="newscategory">Role</label>
                                        <select class="js-example-basic-single" name="role" style="width:100%">
                                            <option value="admin" >Admin</option>
                                            <option value="keuangan" >Keuangan</option>
                                            <option value="operator" >Operator</option>
                                            <option value="sales" >Sales</option>
                                            <option value="carcall" >Car Call</option>
                                        </select>
                                    </div>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Create</button>
                                    </div>

                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>