<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-8 side-right stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?> 
                            <?php echo $this->session->flashdata('hapus'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">ADD HARGA</h4>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent"> 

                            <!-- driver info form -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                 <?= form_open_multipart('area/addpricetravelin'); ?> 
                                <input type="hidden" name="id" class="form-control" id="id" value=<?= $id??" " ?>  >
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Nama</label>
                                     <input type="text" class="form-control" id="nama" name="nama" required value=<?= $nama??" " ?>  >
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Wilayah</label>
                                    <input type="text" class="form-control" id="wilayah" name="wilayah" required value=<?= $wilayah??" "?>  >
                                </div>
                                </div>
                                
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Harga</label>
                                    <input type="text" class="form-control" id="harga" name="harga" required value=<?= $harga??" "?>  >
                                </div>
                                </div>
                                <div class="row">
                                <?php if(isset($id))  {
                                 echo   '<button id="update" name="update" type="submit" class="btn btn-success mr-2">Update</button>';
                                }else{ 
                                echo  '<button id="add" name="add" type="submit" class="btn btn-success mr-2">Submit</button>';} ?>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                
                                
                                    
                                     <?= form_close(); ?> 
                            </div>
                                <!-- tab content ends -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->




