<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechVision Solutions - Company Profile</title>
    <link rel="stylesheet" href="newcss/admin_profile.css">
</head>
<body>
    <!-- Navbar Space -->
    <div class="navbar-space">
        <?php 
            include("admin_navbar.php"); 
        ?>
    </div>

    <?php
        if(isset($_GET['check'])) {
            $email = $_SESSION['email'];

            $adminDetails = getAdminProfileById($email);

            $record = mysqli_num_rows($adminDetails);

            if($record > 0) {
                $row = mysqli_fetch_assoc($adminDetails);

                $companyname = $row['companyname'];
                $companytagline = $row['companytagline'];
                $logo = $row['logo'];
                $photo = $row['photo'];
                $phoneno = $row['phoneno'];
                $email = $row['email'];
                $address = $row['address'];
                $city = $row['city'];
                $state = $row['state'];
                $country = $row['country'];
                $pin = $row['pin'];
                $quotes = $row['quotes'];

                echo "
                    <!-- Profile Container -->
                    <div class='profile-container'>
                        <!-- Header Section -->
                        <div class='header-section'>
                            <form action='update_admin_profile.php' method='post'>
                                <input type='hidden' name='email' value='$email'>
                                <button class='edit-profile-button'>Edit Profile</button>
                            </form>
                            <img class='company-logo' src='admin_photo/$logo' alt='Company Logo'>
                            <h1 class='company-name'>$companyname</h1>
                            <p class='company-tagline'>$companytagline</p>
                        </div>

                        <!-- Company Photo -->
                        <div class='company-photo'>
                            <img src='admin_photo/$photo' alt='Company Photo'>
                        </div>

                        <!-- Content Section -->
                        <div class='content-section'>
                            <!-- Contact Information -->
                            <div class='contact-grid'>
                                <div class='contact-item'>
                                    <div class='contact-icon'>
                                        <svg viewBox='0 0 24 24'>
                                            <path d='M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z'/>
                                        </svg>
                                    </div>
                                    <div class='contact-info'>
                                        <h3>Phone Number</h3>
                                        <p>$phoneno</p>
                                    </div>
                                </div>

                                <div class='contact-item'>
                                    <div class='contact-icon'>
                                        <svg viewBox='0 0 24 24'>
                                            <path d='M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z'/>
                                        </svg>
                                    </div>
                                    <div class='contact-info'>
                                        <h3>Email Address</h3>
                                        <p>$email</p>
                                    </div>
                                </div>

                                <div class='contact-item' style='grid-column: 1 / -1;'>
                                    <div class='contact-icon'>
                                        <svg viewBox='0 0 24 24'>
                                            <path d='M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z'/>
                                        </svg>
                                    </div>
                                    <div class='contact-info'>
                                        <h3>Office Address</h3>
                                        <p>$address, $city, $state, $country, $pin</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Quotes Section -->
                            <div class='quotes-section'>
                                <div class='quote'>
                                    $quotes
                                </div>
                                <div class='quote-author'>- Our Company Philosophy</div>
                            </div>

                            <!-- Social Media & QR Section -->
                            <div class='social-section'>
                                <div class='social-links'>
                                    <div class='social-item'>
                                        <a href='https://facebook.com/techvisionsolutions' class='social-link facebook'>
                                            <svg viewBox='0 0 24 24'>
                                                <path d='M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'/>
                                            </svg>
                                        </a>
                                        <span class='social-name'>Facebook</span>
                                    </div>
                                    <div class='social-item'>
                                        <a href='https://instagram.com/techvisionsolutions' class='social-link instagram'>
                                            <svg viewBox='0 0 24 24'>
                                                <path d='M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162S8.597 18.162 12 18.162s6.162-2.759 6.162-6.162S15.403 5.838 12 5.838zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z'/>
                                            </svg>
                                        </a>
                                        <span class='social-name'>Instagram</span>
                                    </div>
                                    <div class='social-item'>
                                        <a href='https://linkedin.com/company/techvisionsolutions' class='social-link linkedin'>
                                            <svg viewBox='0 0 24 24'>
                                                <path d='M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'/>
                                            </svg>
                                        </a>
                                        <span class='social-name'>LinkedIn</span>
                                    </div>
                                    <div class='social-item'>
                                        <a href='https://twitter.com/techvisionsol' class='social-link twitter'>
                                            <svg viewBox='0 0 24 24'>
                                                <path d='M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z'/>
                                            </svg>
                                        </a>
                                        <span class='social-name'>Twitter</span>
                                    </div>
                                </div>

                                <div class='qr-section'>
                                    <div class='qr-code'></div>
                                    <p class='qr-label'>Scan for Contact Details</p>
                                </div>
                            </div>
                        </div>
                    </div>
                ";
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