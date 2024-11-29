<?php
    include_once("includes/load.php");
    include_once("layouts/newheader.php");
?><?php $user = current_user(); ?>
<?php
  if(isset($_POST['update'])){

    $req_fields = array('new-password','old-password','id' );
    validate_fields($req_fields);

    if(empty($errors)){

             if(sha1($_POST['old-password']) !== current_user()['password'] ){
               $session->msg('d', "Your old password not match");
               redirect('newPassword.php',false);
             }

            $id = (int)$_POST['id'];
            $new = remove_junk($db->escape(sha1($_POST['new-password'])));
            $sql = "UPDATE users SET password ='{$new}' WHERE id='{$db->escape($id)}'";
            $result = $db->query($sql);
                if($result && $db->affected_rows() === 1):
                  $session->logout();
                  $session->msg('s',"Login with your new password.");
                  redirect('index.php', false);
                else:
                  $session->msg('d',' Sorry failed to updated!');
                  redirect('newPassword.php', false);
                endif;
    } else {
      $session->msg("d", $errors);
      redirect('newPassword.php',false);
    }
  }
?>
<div class="prdctdiv">
    <h3>Change Password</h3>
    <div class="eduser">
    <form method="post" action="newPassword.php">
     <?php echo display_msg($msg); ?>
        <label for="oldPassword" class="control-label">Old Password</label>
        <input type="password" name="old-password" class="form-control" placeholder="Old Password"><br>
        <label for="newPassword">New Password</label>
        <input type="password" name="new-password" class="form-control" placeholder="New Password"><br>
        <input type="hidden" name="id" value="<?php echo (int)$user['id'];?>">
        <button type="submit" name="update">Change</button>
    </form>
    </div>
</div>
        