
<?php 
include 'core.php';
include $includes_path.'head.php'; 
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<?php 
include $includes_path.'header.php';
include 'library/model_base.php';

if(!empty($_SESSION) && array_key_exists("username", $_SESSION)): 
    $data = Model_Base::query("Select * from models");
?>
<div class="container">
    <h3>Models</h3>
    <a href="<?php echo http_path.'create.php' ?>" class="btn btn-primary" role="button">Add new model</a>
    <p></p>
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
		<th>Sr.no</th>
                <th>Model name</th>
                <th>Manufacturer</th>
                <th>Count</th>
                <th>Date added</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
		<th>Sr.no</th>
                <th>Model name</th>
                <th>Manufacturer</th>
                <th>Count</th>
                <th>Date added</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            <?php if(!empty($data)): ?>
            <?php foreach ($data as $key => $value) : ?>
            <tr class="rowClick" data-name="<?php echo $value->uniquename; ?>">
                <td><?php echo count($data)-$key; ?></td>
		<td><?php echo $value->model_name; ?></td>
		<td><?php echo $value->manufacturer; ?></td>
		<td><?php echo $value->count; ?></td>
                <td><?php echo date('d-m-Y',strtotime($value->date_added)); ?></td>
                <td><a href="#" class="modelSold" data-name="<?php echo $value->uniquename; ?>">Sold</a></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="modal fade" id="modelView" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Model Details</h4>
        </div>
        <div class="modal-body">
          <table class="table table-bordered">
              <tbody id="viewModelResult">
              
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
  </div>
</div>
<?php include $includes_path.'footer.php'; ?>
<script>
    $(document).ready(function () {
        $('#example').dataTable();
       
        
        $('#example tr td:not(:last-child)').click(function () {
            var rowName = $(this).closest('tr').data('name');
            if(rowName != ""){
                $.ajax({
                    "url": urlpath + "action/actionGetModel.php",
                    "type": "POST",
                    "async": false,
                    "data": {
                        rowName: rowName
                    },
                    "success": function (data) {
                        var data = JSON.parse(data);
                        if (data.status == "success") {
                            $("#viewModelResult").html("");
                            $("#viewModelResult").html(data.msg);
                            $("#modelView").modal('show');
                        } else {
                            alert(data.msg)
                        }
                    }
                });
            }
        });
        
        $(".modelSold").click(function(e){
            e.preventDefault();
            var check = confirm("Are you sure?");
            if(check){
                var rowName = $(this).data("name");
                if(rowName != ""){
                    $.ajax({
                        "url": urlpath + "action/actionDeleteModel.php",
                        "type": "POST",
                        "async": false,
                        "data": {
                            rowName: rowName
                        },
                        "success": function (data) {
                            var data = JSON.parse(data);
                            if (data.status == "success") {
                                alert(data.msg)
                                window.location.href = urlpath+"models.php";
                            } else {
                                alert(data.msg)
                            }
                        }
                    });
                }
            }
        });
    });
</script>
<?php else: header("Location:".http_path); ?>
<?php endif; ?>
</body>
</html>

