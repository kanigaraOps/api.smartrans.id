<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
// document.getElementById('notescek').display = "block";
</script>
<script>
$(document).ready(function(){
  $("#cekDetail").click(function(){
    var voucher = document.getElementById('voucher').value;
    $.ajax({
    type: "POST",
    url: 'https://api.smartrans.id/cekdetail.php',
    data: {name: voucher, age: 27},
    success: function(data){
        //alert(data);
        var obj = JSON.parse(data);
        document.getElementById('kode').value = obj.noshuttle ;
        document.getElementById('region').value = obj.region ;
        document.getElementById('aplikator').value = obj.aplikator ;
        document.getElementById('fleet').value = obj.fleet ;
        document.getElementById('jenis').value = obj.jenisorder ;
        document.getElementById('nama').value = obj.name ;
        document.getElementById('durasi').value = obj.durasi ;
        document.getElementById('phone').value = obj.phonenumber ;
        document.getElementById('email').value = obj.email ;
        document.getElementById('reporting').value = obj.reporting ;
        document.getElementById('nd').value = obj.nd ;
        document.getElementById('qty').value = obj.numcar ;
        document.getElementById('flight').value = obj.flightno ;
        document.getElementById('rute').value = obj.route ;
        document.getElementById('pickuptime').value = obj.dtpickup ;
        document.getElementById('typecar').value = obj.typecar ;
        document.getElementById('kode_reg').value = obj.kode_reg ;
        document.getElementById('jemput').value = obj.pickuploc ;
        document.getElementById('tujuan').value = obj.dropoffloc ;
        if(obj.jenisorder == 'RENTCAR'){
            document.getElementById('addons').value = obj.typeorder ;
            // document.getElementById('txtreport').innerHTML = "Pembelian Tambahan" ;
        } else {
            document.getElementById('reporting').value = obj.reporting ;
            // document.getElementById('txtreport').innerHTML = "Reporting" ;
        }
        if(!obj.reporting && obj.jenisorder == 'SHUTTLE' && obj.aplikator == 'TRAVELOKA'){
            document.getElementById('notescek').innerHTML= "Upload File Reporting terbaru..!!" + obj.reporting ;
            document.getElementById("notescek").classList.remove('d-none');
            document.getElementById("button").classList.add('d-none');
        } else {
            document.getElementById("notescek").classList.add('d-none');
            document.getElementById("button").classList.remove('d-none');
        }
    }
    });

  });
  $("#publish").click(function(){
    var BASE_URL = "<?php echo base_url();?>";
    
   var data={
       "kode": document.getElementById('kode').value ,
       "region": document.getElementById('region').value,
       "aplikator":  document.getElementById('aplikator').value ,
       "fleet":  document.getElementById('fleet').value ,
       "jenis":  document.getElementById('jenis').value ,
       "nama":  document.getElementById('nama').value ,
       "durasi":  document.getElementById('durasi').value ,
       "phone":  document.getElementById('phone').value ,
       "email":  document.getElementById('email').value ,
       "reporting":  document.getElementById('reporting').value,
       "nd":  document.getElementById('nd').value,
        "qty":  document.getElementById('qty').value,
        "flight":  document.getElementById('flight').value, 
        "rute":  document.getElementById('rute').value ,
        "pickuptime":  document.getElementById('pickuptime').value,
        "typecar":  document.getElementById('typecar').value ,
        "region_code":  document.getElementById('kode_reg').value ,
        "jemput":  document.getElementById('jemput').value ,
        "tujuan":  document.getElementById('tujuan').value ,
       "addons":  document.getElementById('addons').value ,
   }
        var encoded_data = JSON.stringify(data);
    $.ajax({
    type: "POST",
    url: BASE_URL+'api/berkah/addberkah',
    data: encoded_data,
        /*success: function(data){
            $.ajax({        
                type : 'POST',
                url : "https://fcm.googleapis.com/fcm/send",
                headers : {
                    Authorization : 'key=' + data.key
                },
                contentType : 'application/json',
                dataType: 'json',
                data: JSON.stringify({ 'data' : data.data,
                    'registration_ids' : data.registration_ids}),
                success : function(response) {
                   alert("terkirim")
                },
                error : function(xhr, status, error) {
                    console.log(xhr.error);                   
                }
            });
        }*/
    });
window.location.href = "https://api.smartrans.id/root/transaction/addberkah"; 
  });
});
</script>

<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-4 side-left align-items-stretch">
            
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                            <div class="row">
                                <h4 class="col-auto mr-auto card-title"><span></span>Voucher Berkah</h4>
                                <a class="col-auto btn btn-danger text-white" href="<?= base_url(); ?>driver">
                                    <i class="mdi mdi-keyboard-backspace text-white"></i>Back</a>
                            </div>
                            <br>
                            <div class="row">
                                <textarea id="voucher" name="voucher" rows="32" class="form-control"  required></textarea>
                            </div>
                            <br>
                            <div class="row">
                                <button id="cekDetail" class="btn btn-success mr-2">Cek Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body avatar">
                                <!-- Display status message -->
                                    <?php if(!empty($success_msg)){ ?>
                                    <div class="col-xs-12">
                                        <div class="alert alert-success"><?php echo $success_msg; ?></div>
                                    </div>
                                    <?php }
                                    if(!empty($error_msg)){ ?>
                                    <div class="col-xs-12">
                                        <div class="alert alert-danger"><?php echo $error_msg; ?></div>
                                    </div>
                                    <?php } ?>

                            <div class="row">
                                <h4 class="col-auto mr-auto card-title"><span></span>Upload Reporting Terbaru</h4>
                            </div>
                            <br>

                            <div class="row">
                                <form action="<?php echo base_url('transaction/import'); ?>" method="post" enctype="multipart/form-data">
                                    <input type="file" name="file" />
                                    <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                                </form>

                            </div>
                            <br>
                            <div class="row">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        
                        <div class="col-xs-12">
                                        <div id="notescek" class="alert alert-danger d-none" ></div>
                                    </div>

                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">Detail Voucher</h4>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent"> 

                            <!-- driver info form -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                
                                <input type="hidden" name="id" >
                                <div class="row">
                                    <div class=" form-group col-3">
                                    <label class="text-small">KODE VOUCHER</label>
                                    <input type="text" class="form-control" id="kode" name="kode"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">JENIS ORDER</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">APLIKATOR</label>
                                    <input type="text" class="form-control" id="aplikator" name="aplikator"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">FLEET</label>
                                    <input type="text" class="form-control" id="fleet" name="fleet"  required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-3">
                                    <label class="text-small">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">Handphone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"  required>
                                    </div>
                                    <div class=" form-group col-1">
                                    <label class="text-small">Area</label>
                                    <input type="text" class="form-control" id="region" name="region"  required>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Kode Reg</label>
                                    <input type="text" class="form-control" id="kode_reg" name="kode_reg"  required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Tanggal dan Jam</label>
                                    <input type="text" class="form-control" id="pickuptime" name="pickuptime"  required>
                                    </div>
                                    <div class=" form-group col-4">
                                    <label class="text-small">Tipe Mobil</label>
                                    <input type="text" class="form-control" id="typecar" name="typecar"  required>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Qty</label>
                                    <input type="text" class="form-control" id="qty" name="qty"  required>
                                    </div>
                                    <div class=" form-group col-2">
                                    <label class="text-small">Durasi</label>
                                    <input type="text" class="form-control" id="durasi" name="durasi"  required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class=" form-group col-2">
                                    <label class="text-small">Flight No</label>
                                    <input type="text" class="form-control" id="flight" name="flight"  required>
                                    </div>
                                    <div class=" form-group col-4">
                                    <label class="text-small">Rute</label>
                                    <input type="text" class="form-control" id="rute" name="rute"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label id='txtreport' class="text-small">Reporting</label>
                                    <input type="text" class="form-control" id="reporting" name="reporting"  required>
                                    </div>
                                    <div class=" form-group col-3">
                                    <label class="text-small">Nett Driver</label>
                                    <input type="text" class="form-control" id="nd" name="nd"  required>
                                    </div>
                                </div> 

                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Jemput</label>
                                    <textarea id="jemput" name="jemput" rows="6" class="form-control" required></textarea>
                                    </div>
                                    <div class=" form-group col-4">
                                    <label class="text-small">Tujuan</label> 
                                    <textarea id="tujuan" name="tujuan" rows="6" class="form-control" required></textarea>
                                    </div>
                                    <div class=" form-group col-4">
                                    <label class="text-small">Addons</label> 
                                    <textarea id="addons" name="addons" rows="6" class="form-control" ></textarea>
                                    </div>
                                </div>
                                <div id='button' class="d-none">
                                    <button id="publish" type="submit" class="btn btn-success mr-2">Uploads</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                    
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
    





