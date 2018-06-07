
<?php include 'core.php'; ?>
<?php include $includes_path.'head.php'; ?>
<?php include $includes_path.'header.php'; ?>
<?php include 'library/model_base.php'; ?>
<?php
if(!empty($_SESSION) && array_key_exists("username", $_SESSION)): 
    $data = Model_Base::query("Select * from manufacturer");
?>
<div class="container">
    <h3>Create model</h3>
    <p></p>
    <form class="form-horizontal">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Model name</label>
      <div class="col-sm-4">
          <input type="text" class="form-control" id="modelName" placeholder="Enter model name">
      </div>
      <div class="col-sm-4">
          <select class="form-control" id="manufacturerName">
              <option value="">Select manufacturer</option>
              <?php foreach ($data as $key => $value) : ?>
              <option value="<?php echo $value->uniquename; ?>"><?php echo $value->manufacturer_name; ?></option>
              <?php endforeach; ?>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Model Image</label>
      <div class="col-sm-4">
          <input type="file" class="form-control locationImg" id="uploadProfileImg" name="uploadProfileImg">
          <img src="<?php echo http_path.'upload/180606.jpg' ?>" id="profileImg" class="locationImgView" width="50" height="50"/>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Color</label>
      <div class="col-sm-4">
          <select class="form-control" id="modelColor">
              <option value="">Select color</option>
              <option value="Blue">Blue</option>
              <option value="Red">Red</option>
              <option value="Black">Black</option>
              <option value="White">White</option>
              <option value="Gold">Gold</option>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Manufacturing year</label>
      <div class="col-sm-4">
          <select class="form-control" id="modelYear">
              <option value="">Select year</option>
              <?php for($y=date("Y"); $y>2010; $y--): ?>
              <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
              <?php endfor; ?>
          </select>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Registration number</label>
      <div class="col-sm-4">
          <input type="text" class="form-control" id="modelRegistrn" placeholder="Enter registration number">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Count</label>
      <div class="col-sm-4">
          <input type="number" class="form-control checkNumber" id="modelQuantity" placeholder="Enter model count">
      </div>
    </div>
    <div class="form-group"> 
      <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default" id="createModel">Create</button>
      </div>
    </div>
    </form>
    <?php include $includes_path.'footer.php'; ?>
    <script src="<?php echo http_path.'js/create.js'; ?>"></script>
    
</div>
<?php else: header("Location:".http_path); ?>
<?php endif; ?>
</body>
</html>

