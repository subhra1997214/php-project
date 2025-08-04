<?php

    // Send OTP via PHPMailer //

    // Include PHPMailer classes
    require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/PHPMailer/src/SMTP.php';
    require_once __DIR__ . '/PHPMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


    function connect() {
        // $hostName = "localhost";
        // $userName = "root";
        // $userPassword = "";
        // $dbName = "jobportal";

        $hostName = "sql200.infinityfree.com";
        $userName = "if0_39543174";
        $userPassword = "Su9647904531";
        $dbName = "if0_39543174_onlinejobportal";

        $conn = mysqli_connect($hostName, $userName, $userPassword, $dbName);

        return $conn;
    }

    function upload_user_details($data) {
        $target_dir = "candidate-image/";
        $originalName = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $uniqueImageName = uniqid("img_", true) . "." . $imageFileType;
        $target_file = $target_dir . $uniqueImageName;

        if (file_exists($target_file)) {
            return "Sorry, file already exists.";
        }
        elseif ($_FILES["image"]["size"] > 2000000) {
            return "Sorry, your file is too large.Max 2Mb allowed";
        }
        elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }

        else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // return "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                $name = $data['fullname'];
                $gender = $data['gender'];
                $age = $data['age'];
                $email = $data['email'];
                $password = $data['password'];
                $image = $uniqueImageName;
                $role = 'user';

                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
                $conn = connect();
        
                if ($conn) {
                    $stmt = $conn->prepare("INSERT INTO candidate_details (fullname, gender, age, email, password, image, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssdssss", $name, $gender, $age, $email, $hashedPassword, $image, $role); // s = string, d = double

                    if ($stmt->execute()) {
                        return "User registered successfully";
                    } else {
                        return "User registered failed!" . $stmt->error;
                    }
    
                }
            }
            else {
                return "Sorry, there was an error uploading your file.". $stmt->error;
            }
    
    
           
        }
    }

    function upload_admin_details($data) {
        $target_dir = "candidate-image/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $uniqueImageName = uniqid("img_", true) . "." . $imageFileType;
        $target_file = $target_dir . $uniqueImageName;

        if (file_exists($target_file)) {
            return "Sorry, file already exists.";
        }
        elseif ($_FILES["image"]["size"] > 2000000) {
            return "Sorry, your file is too large.Max 2Mb allowed";
        }
        // elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        //     return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        // }

        else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // return "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
                $name = $data['fullname'];
                $gender = $data['gender'];
                $age = $data['age'];
                $email = $data['email'];
                $password = $data['password'];
                $image = $uniqueImageName;
                $role = 'admin';

                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
                $conn = connect();
        
                if ($conn) {
                    $stmt = $conn->prepare("INSERT INTO candidate_details (fullname, gender, age, email, password, image, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssdssss", $name, $gender, $age, $email, $hashedPassword, $image, $role); // s = string, d = double

                    if ($stmt->execute()) {
                        return "Admin registered successfully";
                    } else {
                        return "Admin registered failed!" . $stmt->error;
                    }
    
                }
            }
            else {
                return "Sorry, there was an error uploading your file.". $stmt->error;
            }       
        }
    }


    function login($data) {

        $email = $data['email'];
        $password = $data['password'];
        $rememberMe = isset($data['remember']) ? true : false;

        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select * from candidate_details where email = ?");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            $result = $stmt->get_result();

            //echo "Found rows: ".$result->num_rows; // Debug output

            if($result->num_rows === 1) {
                $row = $result->fetch_assoc();

                $role = $row['role'];

                $hashedPasswordFromDB = $row['password'];

                // Verify the input password against the hashed one
                //echo "Stored hash: $hashedPasswordFromDB"; // Debug output
                //echo "Input password: $role"; // Debug output
                if(password_verify($password, $hashedPasswordFromDB)) {
                    if($rememberMe) {
                        // Generate a secure random token
                        $token = bin2hex(random_bytes(32)); // 64-character token
                        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
                        $expires = date('Y-m-d H:i:s', time() + 86400 * 7); //7days

                        // Update token in database

                        $updatestmt = $conn->prepare("update candidate_details set token_hash =? , expires_at =? where email = ?");
                        $updatestmt->bind_param("sss", $hashedToken, $expires, $email);
                        
                        if($updatestmt->execute()) {
                            // Set secure cookie (HttpOnly, Secure if HTTPS)
                            setcookie(
                                'remember_token',
                                $token,
                                time() + 86400 * 7,
                                '/',
                            );
                            // Set email in a cookie to repopulate login form
                            setcookie(
                                'remember_email',
                                $email,
                                time() + 86400 * 7,  // 7 days
                                '/'
                            ); 
                        } else {
                            error_log("Remember me token update failed: " . $conn->error);
                        }
                    }
                    return $role;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return "connection failed";
        }
    }


    function sendEmail($email) {
        $conn = connect();
        $email = trim(strtolower($email));

        if($conn) {
            // 1. Check if email exists
            $stmt = $conn->prepare("SELECT * FROM candidate_details WHERE LOWER(TRIM(email)) = LOWER(TRIM(?))");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows === 1) {
                $data = $result->fetch_assoc();
                // 2. Generate OTP
                $otp = rand(100000, 999999);

                $_SESSION['resetEmail'] = $email;
                $_SESSION['resetOtp'] = $otp;
                $_SESSION['otp_expires'] = time() + 600; // 10 minutes

                // Or manual include if not using Composer:
                // require 'path/to/src/PHPMailer.php';
                // require 'path/to/src/SMTP.php';
                // require 'path/to/src/Exception.php';

                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'bachharakash@gmail.com';                 // Your Gmail address
                    $mail->Password   = 'puoidupbgwhjgjsx';                    // App password (not Gmail password)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // TLS encryption
                    $mail->Port       = 587;                                    // TCP port

                    // Recipients
                    $mail->setFrom('bachharakash@gmail.com', 'AKASH');
                    $mail->addAddress($_SESSION['resetEmail'], $data['fullname']);

                    // Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'Your OTP for Password Reset - Online Job Portal';
                    $mail->Body = '
                        <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333; padding: 10px;">
                            <p>Dear <strong style="color: #00aaff;">' . htmlspecialchars($data['fullname']) . '</strong>,</p>

                            <p>We received a request to reset the password for your account on our job portal.</p>

                            <p><strong>Your One-Time Password (OTP) is:</strong></p>
                            <div style="padding: 10px; background-color: #f4f4f4; border: 1px dashed #2E86C1; display: inline-block; font-size: 24px; font-weight: bold; color: #2E86C1;">
                                ' . $otp . '
                            </div>

                            <p style="margin-top: 15px;">This OTP is valid for the next <strong>10 minutes</strong>. Please do not share it with anyone.</p>

                            <p>If you did not request this password reset, please ignore this email or contact our support team.</p>

                            <br>
                            <p style="color: #555;">Best Regards,<br><strong>Online Job Portal Team</strong></p>
                        </div>';
                    $mail->AltBody = 'Dear ' . $data['fullname'] . ',
                            We received a request to reset your password for your account on our job portal.

                            Your One-Time Password (OTP) is: ' . $otp . '
                            This OTP is valid for the next 10 minutes. Please do not share it with anyone.

                            If you did not request a password reset, please ignore this email or contact support.

                            Best Regards,
                            Online Job Portal Team';


                    $mail->send();
                    return ["success" => true];
                } catch (Exception $e) {
                    return ["success" => false, "error" => $mail->ErrorInfo];
                }
            } else {
                return ["success" => false, "error" => "Email not found in our system."];
            }
        } else {
            return ["successs" => false, "error" => "Database connection failed."];
        }

    }

    function verifyOtp($enteredOtp) {
        if(isset($_SESSION['resetOtp']) && strval($enteredOtp) === strval($_SESSION['resetOtp'])) {
            $_SESSION['verifiedOtp'] = true; // Mark as verified
            return $_SESSION['verifiedOtp'];
        } else {
            return false;
        }
    }

    function resendEmail() {
        $email = $_SESSION['resetEmail'] ?? '';

        if($email) {
            $newOtp = rand(100000, 999999);

            $_SESSION['resetOtp'] = $newOtp;
            $_SESSION['otp_expires'] = time() + 600; // 10 minutes

            $conn = connect();

            if($conn) {
                $conn = connect();
                $stmt = $conn->prepare("SELECT fullname FROM candidate_details WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                $fullname = $data['fullname'] ?? 'User';

                $mail = new PHPMailer(true);

                try {
                    // Server settings
                    $mail->isSMTP();                                            // Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'bachharakash@gmail.com';                 // Your Gmail address
                    $mail->Password   = 'puoidupbgwhjgjsx';                    // App password (not Gmail password)
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // TLS encryption
                    $mail->Port       = 587;                                    // TCP port

                    // Recipients
                    $mail->setFrom('bachharakash@gmail.com', 'AKASH');
                    $mail->addAddress($email, $fullname);

                    // Content
                    $mail->isHTML(true); // Set email format to HTML
                    $mail->Subject = 'Your OTP for Password Reset - Online Job Portal';
                    $mail->Body = '
                        <div style="font-family: Arial, sans-serif; font-size: 16px; color: #333; padding: 10px;">
                            <p>Dear <strong style="color: #00aaff;">' . htmlspecialchars($fullname) . '</strong>,</p>

                            <p>We received a request to reset the password for your account on our job portal.</p>

                            <p><strong>Your One-Time Password (OTP) is:</strong></p>
                            <div style="padding: 10px; background-color: #f4f4f4; border: 1px dashed #2E86C1; display: inline-block; font-size: 24px; font-weight: bold; color: #2E86C1;">
                                ' . $newOtp . '
                            </div>

                            <p style="margin-top: 15px;">This OTP is valid for the next <strong>10 minutes</strong>. Please do not share it with anyone.</p>

                            <p>If you did not request this password reset, please ignore this email or contact our support team.</p>

                            <br>
                            <p style="color: #555;">Best Regards,<br><strong>Online Job Portal Team</strong></p>
                        </div>';
                    $mail->AltBody = 'Dear ' . $fullname . ',
                            We received a request to reset your password for your account on our job portal.

                            Your One-Time Password (OTP) is: ' . $newOtp . '
                            This OTP is valid for the next 10 minutes. Please do not share it with anyone.

                            If you did not request a password reset, please ignore this email or contact support.

                            Best Regards,
                            Online Job Portal Team';


                    $mail->send();
                    return ["success" => true];
                } catch(Exception $e) {
                    return ["success" => false, "error" => $mail->ErrorInfo];
                }
            }
        } else {
            return ["success" => false, "error" => "No email found in session."];
        }
    }


    function createNewPassword($newpassword, $confirmPassword) {
        if(!isset($_SESSION['resetEmail']) || !isset($_SESSION['resetOtp'])) {
            return ["success" => false, "error" => "Session expired. Please go back and enter your email again."];
        }

        if($newpassword != $confirmPassword) {
            return  ["success" => false, "error" => "Passwords do not match. Please try again."];
        } else {
            $hashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
            $email = $_SESSION['resetEmail'];

            $conn = connect();

            if($conn) {
                $stmt = $conn->prepare("update candidate_details set password = ? where email = ? ");
                $stmt->bind_param("ss", $hashedPassword,$email);
                $stmt->execute();

                if($stmt->affected_rows >= 0) {
                    // Success

                    unset($_SESSION['resetEmail']);
                    unset($_SESSION['resetOtp']);
                    unset($_SESSION['verifiedOtp']);

                    return ["success" => true];
                } else {
                    return ["success" => false, "error" => "Error updating password. Please try again."];
                }
            } else {
                return ["success" => false, "error" => "Database connection error."];
            }
        }
    }


    function getUserByEmail($email) {

        $conn = connect();

        if($conn) {
            $sql = "select * from candidate_details where email='$email' ";

            $response = mysqli_query($conn, $sql);

            return $response;
        }
    }



    /*Admin page work start*/

    function uploadJobDetails($data) {
        $companyid = $data['companyid'];
        $companyname = $data['companyname'];
        $companyaddress = $data['companyaddress'];
        $post = $data['post'];
        $description = $data['description'];
        $jobtype = $data['jobtype'];
        $location = $data['worklocation'];
        $salary = $data['salary'];
        $enddate = $data['enddate'];
        $skills = $data['skills'];
        $qualification = $data['qualification'];
        $status = $data['status'];

        $conn = connect();

        if($conn) {

            $stmt = $conn->prepare("INSERT INTO job_details (companyid, companyname, companyaddress, post, description, jobtype, location, salary, enddate, skills, qualification, status)  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?, ?, ?)");
            $stmt->bind_param("ssssssssssss", $companyid, $companyname, $companyaddress, $post, $description, $jobtype, $location, $salary, $enddate, $skills, $qualification, $status);

            if ($stmt->execute()) {
                return "Job details upload successfully";
            } else {
                return "Job details uploading failed!" . $stmt->error;
            }
        }
    }

    function getAllDetails($email) {
        $conn = connect();

        $sql = "select * from job_details where companyid = '$email' ";

        $response = mysqli_query($conn, $sql);

        return $response;
    }

    function getDetailsById($jobid) {
        $conn = connect();

        $sql = "select * from job_details where jobid ='$jobid'";

        $response = mysqli_query($conn, $sql);

        return $response;
    }

    function update($data) {
        $jobid = $data['jobid'];
        $companyname = $data['companyname'];
        $companyaddress = $data['companyaddress'];
        $post = $data['post'];
        $description = $data['description'];
        $jobtype = $data['jobtype'];
        $location = $data['worklocation'];
        $salary = $data['salary'];
        $enddate = $data['enddate'];
        $skills = $data['skills'];
        $qualification = $data['qualification'];
        $status = $data['status'];

        $conn = connect();

        if($conn) {
            $sql = "update job_details set companyname='$companyname', companyaddress='$companyaddress', post='$post', description='$description', jobtype ='$jobtype', location='$location', salary='$salary', enddate='$enddate', skills='$skills', qualification='$qualification', status='$status' where jobid='$jobid' ";

            $response = mysqli_query($conn, $sql);

            return $response;
        }
    }

    function deleteJobDetails($jobid) {
        $conn = connect();

        if($conn) {
            $jobdetails = getDetailsById($jobid);

            $data = mysqli_fetch_assoc($jobdetails);

            if($data) {
                $sql = "delete from job_details where jobid='$jobid' ";

                $response = mysqli_query($conn, $sql);

                return $response;
            }
        } else {
            return false;
        }
    }

    function uploadAdminProfileDetails($data) {
        $target_dir = "admin_photo/";

        /* for image handling */
        $target_image_file = $target_dir . basename($_FILES["company_photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_image_file,PATHINFO_EXTENSION));
        $uniqueImageName = uniqid("img_", true) . "." . $imageFileType;
        $imagePath = $target_dir . $uniqueImageName;

        /* for logo handling */

        $target_logo_file = $target_dir . basename($_FILES["company_logo"]["name"]);
        $logoFileType = strtolower(pathinfo($target_logo_file,PATHINFO_EXTENSION));
        $uniqueLogoName = uniqid("logo_", true) . "." . $logoFileType;
        $logoPath = $target_dir . $uniqueLogoName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (file_exists($imagePath)) {
            return "Sorry, imagefile already exists.";
        }
        if (file_exists($logoPath)) {
            return "Sorry, logofile already exists.";
        }
        elseif ($_FILES["company_photo"]["size"] > 500000 || $_FILES["company_logo"]["size"] > 500000) {
            return "Sorry, one of the files is too large.";
        }
        elseif (!in_array($imageFileType, $allowedTypes) || !in_array($logoFileType, $allowedTypes)) {
            return "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
        else {
            if (move_uploaded_file($_FILES["company_photo"]["tmp_name"], $imagePath) && move_uploaded_file($_FILES["company_logo"]["tmp_name"], $logoPath)) {
                $companyid = $data['companyid'];
                $companyname = $data['company_name'];
                $companytagline = $data['company_tagline'];
                $logo = $uniqueLogoName;
                $photo = $uniqueImageName;
                $phoneno = $data['phone_number'];
                $email = $data['companyid'];
                $address = $data['street_address'];
                $city = $data['city'];
                $state = $data['state'];
                $country = $data['country'];
                $pin = $data['zip_code'];
                $quotes = $data['company_quote'];
                $profilestatus = 1 ;

                $conn = connect();

                if ($conn) {
                    $stmt = $conn->prepare("INSERT INTO admin_profile_details (companyid, companyname, companytagline, logo, photo, phoneno, email, address, city, state, country, pin, quotes, profilestatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssssdsssssisi", $companyid, $companyname, $companytagline, $logo, $photo, $phoneno, $email, $address, $city, $state, $country, $pin, $quotes, $profilestatus);

                    if ($stmt-> execute()) {
                        $stmt-> close();
                        $conn-> close();
                        return "Details Uploaded successfully";
                    } else {
                        $error = $stmt-> error;
                        $stmt-> close();
                        $conn-> close(); 
                        return "Details Uploading failed!" . $error;
                    }
    
                }
                else {
                    return "Sorry, there was a database connection error.";
                }
            } else {
                return "File upload failed.";
            }
        }
    }

    function getAdminProfileById($email) {

        $conn = connect();

        if($conn) {
            $sql = "select * from admin_profile_details where email ='$email' ";

            $response = mysqli_query($conn, $sql);

            return $response;
        }
    }

    function getALLAdminDetails() {
        $conn = connect();

        if($conn) {
            $sql = "select * from admin_profile_details";

            $response = mysqli_query($conn, $sql);

            return $response;
        }
    }

    function updateAdminProfile($data) {
        $target_dir = "admin_photo/";

        $companyid = $data['companyid'];
        $companyname = $data['company_name'];
        $companytagline = $data['company_tagline'];
        $phoneno = $data['phone_number'];
        $email = $data['companyid']; // used as identifier
        $address = $data['street_address'];
        $city = $data['city'];
        $state = $data['state'];
        $country = $data['country'];
        $pin = $data['zip_code'];
        $quotes = $data['company_quote'];
        $profilestatus = 1;

        $conn = connect();
        if (!$conn) {
            return "Database connection error.";
        }

        // Fetch existing profile details
        $res = getAdminProfileById($email);
        $details = mysqli_fetch_assoc($res);
        $existing_logo = $details["logo"];
        $existing_photo = $details["photo"];

        // Default to existing images
        $new_logo = $existing_logo;
        $new_photo = $existing_photo;

        // Handle logo upload if a new one is provided
        if (isset($_FILES['company_logo']) && $_FILES['company_logo']['error'] === UPLOAD_ERR_OK) {
            $logoFileType = strtolower(pathinfo($_FILES["company_logo"]["name"], PATHINFO_EXTENSION));
            if (!in_array($logoFileType, ['jpg', 'jpeg', 'png', 'gif']) || $_FILES["company_logo"]["size"] > 500000) {
                return "Invalid logo file.";
            }

            $new_logo = uniqid("logo_", true) . "." . $logoFileType;
            $logoPath = $target_dir . $new_logo;

            if (move_uploaded_file($_FILES["company_logo"]["tmp_name"], $logoPath)) {
                if (!empty($existing_logo)) unlink($target_dir . $existing_logo);
            } else {
                return "Failed to upload logo.";
            }
        }

        // Handle photo upload if a new one is provided
        if (isset($_FILES['company_photo']) && $_FILES['company_photo']['error'] === UPLOAD_ERR_OK) {
            $photoFileType = strtolower(pathinfo($_FILES["company_photo"]["name"], PATHINFO_EXTENSION));
            if (!in_array($photoFileType, ['jpg', 'jpeg', 'png', 'gif']) || $_FILES["company_photo"]["size"] > 500000) {
                return "Invalid photo file.";
            }

            $new_photo = uniqid("img_", true) . "." . $photoFileType;
            $photoPath = $target_dir . $new_photo;

            if (move_uploaded_file($_FILES["company_photo"]["tmp_name"], $photoPath)) {
                if (!empty($existing_photo)) unlink($target_dir . $existing_photo);
            } else {
                return "Failed to upload photo.";
            }
        }

        // Update statement
        $stmt = $conn-> prepare("update admin_profile_details set companyid= ?, companyname= ?, companytagline= ?, logo= ?, photo= ?, phoneno= ?, address= ?, city= ?, state= ?, country= ?, pin= ?, quotes= ?, profilestatus= ? where email = ?");

        $stmt-> bind_param("ssssssssssssss", $companyid, $companyname, $companytagline, $new_logo, $new_photo, $phoneno, $address, $city, $state, $country, $pin, $quotes, $profilestatus, $email);

        $response = $stmt-> execute();

        if ($response == 1) {
            return "Admin profile updated successfully.";
        } else {
            return "Admin profile updating failed.";
        }
    }

    function deleteAdminAccount($email) {
        $conn = connect();

        if($conn) {
            $res1 = getUserByEmail($email);
            $adminDetsils = mysqli_fetch_assoc($res1);

            if($adminDetsils['image']!= null || $adminDetsils['image']!="") {
                $image = $adminDetsils['image'];
                $filepath = "candidate-image/" . $image;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $res2 = getAdminProfileById($email);
            $adminDetsils = mysqli_fetch_assoc($res2);

            if($adminDetsils['logo']!=null || $adminDetsils['logo']!="") {
                $image = $adminDetsils['logo'];
                $filepath = "admin_photo/" . $image;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $res3 = getAdminProfileById($email);
            $adminDetsils = mysqli_fetch_assoc($res3);

            if($adminDetsils['photo']!=null || $adminDetsils['photo']!="") {
                $image = $adminDetsils['photo'];
                $filepath = "admin_photo/" . $image;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $stmt = $conn-> prepare("delete from candidate_details where email = ? ");
            $stmt-> bind_param("s", $email);

            $response = $stmt->execute();

            $stmt-> close();
            $conn-> close();

            return $response;
        }
    }

    function getAppliedCandidate($jobid) {
        $conn = connect();

        $stmt = $conn->prepare("select upd.fullname, upd.age, upd.gender, upd.skills, upd.resume, upd.email, ad.applystatus from user_profile_details upd join apply_details ad on upd.email = ad.userid where ad.jobid =?");

        $stmt->bind_param("i", $jobid);

        $stmt->execute();

        return $stmt->get_result();
    }

    function updateAppliedStatusAccept($jobid, $userid) {
        $conn = connect();

        $stmt = $conn->prepare("update apply_details set applystatus = 'accepted' where jobid = ? and userid = ?");

        $stmt->bind_param("is", $jobid, $userid);

        $stmt->execute();

        return "Application accepted Successfully";
    }

    function updateAppliedStatusReject($jobid, $userid) {
        $conn = connect();

        $stmt = $conn->prepare("update apply_details set applystatus = 'rejected' where jobid = ? and userid = ?");

        $stmt->bind_param("is", $jobid, $userid);

        $stmt->execute();

        return "Application rejected Successfully";
    }

    function getAllJobQuery() {
        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select distinct jd.jobid, jd.post from job_details jd join apply_details ad on jd.jobid = ad.jobid where ad.applystatus = 'accepted' ");

            $stmt->execute();

            return $stmt->get_result();
        }
    }

    function getCandidateQuery($jobid) {
        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select upd.fullname, upd.phone, upd.email, upd.resume from user_profile_details upd join apply_details ad on upd.email = ad.userid where ad.jobid=? and ad.applystatus='accepted' ");

            $stmt->bind_param("i", $jobid);

            $stmt->execute();

            return $stmt->get_result();
        }
    }

    function getTotalJob() {
        $email = $_SESSION['email'];

        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select jobid from job_details where companyid = ? ");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            return $stmt->get_result();
        }
    }

    function getTotalSelected() {
        $email = $_SESSION['email'];

        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select ad.applystatus from apply_details ad join job_details jd on ad.jobid = jd.jobid where jd.companyid= ? and ad.applystatus = 'accepted' ");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            return $stmt->get_result();
        }
    }

    function getTotalAppliedCandidate() {
        $email = $_SESSION['email'];

        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select ad.applystatus from apply_details ad join job_details jd on ad.jobid = jd.jobid where jd.companyid= ? and (ad.applystatus = 'accepted' or ad.applystatus = 'rejected') ");

            $stmt->bind_param("s", $email);

            $stmt->execute();

            return $stmt->get_result();
        }  
    }







    /*User page work start*/


    function uploadUserProfileDetails($data) {
        $target_dir = "user_photo_resume/";
        
        // Initialize file paths as empty
        $imagePath = '';
        $resumePath = '';
        $imageUploaded = false;
        $resumeUploaded = false;

        $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $allowedResumeType = ['pdf', 'doc', 'docx'];

        // Handle Profile Picture Upload (Optional)
        if (isset($_FILES["profilePicture"]) && $_FILES["profilePicture"]["error"] === UPLOAD_ERR_OK) {
            // File size check (5MB image)
            if ($_FILES["profilePicture"]["size"] > 5 * 1024 * 1024) {
                return "Profile picture is too large. Max 5MB allowed.";
            }

            $target_image_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_image_file, PATHINFO_EXTENSION));
            
            // File type validation
            if (!in_array($imageFileType, $allowedImageTypes)) {
                return "Only JPG, JPEG, PNG, and GIF image types are allowed.";
            }

            $uniqueImageName = uniqid("img_", true) . "." . $imageFileType;
            $imagePath = $target_dir . $uniqueImageName;
            
            $imageUploaded = move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $imagePath);
            
            if (!$imageUploaded) {
                return "Profile picture upload failed.";
            }
        }

        // Handle Resume Upload (Optional)
        if (isset($_FILES["resume"]) && $_FILES["resume"]["error"] === UPLOAD_ERR_OK) {
            // File size check (10MB resume)
            if ($_FILES["resume"]["size"] > 10 * 1024 * 1024) {
                return "Resume is too large. Max 10MB allowed.";
            }

            $target_resume_file = $target_dir . basename($_FILES["resume"]["name"]);
            $resumeFileType = strtolower(pathinfo($target_resume_file, PATHINFO_EXTENSION));
            
            // File type validation
            if (!in_array($resumeFileType, $allowedResumeType)) {
                return "Only PDF, DOC, and DOCX formats are allowed for resumes.";
            }

            $uniqueResumeName = uniqid("resume_", true) . "." . $resumeFileType;
            $resumePath = $target_dir . $uniqueResumeName;
            
            $resumeUploaded = move_uploaded_file($_FILES["resume"]["tmp_name"], $resumePath);
            
            if (!$resumeUploaded) {
                return "Resume upload failed.";
            }
        }

        // Process form data
        $resumestatus = $resumeUploaded ? 1 : 0;
        $fullname = $data['fullName'];
        $age = $data['age'];
        $gender = $data['gender'];
        $email = $data['email'];
        $phone = $data['phone'];
        $image = $uniqueImageName;
        $city = $data['city'];
        $state = $data['state'];
        $country = $data['country'];
        $summary = $data['summary'];
        $skills = is_array($data['skills']) ? implode(", ", $data['skills']) : ($data['skills']);
        $degree = $data['degree'];
        $institution = $data['institution'];
        $start_edu = $data['eduStartDate'];
        $end_edu = $data['eduEndDate'];
        $edu_description = $data['eduDescription'];
        $resume = $uniqueResumeName;
        $desired_job_titles = is_array($data['desiredJobTitles']) ? implode(", ", $data['desiredJobTitles']) : ($data['desiredJobTitles']);
        $preferred_location = is_array($data['preferredLocations']) ? implode(", ", $data['preferredLocations']) : ($data['preferredLocations']);
        $employment_type = is_array($data['employmentType']) ? implode(", ", $data['employmentType']) : ($data['employmentType']);
        $salary_min = $data['salaryMin'];
        $salary_currency = $data['salaryCurrency'] ?? 'USD';
        $language = $data['language'];
        $language_proficiency = $data['proficiency'];
        $profilestatus = 1;

        $conn = connect();

        if ($conn) {
            $stmt = $conn->prepare("INSERT INTO user_profile_details (fullname, age, gender, email, phone, profile_picture, city, state, country, summary, skills, degree, institution, start_edu, end_edu, edu_description, resume, resumestatus, desired_job_titles, preferred_location, employment_type, salary_min, salary_currency, language, language_proficiency, profilestatus) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            
            $stmt->bind_param("sisssssssssssssssisssdsssi", $fullname, $age, $gender, $email, $phone, $image, $city, $state, $country, $summary, $skills, $degree, $institution, $start_edu, $end_edu, $edu_description, $resume, $resumestatus, $desired_job_titles, $preferred_location, $employment_type, $salary_min, $salary_currency, $language, $language_proficiency, $profilestatus);

            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                return "Profile uploaded successfully";
            } else {
                $stmt->close();
                $conn->close();
                return "Failed to upload profile: " . $stmt->error;
            }
        } else {
            return "Database connection failed!";
        }
    }


    function getUserProfileByID($email) {
        $conn = connect();

        $sql = "select * from user_profile_details where email=? ";

        $stmt = $conn-> prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result;
    }

    function updateUserProfile($data) {
        $target_dir = "user_photo_resume/";

        $fullname = $data['fullName'];
        $age = $data['age'];
        $gender = $data['gender'];
        $email = $data['email'];
        $phone = $data['phone'];
        $city = $data['city'];
        $state = $data['state'];
        $country = $data['country'];
        $summary = $data['summary'];
        $skills = is_array($data['skills']) ? implode(", ", $data['skills']) : ($data['skills']);
        $degree = $data['degree'];
        $institution = $data['institution'];
        $start_edu = $data['eduStartDate'];
        $end_edu = $data['eduEndDate'];
        $edu_description = $data['eduDescription'];
        $desired_job_titles = is_array($data['desiredJobTitles']) ? implode(", ", $data['desiredJobTitles']) : ($data['desiredJobTitles']);
        $preferred_location = is_array($data['preferredLocations']) ? implode(", ", $data['preferredLocations']) : ($data['preferredLocations']);
        $employment_type = is_array($data['employmentType']) ? implode(", ", $data['employmentType']) : ($data['employmentType']);
        $salary_min = $data['salaryMin'];
        $salary_currency = $data['salaryCurrency'];
        $language = $data['language'] ?? '';
        $language_proficiency = $data['proficiency'];
        $profilestatus = 1;

        $conn = connect();
        if(!$conn) {
            return "Database connection error!";
        }

        // Fetching profile details
        $res = getUserProfileByID($email);
        $details = mysqli_fetch_assoc($res);
        $id = $details['id'];
        $existing_profilePicture = $details['profile_picture'];
        $existing_resume = $details['resume'];

        // Default to existing profilePicture & resume
        $new_profilePicture = $existing_profilePicture;
        $new_resume = $existing_resume;

        // Handle profilePicture upload if a new one is provided
        if(isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
            $target_image_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
            $imageFileType = strtolower(pathinfo($target_image_file, PATHINFO_EXTENSION));
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif']) || $_FILES["profilePicture"]["size"] > 5 * 1024 * 1024) {
                return "Invalid file extension OR Profile picture is too large. Max 5MB allowed.";
            }

            $new_profilePicture = uniqid("profile_", true) . "." . $imageFileType;
            $imagePath = $target_dir . $new_profilePicture;

            if(move_uploaded_file($_FILES['profilePicture']['tmp_name'], $imagePath)) {
                if(!empty($existing_profilePicture)) unlink($target_dir . $existing_profilePicture);
            } else {
                return "Failed to upload profilePicture.";
            }
        }

        // Handle profilePicture upload if a new one is provided
        if(isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
            $target_resume_file = $target_dir . basename($_FILES["resume"]["name"]);
            $resumeFileType = strtolower(pathinfo( $target_resume_file, PATHINFO_EXTENSION));
            if (!in_array($resumeFileType, ['pdf', 'doc', 'docx']) || $_FILES["resume"]["size"] > 10 * 1024 * 1024) {
                return "Invalid resume file OR Resume is too large. Max 10MB allowed.";
            }

            $new_resume = uniqid("resume_", true) . "." . $resumeFileType;
            $resumePath = $target_dir . $new_resume;

            if(move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath)) {
                if(!empty($existing_resume)) unlink($target_dir . $existing_resume);
            } else {
                return "Failed to upload resume.";
            }
        }
        $resumestatus = !empty($new_resume) ? 1 : 0 ;

        // Update statement
        $stmt = $conn-> prepare("update user_profile_details set fullname= ?, age=?, gender=?, email=?, phone=?, profile_picture=?, city=?, state=?, country=?, summary=?, skills=?, degree=?, institution=?, start_edu=?, end_edu=?, edu_description=?, resume=?, resumestatus=?, desired_job_titles=?, preferred_location=?, employment_type=?, salary_min=?, salary_currency=?, language=?, language_proficiency=?, profilestatus=? where id=?");

        $stmt->bind_param("sisssssssssssssssisssisssii", $fullname, $age, $gender, $email, $phone, $new_profilePicture, $city, $state, $country, $summary, $skills, $degree, $institution, $start_edu, $end_edu, $edu_description, $new_resume, $resumestatus, $desired_job_titles, $preferred_location, $employment_type, $salary_min, $salary_currency, $language, $language_proficiency, $profilestatus, $id);

        $response = $stmt->execute();

        if ($response == 1) {
            return "Your profile updated successfully.";
        } else {
            return "Your profile updating failed.";
        }
    }


    function deleteUserAccount($email){
        $conn = connect();

        if($conn) {
            $res1 = getUserByEmail($email);
            $userDetails = mysqli_fetch_assoc($res1);

            if($userDetails['image'] != null && $userDetails['image'] != '') {
                $image = $userDetails['image'];
                $filepath = "candidate-image/" . $image;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $res2 = getUserProfileByID($email);
            $userDetails = mysqli_fetch_assoc($res2);

            if($userDetails['profile_picture'] != null && $userDetails['profile_picture'] != '') {
                $profilePicture = $userDetsils['profile_picture'];
                $filepath = "user_photo_resume/" . $profilePicture;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $res3 = getUserProfileByID($email);
            $userDetails = mysqli_fetch_assoc($res3);

            if($userDetails['resume'] != null && $userDetails['resume'] != '') {
                $resume = $userDetsils['resume'];
                $filepath = "user_photo_resume/" . $resume;
                if(file_exists($filepath)) {
                    unlink($filepath);
                }
            }

            $stmt = $conn-> prepare("delete from candidate_details where email = ? ");

            $stmt->bind_param("s", $email);

            $response = $stmt->execute();

                $stmt->close();
                $conn->close();

                return $response;
        } else {
            return false;
        }
    }


    function getAllJobDetails($email) {
        $conn = connect();

        $stmt = $conn-> prepare("select * from job_details where jobid not in (select jobid from apply_details where userid = ?) ");

        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result();
    }

    function searchJob($searchTerm, $email) {

        $conn = connect();

        if($conn) {
            
            $searchInput = mysqli_real_escape_string($conn, $searchTerm);

            $term = "%$searchInput%";

            $stmt = $conn-> prepare("select * from job_details where post like ? or companyname like ? and jobid not in (select jobid from apply_details where userid = ?)");
            
            $stmt-> bind_param('sss', $term, $term, $email);

            if($stmt->execute()) {
                return $stmt->get_result();
            }
        }
    }

    /* APPLY SECTION WORK START HERE*/

    function applyJob($jobid, $email) {
        $conn = connect();

        $applyDate = date("d-m-y");

        $stmt = $conn-> prepare("insert into apply_details(jobid, userid, applydate) values(?, ?, ?)");

        $stmt->bind_param("iss", $jobid, $email, $applyDate);

        if($stmt-> execute()) {
            $stmt->close();
            $conn->close();
            return "You have applied successfully";
        } else {
            $stmt->close();
            $conn->close();
            return "There is a problem in appling" . $stmt->error;
        }
    }

    function getAllApplyjob($email) {
        $conn = connect();

        $stmt = $conn->prepare(" select jd.*, ad.applydate, ad.applystatus from job_details jd inner join apply_details ad on jd.jobid = ad.jobid where userid = ? ");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result();
    }

    function getAllAppliedJobs($email) {
        $conn = connect();

        $stmt = $conn-> prepare("select * from apply_details where userid = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result();
    }

    function getJobDetailsById($jobid) {
        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("select * from job_details where jobid = ?");

            $stmt->bind_param("i", $jobid);

            $stmt->execute();

            $result = $stmt->get_result();

            return $result;
        }
    }

    function removeJobDetails($jobid, $email) {
        $conn = connect();

        if($conn) {
            $stmt = $conn->prepare("delete from apply_details where jobid = ? and userid = ?");

            $stmt->bind_param("is", $jobid, $email);

            $stmt->execute();

            $rowsAffected = $stmt->affected_rows;  // ✅ check how many rows deleted

            $stmt->close();
            $conn->close();

            return $rowsAffected > 0 ? 1 : 0; // ✅ return 1 if deleted, else 0
        }
    }

?>