<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="newcss/user_profile.css">

</head>
<body>
    <?php 
        include("user_navbar.php"); 
    ?>

        <?php
            if(isset($_GET['checkProfileStatus'])) {
                $email = $_SESSION['email'];

                $userDetails = getUserProfileByID($email);

                if($userDetails->num_rows > 0) {
                    $data = $userDetails->fetch_assoc();

                    $id = $data['id'];
                    $fullname =$data['fullname'];
                    $email = $data['email'];
                    $phone = $data['phone'];
                    $profilePicture = !empty($data['profile_picture']) ? $data['profile_picture'] : 'profile_pictures/default.jpg' ;
                    $city = $data['city'];
                    $state = $data['state'];
                    $country = $data['country'];
                    $summary = $data['summary'];
                    $skills = $data['skills'];
                    $degree = $data['degree'];
                    $institution = $data['institution'];
                    $start_edu = $data['start_edu'];
                    $end_edu = $data['end_edu'];
                    $edu_desciption = $data['edu_description'];
                    $resume = $data['resume'];
                    $desired_job_titles = $data['desired_job_titles'];
                    $preferred_location = $data['preferred_location'];
                    $employment_type = $data['employment_type'];
                    $salary_min = $data['salary_min'];
                    $salary_currency = $data['salary_currency'];
                    $language = $data['language'];
                    $language_proficiency = $data['language_proficiency'];
                    $profilestatus = $data['profilestatus'];

        ?>
                <div class="profile-container">
                    <div class="profile-header">
                        <h1>My Profile</h1>
                        <a href="update_user_profile.php?edit" class="edit-profile-btn">Edit Profile</a>
                    </div>

                    <!-- Personal Information -->
                    <div class="profile-section">
                        <div class="info-row">
                            <div class="info-value">
                                <img src="user_photo_resume/<?php echo $profilePicture ; ?>" alt="Profile Picture" class="profile-picture">
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Full Name</div>
                            <div class="info-value"><?php echo $fullname ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo $email ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Phone</div>
                            <div class="info-value"><?php echo $phone ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Location</div>
                            <div class="info-value"><?php echo $city.','.$state.','.$country ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Professional Summary</div>
                            <div class="info-value">
                                <?php echo $summary ; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="profile-section">
                        <h2>Skills</h2>
                        <div class="skills-list">
                        <?php 
                            $skillArray = explode(', ', $skills);

                            foreach ($skillArray as $skill) {
                                $trimSkill = trim($skill);

                                if(!empty($trimSkill)) {
                                    echo '<span class="skill-tag">'.$trimSkill.'</span>';
                                }
                            }
                        ?>
                        </div>
                    </div>

                    <!-- Education -->
                    <div class="profile-section">
                        <h2>Education</h2>
                        
                        <div class="education-item">
                            <div class="degree-name"><?php echo $degree; ?></div>
                            <div class="institution-name"><?php echo $institution; ?></div>
                            <div class="date-range"><?php echo $start_edu.'to'.$end_edu ; ?></div>
                            <div class="description">
                                <?php echo $edu_desciption ; ?>
                            </div>
                        </div>
                    </div>


                    <!-- Resume -->
                    <div class="profile-section">
                        <h2>Resume</h2>
                        <div class="info-row">
                            <div class="info-label">Resume</div>
                            <div class="info-value">
                                <a href="user_photo_resume/<?php echo $resume ; ?>" class="edit-profile-btn">Download Resume</a>
                            </div>
                        </div>
                    </div>

                    <!-- Job Preferences -->
                    <div class="profile-section">
                        <h2>Job Preferences</h2>
                        
                        <div class="info-row">
                            <div class="info-label">Desired Job Titles</div>
                            <div class="info-value"><?php echo $desired_job_titles ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Preferred Locations</div>
                            <div class="info-value"><?php echo $preferred_location ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Employment Type</div>
                            <div class="info-value"><?php echo $employment_type ; ?></div>
                        </div>
                        
                        <div class="info-row">
                            <div class="info-label">Salary Expectations</div>
                            <div class="info-value"><?php echo $salary_min.' '.$salary_currency ; ?></div>
                        </div>
                    </div>

                    <!-- Languages -->
                    <div class="profile-section">
                        <h2>Languages</h2>
                        
                        <div class="language-item">
                            <div class="language-name"><?php echo $language ; ?></div>
                            <div class="language-level"><?php echo $language_proficiency ; ?></div>
                        </div>
                    </div>
                </div>
        <?php
                } else {
                    echo "
                        <div class='empty-state'>
                            <i class='fas fa-inbox'></i>
                            <h2>No Profile Found</h2>
                            <p>There are currently no profile available. Create your profile first to get started!</p>
                        </div>
                    ";
                } 
            }
        ?>



</body>
</html>