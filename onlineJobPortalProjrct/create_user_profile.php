<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Profile</title>
    <link rel="stylesheet" href="newcss/create_user_profile.css">
</head>
<body>

    <?php
        include("user_navbar.php");
    ?>


    <div class="container">
        <div class="form-container">
            <h1 class="page-title">Create Your Profile</h1>
            <p class="page-subtitle">Build your professional presence and showcase your expertise</p>

            <form action="" method="POST" enctype="multipart/form-data">
                <!-- Personal Information -->
                <div class="section">
                    <h2 class="section-title">Personal Information</h2>
                    
                    <div class="form-group">
                        <label for="fullName">Full Name <span class="required">*</span></label>
                        <input type="text" id="fullName" name="fullName" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" min="18" max="100">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                                <option value="prefer-not-to-say">Prefer not to say</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="profilePicture">Profile Picture</label>
                        <label class="file-upload">
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
                            <input type="email" id="email" name="email" value="<?php echo $data['email'];?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city">
                        </div>
                        <div class="form-group">
                            <label for="state">State/Province</label>
                            <input type="text" id="state" name="state">
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" name="country">
                                <option value="">Select Country</option>
                                <option value="USA">United States</option>
                                <option value="CANADA">Canada</option>
                                <option value="UK">United Kingdom</option>
                                <option value="AUSTRALIA">Australia</option>
                                <option value="INDIA">India</option>
                                <option value="GERMANY">Germany</option>
                                <option value="FRANCE">France</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Professional Summary -->
                <div class="section">
                    <h2 class="section-title">Professional Summary</h2>
                    <div class="form-group">
                        <label for="summary">About Me <span class="required">*</span></label>
                        <textarea id="summary" name="summary" placeholder="A brief summary of your skills, experience, and what you're looking for." required></textarea>
                        <div class="help-text">Write 2-4 sentences highlighting your key strengths and career objectives</div>
                    </div>
                </div>

                <!-- Skills -->
                <div class="section">
                    <h2 class="section-title">Skills</h2>
                    <div class="form-group">
                        <label for="skills">Your Skills <span class="required">*</span></label>
                        <input type="text" id="skills" name="skills" placeholder="e.g., JavaScript, Excel, Copywriting, Marketing" required>
                        <div class="help-text">Separate skills with commas. Add your most relevant skills first.</div>
                    </div>
                </div>

                <!-- Education -->
                <div class="section">
                    <h2 class="section-title">Education</h2>
                    
                    <div class="dynamic-section">
                        <div class="dynamic-entry">
                            <h4 style="margin-bottom: 20px; color: #667eea;">Education</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="degree">Degree/Certification</label>
                                    <input type="text" id="degree" name="degree" placeholder="e.g., Bachelor of Science">
                                </div>
                                <div class="form-group">
                                    <label for="institution">Institution Name</label>
                                    <input type="text" id="institution" name="institution">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="eduStartDate">Start Date</label>
                                    <input type="month" id="eduStartDate" name="eduStartDate">
                                </div>
                                <div class="form-group">
                                    <label for="eduEndDate">End Date</label>
                                    <input type="month" id="eduEndDate" name="eduEndDate">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="eduDescription">Description (optional)</label>
                                <textarea id="eduDescription" name="eduDescription" placeholder="Additional details about your education..."></textarea>
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
                        <input type="text" id="desiredJobTitles" name="desiredJobTitles" placeholder="e.g., Software Developer, Frontend Engineer">
                        <div class="help-text">Separate multiple job titles with commas</div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="preferredLocations">Preferred Job Locations</label>
                            <input type="text" id="preferredLocations" name="preferredLocations" placeholder="e.g., New York, San Francisco">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Employment Type</label>
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="full-time">
                                Full-time
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="part-time">
                                Part-time
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="internship">
                                Internship
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="freelance">
                                Freelance
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" name="employmentType[]" value="contract">
                                Contract
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="salaryMin">Minimum Salary (optional)</label>
                            <input type="number" id="salaryMin" name="salaryMin" placeholder="50000">
                        </div>

                        <div class="form-group">
                            <label for="salaryCurrency">Currency</label>
                            <select id="salaryCurrency" name="salaryCurrency">
                                <option value="USD">USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="CAD">CAD ($)</option>
                                <option value="INR">INR (₹)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Languages -->
                <div class="section">
                    <h2 class="section-title">Languages</h2>
                    
                    <div class="dynamic-section">
                        <div class="dynamic-entry">
                            <h4 style="margin-bottom: 20px; color: #667eea;">Language</h4>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="language">Language</label>
                                    <input type="text" id="language" name="language" placeholder="e.g., English">
                                </div>
                                <div class="form-group">
                                    <label for="proficiency">Proficiency Level</label>
                                    <select id="proficiency" name="proficiency">
                                        <option value="">Select Level</option>
                                        <option value="beginner">Beginner</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="fluent">Fluent</option>
                                        <option value="native">Native</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" name="submit" class="submit-btn">Create Profile</button>
            </form>
        </div>
    </div>

    <script>
        function showFileName(input, infoId) {
            const fileInfo = document.getElementById(infoId);
            const filenameSpan = fileInfo.querySelector('.filename');
            
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
                filenameSpan.textContent = fileName + ' (' + fileSize + ' MB)';
                fileInfo.classList.add('show');
            } else {
                fileInfo.classList.remove('show');
            }
        }
    </script>

    <?php
        if(isset($_POST['submit'])) {
            $userDetails = uploadUserProfileDetails($_POST);

            echo "
                <script>
                    alert('$userDetails');
                    window.location.href='user_profile.php?checkProfileStatus';
                </script>
            ";
        }
    ?>
</body>
</html>