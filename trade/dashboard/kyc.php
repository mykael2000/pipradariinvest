<?php
  include("includes/header.php");
  
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$message ="";

if(isset($_POST['proceed'])){
    // Process other form fields
    $client_id = $row['id'];
    $email = $row['email'];
    $fullname = $_POST['fullname'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $govIDType = $_POST['gov_id_type']; // This should be sanitized and validated
    $govIDFileName = $_FILES['gov_id_file']['name']; // File name of government ID
    $proofAddressFileName = $_FILES['proof_address_file']['name']; // File name of proof of address

    // Check if the files were uploaded successfully
    if ($_FILES['gov_id_file']['error'] == 0 && $_FILES['proof_address_file']['error'] == 0) {
        // Define the directory where uploaded files will be stored
        $targetDir = "kyc/";

        // Generate unique file names for uploaded files to avoid overwriting
        $govIDFileTarget = $targetDir . uniqid() . '_' . $govIDFileName;
        $proofAddressFileTarget = $targetDir . uniqid() . '_' . $proofAddressFileName;

        // Move the uploaded files to the target directory
        if (move_uploaded_file($_FILES['gov_id_file']['tmp_name'], $govIDFileTarget) &&
            move_uploaded_file($_FILES['proof_address_file']['tmp_name'], $proofAddressFileTarget)) {
            // Files were successfully uploaded

            // Insert the form data and file paths into the database
            $kycsql = "INSERT INTO user_kyc (client_id, email, fullname, dob, address, phone, gov_id_type, gov_id_file, proof_address_file)
                    VALUES ('$client_id', '$email', '$fullname', '$dob', '$address',' $phone', '$govIDType', '$govIDFileTarget', '$proofAddressFileTarget')";
            $kyquery = mysqli_query($conn, $kycsql);

            if ($kyquery) {
                // Data and files were inserted successfully
                $message =  '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>KYC information submitted successfully!</div>
        </div>';
            } else {
                // Handle the database insertion error
                $message =  '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Error inserting data: ' . $stmt->error.'</div>
        </div>';
            }
        } else {
            // Handle file upload errors
            $message =  '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Error uploading files.</div>
        </div>';
        }
    } else {
        // Handle file upload errors
        $message =  '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Error uploading files.</div>
        </div>';
    }
}

?>
<div class="container-fluid content-inner pb-0">
    <div>
        <div class="row">

            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">KYC Verification</h4><button
                                class="badge rounded-pill <?php if($row['account_status'] == 'verified'){echo 'bg-success';}else{echo 'bg-danger';} ?>"><?php echo $row['account_status']; ?></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php echo $message; ?>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="fname">Fullname:</label>
                                        <input type="text" class="form-control" name="fullname" id="fname"
                                            placeholder="Enter Fullname" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="lname">Date of Birth:</label>
                                        <input type="date" class="form-control" name="dob" id="lname"
                                            placeholder="Enter DOB" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="add1">House Address:</label>
                                        <input type="text" name="address" class="form-control" id="add1"
                                            placeholder="Enter House Address" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="mobno">Phone Number:</label>
                                        <input type="text" name="phone" class="form-control" id="mobno"
                                            placeholder="Phone Number" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="email">Goverment Issued ID:</label>
                                        <select name="gov_id_type" class="form-control">
                                            <option value="">-- select --</option>
                                            <option value="drivers_license">Driver's License</option>
                                            <option value="passport">International Passport</option>
                                            <option value="national_id">National ID</option>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="id">Upload Government Issued ID:</label>
                                        <input type="file" class="form-control" name="gov_id_file" id="id" />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="pro">Upload Proof of Address:</label>
                                        <input type="file" class="form-control" name="proof_address_file" id="pro" />
                                    </div>
                                </div>


                                <button name="proceed" type="submit" class="btn btn-primary">
                                    Proceed
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
  include("includes/footer.php");
?>