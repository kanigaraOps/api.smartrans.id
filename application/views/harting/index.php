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
<?php $i = 1; ?>
<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-lg-8 side-left align-items-stretch">
             <div class="card">
                 <div class="card-body"> 
                 <!--<h4 class="card-title mb-0">Distance Aktif = <?= $terminal['distance'] / 100 ?> |  Surge Aktif = <?= $terminal['surge'] / 100 ?></h4>-->
                 </div>
                <div class="card-body">
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">Table</h4>
                    </div>
                             <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Terminal</th>
                                    <th>Nama</th>
                                    <th>Fitur</th>
                                    <th>Nominal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                foreach ($transaksi as $tr) { 
                                $terminal = str_replace(" ", "",$tr['terminal']);
                                ?>

                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $tr['terminal'] ?></td>
                                        <td><?= $tr['nama'] ?></td>
                                        <td><?= $tr['id_harting']=="1"?"Distance":"Surcharge" ?></td>
                                        <td><?= $tr['nominal'] ?></td>
                                        <td><?= $tr['waktu'] ;?></td>
                                        <td><?php if($tr['status'] == 1){ ?>
                                            <label class="badge badge-success">Aktif </label>
                                            <?php }  ?>
                                        <td>
                                            <?php if($tr['manual'] == 1){ ?>
                                            <a href="<?= base_url(); ?>harting/manual/<?php echo $terminal; ?>/<?= $tr['id_harting'] ?>/0/<?= $tr['id'] ?>">
                                            <label class="badge badge-success">Manual</label>
                                            </a>
                                            <?php } else { ?>
                                            <a href="<?= base_url(); ?>harting/manual/<?php echo $terminal; ?>/<?= $tr['id_harting'] ?>/1/<?= $tr['id'] ?>">
                                            <label class="badge badge-dark"> Manual</label>
                                            </a>
                                            <?php } ?>
                                            <a href="<?= base_url(); ?>harting/delete/<?= $tr['id'] ?>">
                                            <label class="badge badge-danger">Delete</label>
                                            </a>
                                        </td>
                                         
                                         </tr>
                                         <?php } ?>
                            </tbody>
                      
                        </table>
                    </div> 
                            
                        </div>
                    </div>
        </div>
        <div class="col-lg-4 side-right stretch-card">
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

                        <h4 class="card-title mb-0">Harting</h4>
                    </div>
                    <div class="wrapper">
                        <hr>
                                 <?= form_open_multipart('harting/add_harting'); ?> 
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Nama</label>
                                     <input type="text" class="form-control" id="nama" name="nama"   required>
                                </div>
                                </div>
                                <div class="row">
                                    <div class=" form-group col-4">
                                    <label class="text-small">Nominal</label>
                                     <input type="number" class="form-control" id="nominal" name="nominal"   required>
                                </div>
                                </div>
                                  <div class="row">
                                    <div class=" form-group col-4">
                                <label for="tgl_lahir">Jam</label>
                                <input type="time" class="form-control" id="jam" name="jam" placeholder="jam" required>
                            </div>
                                </div>
                                 <div class="row">
                                     <div class=" form-group col-4">
                                <label for="fitur">Services</label>
                                <br>
                                <select class="js-example-basic-single" id="fitur" name="fitur" style="width:100%" required>
                                    <option value="1">Distance</option>
                                    <option value="2">Surcharge</option>
                                </select>
                            </div>
                            </div>
                            <div class="row">
                                     <div class=" form-group col-4">
                                <label for="fitur">Terminal</label>
                                <br>
                                <select class="js-example-basic-single" id="terminal" name="terminal" style="width:100%" required>
                                    <option value="Terminal 2D">Terminal 2D</option>
                                    <option value="Terminal 2E">Terminal 2E</option>
                                    <option value="Terminal 2F">Terminal 2F</option>
                                    <option value="Terminal 3">Terminal 3</option>
                                </select>
                            </div>
                            </div>
                                <div class="row">
                                    <button id="submit" name="submit" type="submit" class="btn btn-success mr-2">Submit</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </div>
                                
                                
                                    
                                     <?= form_close(); ?> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- content-wrapper ends -->




