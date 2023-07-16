<div class="content-wrapper">

    <div class="card">
        <div class="card-body">
<h4 class="card-title">Parameter Margin Shuttle by Route</h4>
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
                                    <th>Route</th>
                                    <th>Margin (%)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($transaksi as $tr) { ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $tr['route'] ?></td>
                                        <td><?= $tr['margin'] ?></td>
                                        <td>                                       
<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#modaledit<?= $tr['id_param'] ?>">Edit Margin</button>

                                            <?php if ($this->session->userdata('role')== 'super admin'){ ?>
                                            <a onclick="return confirm ('Are You Sure?')" href="<?= base_url(); ?>transactionltr/deletemargin/<?= $tr['id_param']; ?>" class="btn btn-outline-danger">Delete</a>
                                            <?php } ?>
                                            
                                            
                                        </td>
                                    </tr>
                                    
                                  <!-- Modal -->
  <div class="modal fade" id="modaledit<?= $tr['id_param'] ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      <?= form_open_multipart('transactionltr/editmargin'); ?>
        <input type="hidden" name="id" value="<?= $tr['id_param'] ?>">
        <div class="modal-header">
          <h4 class="modal-title">Edit Margin Shuttle</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
            <h4 class="modal-title">Route : <span><?= $tr['route'] ?></span></h4>
          <label class="text-small">New Margin (%)</label>
        <input type="text" class="form-control" id="margin" name="margin"  value="<?= $tr['margin'] ?>" >
        </div>
        <div class="modal-footer">

          <button id="publish" type="submit" class="btn btn-success mr-2">Edit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <?= form_close(); ?>
      </div>
      
    </div>
  </div>
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