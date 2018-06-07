
<?php 
include 'core.php';
include $includes_path.'head.php'; 
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<?php 
include $includes_path.'header.php';
include 'library/model_base.php';

if(!empty($_SESSION) && array_key_exists("username", $_SESSION)): 
    $data = Model_Base::query("Select * from manufacturer");
?>
<div class="container">
    <h3>Manufacturer</h3>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create New</button>
    <p></p>
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
		<th>Sr.no</th>
                <th>Manufacturer name</th>
                <th>Date added</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
		<th>Sr.no</th>
                <th>Manufacturer name</th>
                <th>Date added</th>
            </tr>
        </tfoot>
        <tbody>
            <?php if(!empty($data)): ?>
            <?php foreach ($data as $key => $value) : ?>
            <tr>
                <td><?php echo count($data)-$key; ?></td>
		<td><?php echo $value->manufacturer_name; ?></td>
                <td><?php echo date('d-m-Y',strtotime($value->date_added)); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create Manufacturer</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="form-group">
              <label class="control-label col-sm-2" for="email"></label>
              <div class="col-sm-6">
                <input type="text" class="form-control" id="manufacturerName" placeholder="Enter Manufacturer name">
              </div>
            </div>

            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default" id="btnCreateManufacturer">Submit</button>
              </div>
            </div>
          </form> 
        </div>
      </div>
      
    </div>
  </div>
</div>
<?php include $includes_path.'footer.php'; ?>
<script src="<?php echo http_path.'js/manufact.js'; ?>"></script>
<?php else: header("Location:".http_path); ?>
<?php endif; ?>
</body>
</html>

