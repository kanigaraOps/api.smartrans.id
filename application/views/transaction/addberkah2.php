<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
// <script>
// $(document).ready(function(){
//   $("#cekDetail").click(function(){
//     var voucher = document.getElementById('voucher').value;
//     $.ajax({
//     type: "POST",
//     url: 'https://api.smartrans.id/cekdetail.php',
//     data: {name: voucher, age: 27},
//     success: function(data){
//         //alert(data);
//         var obj = JSON.parse(data);
//         document.getElementById('kode').value = obj.noshuttle ;
//         document.getElementById('region').value = obj.region ;
//         document.getElementById('aplikator').value = obj.aplikator ;
//         document.getElementById('jenis').value = obj.jenisorder ;
//         document.getElementById('nama').value = obj.name ;
//         document.getElementById('durasi').value = obj.durasi ;
//         document.getElementById('phone').value = obj.phonenumber ;
//         document.getElementById('nd').value = obj.nd ;
//         document.getElementById('qty').value = obj.numcar ;
//         document.getElementById('flight').value = obj.flightno ;
//         document.getElementById('rute').value = obj.route ;
//         document.getElementById('pickuptime').value = obj.dtpickup ;
//         document.getElementById('typecar').value = obj.typecar ;
//         document.getElementById('kode_reg').value = obj.kode_reg ;
//         document.getElementById('jemput').value = obj.pickuploc ;
//         if(obj.jenisorder == 'RENTCAR'){
//             document.getElementById('tujuan').value = obj.typeorder ;
//         } else {
//         document.getElementById('tujuan').value = obj.dropoffloc ;
//         }
//     }
//     });

//   });
//   $("#publish").click(function(){
//     var BASE_URL = "<?php echo base_url();?>";
    
//   var data={
//       "kode": document.getElementById('kode').value ,
//       "region": document.getElementById('region').value,
//       "aplikator":  document.getElementById('aplikator').value ,
//       "jenis":  document.getElementById('jenis').value ,
//       "nama":  document.getElementById('nama').value ,
//       "durasi":  document.getElementById('durasi').value ,
//       "phone":  document.getElementById('phone').value ,
//       "nd":  document.getElementById('nd').value,
//         "qty":  document.getElementById('qty').value,
//         "flight":  document.getElementById('flight').value, 
//         "rute":  document.getElementById('rute').value ,
//         "pickuptime":  document.getElementById('pickuptime').value,
//         "typecar":  document.getElementById('typecar').value ,
//         "region_code":  document.getElementById('kode_reg').value ,
//         "jemput":  document.getElementById('jemput').value ,
//         "tujuan":  document.getElementById('tujuan').value ,}
//         var encoded_data = JSON.stringify(data);
//     $.ajax({
//     type: "POST",
//     url: BASE_URL+'api/driver/addberkah',
//     data: encoded_data,
//     success: function(data){
//         $.ajax({        
//             type : 'POST',
//             url : "https://fcm.googleapis.com/fcm/send",
//             headers : {
//                 Authorization : 'key=' + data.key
//             },
//             contentType : 'application/json',
//             dataType: 'json',
//             data: JSON.stringify({ 'data' : data.data,
//                 'registration_ids' : data.registration_ids}),
//             success : function(response) {
//               alert("terkirim")
//             },
//             error : function(xhr, status, error) {
//                 console.log(xhr.error);                   
//             }
//         });
//     }
//     });

//   });
// });
// </script>
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

                        <h4 class="card-title mb-0"><?php echo $terminal->nama ?></h4>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent"> 

                            <!-- driver info form -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                 <?= form_open_multipart('transaction/terminal'); ?> 
                                <input type="hidden" name="id" class="form-control" id="id" value=<?php echo $terminal->id ?>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Minimum</label>
                                     <input type="number" class="form-control" id="minimum" name="minimum" value=<?php echo $terminal->minimum_wallet_amount ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Fee Company</label>
                                    <input type="number" class="form-control" id="fee_company" name="fee_company" value=<?php echo $terminal->fee_company ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Base Fare</label>
                                    <input type="number" class="form-control" id="base_fare" name="base_fare" value=<?php echo $terminal->base_fare ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Distance</label>
                                    <input type="number" class="form-control" id="distance" name="distance" value=<?php echo $terminal->distance ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Surge</label>
                                    <input type="number" class="form-control" id="surge" name="surge" value=<?php echo $terminal->surge ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Retase</label>
                                    <input type="number" class="form-control" id="retase" name="retase" value=<?php echo $terminal->retase ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Omset</label>
                                    <input type="number" class="form-control" id="omset" name="omset" value=<?php echo $terminal->omset ?>  required>
                                </div>
                                </div>
                                  <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">30KM</label>
                                    <input type="number" class="form-control" id="30KM" name="30KM" value=<?php echo $terminal->KM30 ?>  required>
                                </div>
                                </div>
                                  <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">50KM</label>
                                    <input type="number" class="form-control" id="50KM" name="50KM" value=<?php echo $terminal->KM50 ?>  required>
                                </div>
                                </div>
                                  <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">100KM</label>
                                    <input type="number" class="form-control" id="100KM" name="100KM" value=<?php echo $terminal->KM100?>  required>
                                </div>
                                </div>
                                  <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">150KM</label>
                                    <input type="number" class="form-control" id="150KM" name="150KM" value=<?php echo $terminal->KM150 ?>  required>
                                </div>
                                </div>
                                <div class="row">
                                    <button id="terminal" name="terminal" type="submit" class="btn btn-success mr-2">Submit</button>
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




