
<?php include 'core.php'; ?>
<?php include $includes_path.'head.php'; ?>
<?php include $includes_path.'header.php'; ?>
<?php //print_r($_SESSION); exit(); ?>
<?php if(empty($_SESSION)):  ?>
<div class="container">
  <h2>Welcome</h2>
    <form class="form-horizontal">
      <div class="form-group">
        <label class="control-label col-sm-2" for="email">Email:</label>
        <div class="col-sm-6">
          <input type="email" class="form-control" id="email" placeholder="Enter email">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="pwd">Password:</label>
        <div class="col-sm-6"> 
          <input type="password" class="form-control" id="pwd" placeholder="Enter password">
        </div>
      </div>

      <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" id="btnLoginUser">Submit</button>
        </div>
      </div>
    </form>
</div>
<?php include $includes_path.'footer.php'; ?>
<script src="<?php echo http_path.'js/index.js'; ?>"></script>

<?php else: header("Location:".http_path.'models.php'); ?>
<?php endif; ?>
</body>
</html>