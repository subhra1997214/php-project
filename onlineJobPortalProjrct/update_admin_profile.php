<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Company Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="newcss/update_admin_profile.css">
</head>
<body>
    <?php
        include("admin_navbar.php");
    ?>

    <div class="profile-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Update Company Profile</h1>
            <p>Manage your company profile to attract the best talent</p>
        </div>

        <?php
        if(isset($_POST['email'])) {
            $email = $_POST['email'];
        }
        if($email) {
            $adminDetails = getAdminProfileById($email);

            $data = mysqli_fetch_assoc($adminDetails);
        }
        ?>

        <!-- Form Container -->
        <div class="form-container">
            <form action="" method="POST" enctype="multipart/form-data">
                
                <!-- Company Branding Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-building"></i>
                        Company Branding
                    </h2>
                    
                <div class="upload-grid">

                    <div class="form-group">
                        <label for="company_name">Company Name <span class="required">*</span></label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo $data['companyname']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="company_tagline">Company Tagline</label>
                        <input type="text" id="company_tagline" name="company_tagline" value="<?php echo $data['companytagline']; ?>">
                    </div>

                    <div class="form-group">
                        <input type="hidden" id="companyid" name="companyid" value="<?php echo $data['companyid']; ?>">
                        <label for="company_logo">Company Logo <span class="required">*</span></label>
                        <div class="file-upload">
                            <img src="admin-photo/<?php echo $data['logo']; ?>" alt="Current Logo" style="max-height: 80px; margin-bottom: 10px;">
                            <input type="file" id="company_logo" name="company_logo" class="file-input" accept="image/*">
                            <label for="company_logo" class="file-label">
                                <i class="fas fa-upload"></i>
                                <span class="upload-text">Upload Company Logo</span>
                                <span class="file-selected">File Selected</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_photo">Company Photo</label>
                        <div class="file-upload">
                            <img src="admin-photo/<?php echo $data['photo']; ?>" alt="Current Photo" style="max-height: 80px; margin-bottom: 10px;">
                            <input type="file" id="company_photo" name="company_photo" class="file-input" accept="image/*">
                            <label for="company_photo" class="file-label">
                                <i class="fas fa-camera"></i>
                                <span class="upload-text">Upload Company Photo</span>
                                <span class="file-selected">File Selected</span>
                            </label>
                        </div>
                    </div>
                </div>


                <!-- Contact Information Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-phone"></i>
                        Contact Information
                    </h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone_number">Phone Number <span class="required">*</span></label>
                            <input type="tel" id="phone_number" name="phone_number" value="<?php echo $data['phoneno']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email_address">Email Address <span class="required">*</span></label>
                            <input type="hidden" name="email" value="<?php echo $data['email']; ?>">
                            <input type="email" id="email_address" name="email_address" value="<?php echo $data['email']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Office Address Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Office Address
                    </h2>
                    
                    <div class="form-group">
                        <label for="street_address">Street Address <span class="required">*</span></label>
                        <input type="text" id="street_address" name="street_address" value="<?php echo $data['address']; ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input type="text" id="city" name="city" value="<?php echo $data['city']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="state">State/Province <span class="required">*</span></label>
                            <input type="text" id="state" name="state" value="<?php echo $data['state']; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="zip_code">ZIP/Postal Code <span class="required">*</span></label>
                            <input type="text" id="zip_code" name="zip_code" value="<?php echo $data['pin']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="country">Country <span class="required">*</span></label>
                            <input type="text" id="country" name="country" value="<?php echo $data['country']; ?>">
                        </div>
                    </div>
                </div>

                <!-- Company Description Section -->
                <div class="form-section">
                    <h2 class="section-title">
                        <i class="fas fa-quote-left"></i>
                        Company Description
                    </h2>
                    
                    <div class="form-group">
                        <label for="company_quote">Company Quote</label>
                        <input type="text" id="company_quote" name="company_quote" value="<?php echo $data['quotes']; ?>">
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <button type="submit" name="update" class="update-btn">
                        <i class="fas fa-save"></i>
                        Update Profile
                    </button>
                    <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                        <i class="fas fa-trash-alt"></i>
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
        if(isset($_POST['update'])) {
            $updateDetails = updateAdminProfile($_POST);

            echo "<script>
                    alert('$updateDetails');
                    window.location.href='admin_profile.php?check';
            </script>";
        }
    ?>

    <?php
        if(isset($_POST['delete'])) {
            $email = $_POST['email'];
            $deleteResult = deleteAdminAccount($email);

            if ($deleteResult == 1) {
                echo "<script>
                        alert('Delete Account successful');
                        window.location.href = 'login.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Delete not successful');
                        window.location.href = 'update_admin_profile.php';
                    </script>";
            }
        }
    ?>
</body>
</html>