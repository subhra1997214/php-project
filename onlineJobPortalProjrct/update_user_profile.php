<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Your Profile</title>
    <link rel="stylesheet" href="newcss/update_user_profile.css">
</head>
<body>

    <?php
        include("user_navbar.php");
    ?>

    <?php
        if(isset($_GET['edit'])) {
            $email = $_SESSION['email'];

            $userProfileDetails = getUserProfileByID($email);

            $data = mysqli_fetch_assoc($userProfileDetails);

        }
    ?>

    <div class="container">
        <div class="form-container">
            <h1 class="page-title">Update Your Profile</h1>
            <p class="page-subtitle">Manage your professional presence and showcase your expertise</p>

            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Personal Information -->
                <div class="section">
                    <h2 class="section-title">Personal Information</h2>
                    
                    <div class="form-group">
                        <label for="fullName">Full Name <span class="required">*</span></label>
                        <input type="text" id="fullName" name="fullName" value="<?php echo $data['fullname'] ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" min="18" max="100" value="<?php echo $data['age'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male" <?php if($data['gender'] == 'male') echo 'selected'; ?>>Male</option>
                                <option value="female" <?php if($data['gender'] == 'female') echo 'selected'; ?>>Female</option>
                                <option value="other" <?php if($data['gender'] == 'other') echo 'selected'; ?>>Other</option>
                                <option value="prefer-not-to-say" <?php if($data['gender'] == 'prefer-not-to-say') echo 'selected'; ?>>Prefer not to say</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profilePicture">Profile Picture</label>
                        <label class="file-upload">
                            <img src="user_photo_resume/<?php echo $data['profile_picture'] ?>" alt="Profile Picture" style="max-width: 150px; border-radius: 10px; margin-bottom: 10px;">
                            <input type="file" id="profilePicture" name="profilePicture" accept="image/*" onchange="showFileName(this, 'profilePictureInfo')">
                            Choose Profile Picture
                        </label>
                        <div id="profilePictureInfo" class="file-info">
                            <strong>Selected:</strong> <span class="filename"></span>
                        </div>
                        <div class="help-text">Upload a professional headshot (JPG, PNG, max 5MB)</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="<?php echo $data['email'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $data['phone'] ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo $data['city'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="state">State/Province</label>
                            <input type="text" id="state" name="state" value="<?php echo $data['state'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" name="country">
                                <option value="">Select Country</option>
                                <option value="USA" <?php if($data['country'] == 'USA') echo 'selected'; ?>>United States</option>
                                <option value="CANADA" <?php if($data['country'] == 'CANADA') echo 'selected'; ?>>Canada</option>
                                <option value="UK" <?php if($data['country'] == 'UK') echo 'selected'; ?>>United Kingdom</option>
                                <option value="AUSTRALIA" <?php if($data['country'] == 'AUSTRALIA') echo 'selected'; ?>>Australia</option>
                                <option value="INDIA" <?php if($data['country'] == 'INDIA') echo 'selected'; ?>>India</option>
                                <option value="GERMANY" <?php if($data['country'] == 'GERMANY') echo 'selected'; ?>>Germany</option>
                                <option value="FRANCE" <?php if($data['country'] == 'FRANCE') echo 'selected'; ?>>France</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Professional Summary -->
                <div class="section">
                    <h2 class="section-title">Professional Summary</h2>
                    <div class="form-group">
                        <label for="summary">About Me <span class="required">*</span></label>
                        <textarea id="summary" name="summary" required><?php echo $data['summary'] ?></textarea>
                        <div class="help-text">Write 2-4 sentences highlighting your key strengths and career objectives</div>
                    </div>
                </div>

                <!-- Skills -->
                <div class="section">
                    <h2 class="section-title">Skills</h2>
                    <div class="form-group">
                        <label for="skills">Your Skills <span class="required">*</span></label>
                        <input type="text" id="skills" name="skills" value="<?php echo $data['skills'] ?>" required>
                        <div class="help-text">Separate skills with commas. Add your most relevant skills first.</div>
                    </div>
                </div>

                <!-- Education -->
                <div class="section">
                    <h2 class="section-title">Education</h2>
                    
                    <div class="dynamic-section">
                        <div class="dynamic-entry">
                            <h4 style="margin-bottom: 20px; color: #667eea;">Education #1</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="degree1">Degree/Certification</label>
                                    <input type="text" id="degree1" name="degree" value="<?php echo $data['degree'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="institution1">Institution Name</label>
                                    <input type="text" id="institution1" name="institution" value="<?php echo $data['institution'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="eduStartDate1">Start Date</label>
                                    <input type="month" id="eduStartDate1" name="eduStartDate" value="<?php echo $data['start_edu'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="eduEndDate1">End Date</label>
                                    <input type="month" id="eduEndDate1" name="eduEndDate" value="<?php echo $data['end_edu'] ?>">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="eduDescription1">Description (optional)</label>
                                <textarea id="eduDescription1" name="eduDescription" ><?php echo $data['edu_description'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resume Upload -->
                <div class="section">
                    <h2 class="section-title">Resume Upload</h2>
                    <div class="form-group">
                        <label for="resume">Upload Resume</label>
                        <label class="file-upload">
                            <input type="file" id="resume" name="resume" accept=".pdf,.doc,.docx" onchange="showFileName(this, 'resumeInfo')">
                            Choose Resume File
                        </label>
                        <div id="resumeInfo" class="file-info">
                            <strong>Selected:</strong> <span class="filename"></span>
                        </div>
                        <div class="help-text">Upload your resume in PDF or DOC format (max 10MB)</div>
                    </div>
                </div>

                <!-- Job Preferences -->
                <div class="section">
                    <h2 class="section-title">Job Preferences</h2>
                    
                    <div class="form-group">
                        <label for="desiredJobTitles">Desired Job Titles</label>
                        <input type="text" id="desiredJobTitles" name="desiredJobTitles" value="<?php echo $data['desired_job_titles'] ?>">
                        <div class="help-text">Separate multiple job titles with commas</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="preferredLocations">Preferred Job Locations</label>
                            <input type="text" id="preferredLocations" name="preferredLocations" value="<?php echo $data['preferred_location'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Employment Type</label>
                        <div class="checkbox-group">
                            <?php $selectedTypes = explode(', ', $data['employment_type']); ?>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="full-time" <?php if(in_array('full-time', $selectedTypes)) echo 'checked'; ?>>
                                Full-time
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="part-time" <?php if(in_array('part-time', $selectedTypes)) echo 'checked'; ?>>
                                Part-time
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="internship" <?php if(in_array('internship', $selectedTypes)) echo 'checked'; ?>>
                                Internship
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="freelance" <?php if(in_array('freelance', $selectedTypes)) echo 'checked'; ?>>
                                Freelance
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="contract" <?php if(in_array('contract', $selectedTypes)) echo 'checked'; ?>>
                                Contract
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="salaryMin">Minimum Salary (optional)</label>
                            <input type="number" id="salaryMin" name="salaryMin" value="<?php echo $data['salary_min'] ?>">
                        </div>

                        <div class="form-group">
                            <label for="salaryCurrency">Currency</label>
                            <select id="salaryCurrency" name="salaryCurrency">
                                <option value="USD" <?php if($data['salary_currency'] == 'USD') echo 'selected'; ?>>USD ($)</option>
                                <option value="EUR" <?php if($data['salary_currency'] == 'EUR') echo 'selected'; ?>>EUR (€)</option>
                                <option value="GBP" <?php if($data['salary_currency'] == 'GBP') echo 'selected'; ?>>GBP (£)</option>
                                <option value="CAD" <?php if($data['salary_currency'] == 'CAD') echo 'selected'; ?>>CAD ($)</option>
                                <option value="INR" <?php if($data['salary_currency'] == 'INR') echo 'selected'; ?>>INR (₹)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Languages -->
                <div class="section">
                    <h2 class="section-title">Languages</h2>
                    
                    <div class="dynamic-section">
                        <div class="dynamic-entry">
                            <h4 style="margin-bottom: 20px; color: #667eea;">Language #1</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="language1">Language</label>
                                    <input type="text" id="language1" name="language" value="<?php echo $data['language'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="proficiency1">Proficiency Level</label>
                                    <select id="proficiency1" name="proficiency">
                                        <option value="">Select Level</option>
                                        <option value="beginner" <?php if($data['language_proficiency'] == 'beginner') echo 'selected'; ?> >Beginner</option>
                                        <option value="intermediate" <?php if($data['language_proficiency'] == 'intermediate') echo 'selected'; ?>>Intermediate</option>
                                        <option value="fluent" <?php if($data['language_proficiency'] == 'fluent') echo 'selected'; ?>>Fluent</option>
                                        <option value="native" <?php if($data['language_proficiency'] == 'native') echo 'selected'; ?>>Native</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Submit Buttons -->
            <div class="button-group">
                <button type="submit" name="update" class="update-btn">Update Profile</button>
                <a href="?deleteAccount" class="delete-btn" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">Delete Account</a>
            </div>
            </form>
        </div>
    </div>

    <?php
        if(isset($_POST['update'])) {
            $updateDetails = updateUserProfile($_POST);

            echo "<script>
                    alert('$updateDetails');
                    window.location.href='user_profile.php?checkProfileStatus';
            </script>";
        }
    ?>

    <?php
        if(isset($_GET['deleteAccount'])) {
            $email = $_SESSION['email'];

            $deleteResult = deleteUserAccount($email);

            if ($deleteResult == 1) {
                echo "<script>
                        alert('Delete Account successful');
                        window.location.href = 'login.php';
                    </script>";
            } else {
                echo "<script>
                        alert('Delete not successful');
                        window.location.href = 'update_user_profile.php';
                    </script>";
            }
        }
    ?>
</body>
</html>