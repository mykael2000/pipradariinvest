<?php
  include("includes/header.php");
  
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$message = $passmessage ="";
// Step 2: Retrieve the form data
if (isset($_POST['save'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $zip = $_POST['zip'];


    // Step 3: Validate and sanitize input (You should add more validation)
    $firstname = mysqli_real_escape_string($conn, $firstname);
    $lastname = mysqli_real_escape_string($conn, $lastname);
    $address = mysqli_real_escape_string($conn, $address);
    $country = mysqli_real_escape_string($conn, $country);
    $phone = mysqli_real_escape_string($conn, $phone);
    $email = mysqli_real_escape_string($conn, $email);
    $city = mysqli_real_escape_string($conn, $city);
    
        // Step 4: Create SQL query for update
            $sql = "UPDATE users 
                    SET firstname='$firstname', lastname='$lastname', address='$address', 
                        country='$country', phone='$phone', city='$city', zip='$zip'
                    WHERE id='$user_id'";
            
    // Step 5: Execute SQL query
    if ($conn->query($sql) === TRUE) {
        header("Location:profile.php?m=yes");
        
    } else {
        header("Location:profile.php?m=no");
        
    }

    // Step 6: Close the database connection
    $conn->close();
}
if(!empty($_GET['m'])){
    if($_GET['m'] == "yes"){
    $message =  '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>User information inserted successfully.</div>
        </div>';
}elseif($_GET['m'] == "no"){
    $message = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Error: ' . $sql . '<br>' . $conn->error.'</div>
        </div>';
}elseif($_GET['m'] == "empty"){
    $passmessage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Please fill in the form</div>
        </div>';
}elseif($_GET['m'] == "inc"){
    $passmessage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Incorrect password</div>
        </div>';
}elseif($_GET['m'] == "match"){
    $passmessage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Passwords do not match</div>
        </div>';
}
}




if (isset($_POST['pass_save'])) {
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['newpassword'];
    $confirmNewPassword = $_POST['confirmpassword'];
    
    // Validate input (you can add more validation)
    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        // Handle empty fields
        
        header("Location:profile.php?m=empty");
       
    }

    // Check if the current password is correct (you need to implement this)
    if (!checkCurrentPassword($_SESSION['user_id'], $currentPassword)) {
        // Handle incorrect current password
        header("Location:profile.php?m=inc");
    }

    // Check if the new password matches the confirmation
    if ($newPassword !== $confirmNewPassword) {
        // Handle password mismatch
        header("Location:profile.php?m=match");
    }

    // Hash the new password before storing it in the database (you should use password_hash())
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database (you need to implement this)
    if (updatePassword($_SESSION['user_id'], $hashedPassword)) {
        // Password updated successfully
        $passmessage =  '<div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Password updated successfully.</div>
        </div>';
    } else {
        // Handle database update error
        $passmessage = '<div class="alert alert-danger d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>Error updating password. Please try again later.</div>
        </div>';
    }
}

// Function to check the current password (you need to implement this)
function checkCurrentPassword($user_id, $currentPassword) {
    global $conn; // Assuming $conn is your database connection

    // Retrieve the hashed password for the user with the given $userId
    $sql = "SELECT password FROM users WHERE id = ? ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify if the current password matches the stored hashed password
    if (password_verify($currentPassword, $hashedPassword)) {
        return true; // Current password is correct
    } else {
        return false; // Current password is incorrect
    }
}


// Function to update the password in the database (you need to implement this)
function updatePassword($userId, $hashedPassword) {
    global $conn; // Assuming $conn is your database connection

    // Update the password in the database for the user with the given $userId
    $sql = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $userId);

    if ($stmt->execute()) {
        return true; // Password updated successfully
    } else {
        return false; // Error updating password
    }
}




if (isset($_POST['update_profile_pic'])) {
    // Check if a file was uploaded successfully
    if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_pic'];
        $user_id = $_SESSION['user_id']; // Get the user's ID from the session

        // Specify the directory where you want to store uploaded profile pictures
        $upload_dir = 'uploads/';

        // Generate a unique file name for the uploaded picture (you can customize this logic)
        $file_name = uniqid() . '_' . basename($file['name']);

        // Full path to the uploaded file
        $target_file = $upload_dir . $file_name;

        // Check if the uploaded file is an image (you can add more file type checks)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($imageFileType, $allowed_extensions)) {
            echo "Invalid file format. Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }

        // Check the file size (you can customize the maximum file size)
        $max_file_size = 5 * 1024 * 1024; // 5 MB
        if ($file['size'] > $max_file_size) {
            echo "File size exceeds the maximum allowed size (5MB).";
            exit();
        }

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Update the user's profile picture in the database
            if (updateProfilePicture($user_id, $target_file)) {
                // Profile picture updated successfully
                echo "Profile picture updated successfully.";
            } else {
                // Handle database update error
                echo "Error updating profile picture. Please try again later.";
            }
        } else {
            // Handle file upload error
            echo "Error uploading file. Please try again later.";
        }
    } else {
        // Handle file upload error
        echo "Error uploading file. Please try again later.";
    }
}

// Function to update the user's profile picture in the database (you need to implement this)
function updateProfilePicture($userId, $filePath) {
    global $conn; // Assuming $conn is your database connection

    // Update the profile_picture column in the users table
    $sql = "UPDATE users SET profilePic = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $filePath, $userId);

    if ($stmt->execute()) {
        return true; // Profile picture updated successfully
    } else {
        return false; // Error updating profile picture
    }
}

?>
<div class="container-fluid content-inner pb-0">
    <div>
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit your profile</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="profile-img-edit position-relative">
                                    <img id="imagePreview" class="img-fluid avatar avatar-100 avatar-rounded"
                                        src="<?php if(empty($row['profilePic'])){echo 'assets/images/avatars/01.png';}else{echo $row['profilePic'];} ?>"
                                        alt="profile-pic" />
                                    <div class="upload-icone bg-primary">
                                        <svg class="upload-button" width="14" height="14" viewBox="0 0 24 24">
                                            <path fill="#ffffff"
                                                d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                        </svg>
                                        <input class="file-upload" name="profile_pic" id="imageInput" type="file"
                                            accept="image/*" />
                                    </div>
                                </div>
                                <div class="img-extension mt-3">
                                    <div class="d-inline-block align-items-center">
                                        <span>Only</span>
                                        <a href="javascript:void();">.jpg</a>
                                        <a href="javascript:void();">.png</a>
                                        <a href="javascript:void();">.jpeg</a>
                                        <span>allowed</span>
                                    </div>
                                </div>
                            </div>
                            <button name="update_profile_pic" type="submit" class="btn btn-primary">save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit User Information</h4><button
                                class="badge rounded-pill <?php if($row['account_status'] == 'verified'){echo 'bg-success';}else{echo 'bg-danger';} ?>"><?php echo $row['account_status']; ?></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <form action="" method="post">
                                <?php echo $message; ?>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="fname">First Name:</label>
                                        <input type="text" class="form-control" name="firstname"
                                            value="<?php echo $row['firstname']; ?>" id="fname"
                                            placeholder="First Name" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="lname">Last Name:</label>
                                        <input type="text" class="form-control" name="lastname"
                                            value="<?php echo $row['lastname']; ?>" id="lname"
                                            placeholder="Last Name" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="add1">House Address</label>
                                        <input type="text" name="address" value="<?php echo $row['address']; ?>"
                                            class="form-control" id="add1" placeholder="Street Address 1" />
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Country:</label>
                                        <select name="country" class="selectpicker form-control" data-style="py-0">
                                            <option value="<?php echo $row['country']; ?>">
                                                <?php if(empty($row['country'])){echo "Select Country";}else{echo $row['country'];} ?>
                                            </option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Brunei">Brunei</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Cape Verde">Cape Verde</option>
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo (Brazzaville)">Congo (Brazzaville)</option>
                                            <option value="Congo (Kinshasa)">Congo (Kinshasa)</option>
                                            <option value="Costa Rica">Costa Rica</option>
                                            <option value="Cote d'Ivoire">Cote d'Ivoire</option>
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="East Timor (Timor Timur)">East Timor (Timor Timur)</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia, The">Gambia, The</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <option value="Greece">Greece</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guatemala">Guatemala</option>
                                            <option value="Guinea">Guinea</option>
                                            <option value="Guinea-Bissau">Guinea-Bissau</option>
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Iran</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="Korea, North">Korea, North</option>
                                            <option value="Korea, South">Korea, South</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <option value="Laos">Laos</option>
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libya">Libya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <option value="Macedonia">Macedonia</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <option value="Marshall Islands">Marshall Islands</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <option value="Mexico">Mexico</option>
                                            <option value="Micronesia">Micronesia</option>
                                            <option value="Moldova">Moldova</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau">Palau</option>
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Philippines">Philippines</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Qatar">Qatar</option>
                                            <option value="Romania">Romania</option>
                                            <option value="Russia">Russia</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                            <option value="Saint Lucia">Saint Lucia</option>
                                            <option value="Saint Vincent">Saint Vincent and The Grenadines</option>
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <option value="Singapore">Singapore</option>
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <option value="Solomon Islands">Solomon Islands</option>
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <option value="Swaziland">Swaziland</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syria</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Thailand</option>
                                            <option value="Togo">Togo</option>
                                            <option value="Tonga">Tonga</option>
                                            <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Vatican City">Vatican City</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="mobno">Phone Number:</label>
                                        <input type="text" name="phone" value="<?php echo $row['phone']; ?>"
                                            class="form-control" id="mobno" placeholder="Phone Number" />
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="email">Email:</label>
                                        <input type="email" name="email" value="<?php echo $row['email']; ?>"
                                            class="form-control" id="email" placeholder="Email" readonly />
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="city">Town/City:</label>
                                        <input type="text" class="form-control" name="city"
                                            value="<?php echo $row['city']; ?>" id="city" placeholder="Town/City" />
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="form-label" for="city">Zip code:</label>
                                        <input type="text" class="form-control" name="zip"
                                            value="<?php echo $row['zip']; ?>" id="zip" placeholder="Zip/postal code" />
                                    </div>
                                </div>


                                <button name="save" type="submit" class="btn btn-primary">
                                    save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h6 class="card-title">Account Verification</h6>
                            <span>Verify your account to access all platform features</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <div class="bd-example table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">Unverified</th>
                                            <th scope="col">Verified</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Withdrawals limit per day</th>
                                            <td>20,000 <?php echo $row['currency']; ?> (or equal)</td>
                                            <td>Unlimited</td>

                                        </tr>
                                        <tr>
                                            <th scope="row">KYC Bonus</th>
                                            <td>-</td>
                                            <td>10 <?php echo $row['currency']; ?></td>

                                        </tr>
                                        <tr>
                                            <th scope="row"></th>
                                            <td></td>
                                            <td><a href="kyc.php" class="btn btn-sm btn-info">Verify</a></td>

                                        </tr>
                                    </tbody>

                                </table>
                                <span style="font-size: 12px;">Usually, KYC verification takes no more than 2 minutes.
                                    For more information
                                    about our KYC and AML Policy please message our support</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Edit Security</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="new-user-info">
                            <form action="" method="post">
                                <?php echo $passmessage; ?>

                                <h5 class="mb-3">Security</h5>
                                <div class="row">

                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="pass">Current Password:</label>
                                        <input type="password" name="password" class="form-control" id="pass"
                                            placeholder="Enter old password" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="pass">New Password:</label>
                                        <input type="password" name="newpassword" class="form-control" id="newpass"
                                            placeholder="Enter new password" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label" for="rpass">Repeat new Password:</label>
                                        <input type="password" name="confirmpassword" class="form-control" id="rpass"
                                            placeholder="Repeat Password " />
                                    </div>
                                </div>

                                <button name="pass_save" type="submit" class="btn btn-primary">
                                    save
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
// Function to preview the selected image
function previewImage() {
    var input = document.getElementById('imageInput');
    var preview = document.getElementById('imagePreview');

    // Check if a file is selected
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Display the image
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.style.display = 'none'; // Hide the image if no file is selected
    }
}

// Attach the 'previewImage' function to the 'change' event of the file input
document.getElementById('imageInput').addEventListener('change', previewImage);
</script>
<?php
  include("includes/footer.php");
?>