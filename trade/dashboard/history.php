<?php
    include("includes/header.php");
    $userid = $row['id'];
    $sqldep = "SELECT * FROM history WHERE client_id = '$userid'";
    $querydep = mysqli_query($conn, $sqldep);
?>
<div class="container-fluid content-inner pb-0">
    <div class="row">
        <div class="bd-example table-responsive">
            <h5 class="text-center p-3">Total Deposit History</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Tranx ID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Coin</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($deposit = mysqli_fetch_assoc($querydep)){ ?>
                    <tr>
                        <th scope="row">#<?php echo $deposit['tranx_id']; ?></th>
                        <td><?php echo $deposit['type']; ?></td>
                        <td><?php echo number_format($deposit['amount'], 2, '.', ','); ?></td>
                        <td><?php echo $deposit['coin']; ?></td>
                        <td><?php echo $deposit['address']; ?></td>
                        <td
                            class='badge rounded-pill <?php if($deposit["status"] == 'completed'){echo "bg-success";}else{echo "bg-danger";} ?>'>
                            <?php echo $deposit['status']; ?></td>
                        <td><?php echo $deposit['created_at']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php
    include("includes/footer.php");
?>