<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - JobBoard</title>
    <link rel="stylesheet" href="newcss/add_new_job.css">
</head>
<body>
    <?php
        include("admin_navbar.php");
    ?>

    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h1>Post a New Job</h1>
                <p>Fill out the details below to create your job posting</p>
            </div>

            <form action="" method="post">
                <div class="form-group">
                    <input type="hidden" id="companyid" name="companyid" value="<?php echo $data['email']; ?>">
                    <label for="companyName">Company Name *</label>
                    <input type="text" id="companyName" name="companyname" required placeholder="e.g. Tech Innovations Inc.">
                </div>

                <div class="form-group">
                    <label for="companyAddress">Company Address *</label>
                    <textarea id="companyAddress" name="companyaddress" required placeholder="Enter complete company address including city, state, and country"></textarea>
                </div>

                <div class="form-group">
                    <label for="jobTitle">Job Post *</label>
                    <input type="text" id="jobTitle" name="post" required placeholder="e.g. Senior Frontend Developer">
                </div>

                <div class="form-group">
                    <label for="jobDescription">Job Description *</label>
                    <textarea id="jobDescription" name="description" required placeholder="Describe the role, responsibilities, and what you're looking for..."></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jobType">Job Type *</label>
                        <select id="jobType" name="jobtype" required>
                            <option value="">Select job type</option>
                            <option value="full-time">💼 Full-time</option>
                            <option value="part-time">🕐 Part-time</option>
                            <option value="internship">🎓 Internship</option>
                            <option value="contract">📋 Contract</option>
                            <option value="freelance">💻 Freelance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="workLocation">Work Location *</label>
                        <select id="workLocation" name="worklocation" required>
                            <option value="">Select work location</option>
                            <option value="remote">🏠 Remote</option>
                            <option value="on-site">🏢 On-site</option>
                            <option value="hybrid">🔄 Hybrid</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="salary">Annual Salary (INR) *</label>
                        <input type="number" id="salary" name="salary" required placeholder="50000" min="0" step="1000">
                    </div>
                    <div class="form-group">
                        <label for="endDate">Application End Date *</label>
                        <input type="date" id="endDate" name="enddate" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="skills">Required Skills *</label>
                    <textarea id="skills" name="skills" required placeholder="Enter required skills separated by commas (e.g., JavaScript, React, Node.js, CSS, HTML)"></textarea>
                </div>

                <div class="form-group">
                    <label for="qualification">Qualification Requirements *</label>
                    <textarea id="qualification" name="qualification" required placeholder="Minimum education, certifications, years of experience, etc."></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Job Status *</label>
                    <select id="status" name="status" required>
                        <option value="">Select job status</option>
                        <option value="ongoing">🟢 Ongoing - Accepting Applications</option>
                        <option value="ended">🔴 Ended - No Longer Accepting Applications</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="submit-btn">
                    Post Job Opening
                </button>
            </form>
        </div>
    </div>

    <?php
        if(isset($_POST['submit'])) {

            $jobdetails = uploadJobDetails($_POST);

            echo "
                <script>
                    alert('$jobdetails');
                    window.location.href='manage_job.php';
                </script>
            ";
        }
    ?>
</body>
</html>