<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Company Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="newcss/create_admin_profile.css">
</head>
<body>
    <?php
        include("admin_navbar.php");
    ?>

    <div class="profile-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Create Company Profile</h1>
            <p>Set up your company profile to attract the best talent</p>
        </div>

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
                        <input type="text" id="company_name" name="company_name" placeholder="Your Company Pvt Ltd" required>
                    </div>

                    <div class="form-group">
                        <label for="company_tagline">Company Tagline</label>
                        <input type="text" id="company_tagline" name="company_tagline" placeholder="Building the future, today.">
                    </div>

                    <div class="form-group">
                        <input type="hidden" id="companyid" name="companyid" value="<?php echo $data['email']; ?>">
                        <label for="company_logo">Company Logo <span class="required">*</span></label>
                        <div class="file-upload">
                            <input type="file" id="company_logo" name="company_logo" class="file-input" accept="image/*" required>
                            <label for="company_logo" class="file-label">
                                <i class="fas fa-upload"></i>
                                Upload Company Logo
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company_photo">Company Photo</label>
                        <div class="file-upload">
                            <input type="file" id="company_photo" name="company_photo" class="file-input" accept="image/*">
                            <label for="company_photo" class="file-label">
                                <i class="fas fa-camera"></i>
                                Upload Company Photo
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
                            <input type="tel" id="phone_number" name="phone_number" placeholder="+91 (555) 123-4567" required>
                        </div>

                        <div class="form-group">
                            <label for="companyid">Email Address <span class="required">*</span></label>
                            <input type="email" id="companyid" name="companyid" value="<?php echo $data['email']; ?>"  readonly>
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
                        <input type="text" id="street_address" name="street_address" placeholder="123 Business Street" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City <span class="required">*</span></label>
                            <input type="text" id="city" name="city" placeholder="New York" required>
                        </div>

                        <div class="form-group">
                            <label for="state">State/Province <span class="required">*</span></label>
                            <input type="text" id="state" name="state" placeholder="NY" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="zip_code">ZIP/Postal Code <span class="required">*</span></label>
                            <input type="text" id="zip_code" name="zip_code" placeholder="10001" required>
                        </div>

                        <div class="form-group">
                            <label for="country">Country <span class="required">*</span></label>
                            <input type="text" id="country" name="country" placeholder="United States" required>
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
                        <input type="text" id="company_quote" name="company_quote" placeholder="Innovation starts here...">
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="submit-section">
                    <button type="submit" name="submit" class="submit-btn">
                        <i class="fas fa-save"></i>
                        Create Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php
        if(isset($_POST['submit'])) {

            $profileDetails = uploadAdminProfileDetails($_POST);

            echo "
                <script>
                    alert('$profileDetails');
                    window.location.href = 'admin_profile.php?check';
                </script>
            ";
        }
    ?>
</body>
</html>