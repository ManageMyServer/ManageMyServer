ca55fc1b7330e63c8e07419316e41c0e27c3d18c
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = new mysqli($config['db_address'], $config['db_username'], $config['db_password'], $config['db_name']);
        // Check connection
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        $sql = 'UPDATE '.$config['table_prefix'].'_users SET password=?, rank=? WHERE id=?';
        $stmt = $conn->stmt_init();
        if(!$stmt->prepare($sql))
        {
            print "Failed to prepare statement\n";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $hash, $rank, $id);
        $stmt->execute();
        if(empty(mysqli_stmt_error($stmt))){
            header("Refresh:0");
        }
        echo mysqli_stmt_error($stmt);
    } elseif ($_POST['password'] == ''){
        $config = include($_SERVER['DOCUMENT_ROOT'].'/core/config.php');
        $username = $_POST['username'];
        $rank = $_POST['rank'];
        $conn = new mysqli($config['db_address'], $config['db_username'], $config['db_password'], $config['db_name']);
        // Check connection
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        $sql = 'UPDATE '.$config['table_prefix'].'_users SET username=?, rank=? WHERE id=?';
        $stmt = $conn->stmt_init();
        if(!$stmt->prepare($sql))
        {
            print "Failed to prepare statement\n";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $rank, $id);
        $stmt->execute();
        if(empty(mysqli_stmt_error($stmt))){
            header("Refresh:0");
        }
        echo mysqli_stmt_error($stmt);
    } else {
        $config = include($_SERVER['DOCUMENT_ROOT'].'/core/config.php');
        $username = $_POST['username'];
        $password = $_POST['password'];
        $rank = $_POST['rank'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $conn = new mysqli($config['db_address'], $config['db_username'], $config['db_password'], $config['db_name']);
        // Check connection
        if ($conn->connect_error) {
            die('Connection failed: ' . $conn->connect_error);
        }
        $sql = 'UPDATE '.$config['table_prefix'].'_users SET username=?, password=?, rank=? WHERE id=?';
        $stmt = $conn->stmt_init();
        if(!$stmt->prepare($sql))
        {
            print "Failed to prepare statement\n";
        }
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $password, $rank, $id);
        $stmt->execute();
        if(empty(mysqli_stmt_error($stmt))){
            header("Refresh:0");
        }
        echo mysqli_stmt_error($stmt);

    }
}
?>
<div class="container">
    <div class="col-xs-2"></div>
    <div class="col-xs-8 ">
        <div class="text-center">
            <h2>User: <?php echo $results['0']['0']?></h2>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" class="form-control" value="<?php echo $results['0']['0'];?>" />
            </div>
            <div class="form-group">
                <label for="password">Change Password (leave blank if you don't want to change it)</label>
                <input id="password" type="password" name="password" class="form-control"/>
            </div>
            <?php if($results['0']['3'] != 1){echo '<div class="form-group">
                <label for="exampleSelect1">User type</label>
                <select name="rank" class="form-control" id="exampleSelect1" size=1>'; ?>
                    <?php if($_SESSION['rank']=='Superuser'){echo'<option>Superuser</option>';}; ?>
                    <?php echo '<option>Admin</option>'; ?>
                    <?php if($results['0']['3'] != 1){echo '<option>User</option>
                </select>
            </div>';}?>
            <div class="text-center">
                <div class="btn-group text-center" role="group">
                    <input type="submit" name="Submit" class="btn btn-primary" />
                </div>
                <br><br><a href="/admin/users/">Back to Users</a>
            </div>
        </form>
        <?php if($results['0']['3'] != 1){echo '
        <button type="button" class="btn btn-primary btn-danger" data-toggle="modal" data-target="#myModal">
            Delete user
        </button>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Delete User</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete the user?</p>
                    </div>
                    <div class="modal-footer">
                        <button style="float: left" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <form action="" method="post">
                            <input type="submit" name="Delete" class="btn btn-primary" value="Delete" />
                        </form>
                    </div>
                </div>
            </div>
        </div>';}?>
    </div>
    <div class="col-xs-2"></div>
</div>
