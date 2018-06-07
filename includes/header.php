<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <?php $path= (empty($_SESSION))?http_path:http_path.'models.php'; ?>
            <a class="navbar-brand" href="<?php echo $path; ?>">Inventory system</a>
        </div>
        <?php if (!empty($_SESSION)): ?>
            <ul class="nav navbar-nav">
                <li><a href="<?php echo http_path; ?>manufacturer.php">Manufacturer</a></li>
                <li><a href="<?php echo http_path; ?>models.php">Models</a></li>
            </ul>
        <?php endif; ?>
        <ul class="nav navbar-nav navbar-right">
            <?php if (empty($_SESSION)): ?>
            <li><a href="<?php echo http_path; ?>"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <?php else: ?>
            <li><a href="<?php echo http_path.'action/actionLogout.php'; ?>"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>