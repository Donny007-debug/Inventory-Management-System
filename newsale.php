<?php
    include_once("includes/load.php");
    include_once("layouts/newheader.php");
?>
<?php

if(isset($_POST['add_sale'])){
  $req_fields = array('s_id','quantity','total', 'date' );
  validate_fields($req_fields);
      if(empty($errors)){
        $p_id      = $db->escape((int)$_POST['s_id']);
        $s_qty     = $db->escape((int)$_POST['quantity']);
        $s_total   = $db->escape($_POST['total']);
        $date      = $db->escape($_POST['date']);
        $s_date    = make_date();

        $sql  = "INSERT INTO sales (";
        $sql .= " product_id,qty,price,date";
        $sql .= ") VALUES (";
        $sql .= "'{$p_id}','{$s_qty}','{$s_total}','{$s_date}'";
        $sql .= ") ";

              if($db->query($sql)){
                update_product_qty($s_qty,$p_id);
                $session->msg('s',"Sale added. ");
                redirect('newsale.php', false);
              } else {
                $session->msg('d',' Sorry failed to add!');
                redirect('prdct.php', false);
              }
      } else {
         $session->msg("d", $errors);
         redirect('prdct.php',false);
      }
}

?>
<div class="prdctdiv">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <button type="submit"> Find It</button>
        <input type="text" id="sug_input" name="title" class="form-control" placeholder="Search for product name">
        <div id="result" class="list-group"></div>
    </form>
    <form method="post" action="newsale.php">
        <table>
            <thead>
            <th> Item </th>
            <th> Price </th>
            <th> Qty </th>
            <th> Total </th>
            <th> Date</th>
            <th> Action</th>
            </thead>
            <tbody  id="product_info"> </tbody>
        </table>
    </form>
</div>
<?php include_once('layouts/newfooter.php');