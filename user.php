<?php 
session_start();
include 'dbcon.php';

$user_id = 1; // Assuming the user ID is 1 for now
$query = "SELECT * FROM users WHERE user_id = $user_id"; // Adjust the query as needed
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Handle error if user data is not found
    echo "User data not found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD
<?php include 'user_header.php'; ?>
<style>
    .profile-section {
        display: flex;
        align-items: center;
    }

    .profile-info {
        display: flex;
        align-items: center;
    }

    .profile-pic-container {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 20px;
        position: relative;
    }
    .profile-pic {
        width: 100%;
        height: auto;
    }

    .name {
        font-size: 24px;
    }

    .default-profile-pic {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: none;
    }
</style>
<body>
<?php include 'user_body.php'; ?>

=======
<?php
include 'user_header.php';
?>
<style>
    .profile-section {
    display: flex;
    align-items: center;
}

.profile-info {
    display: flex;
    align-items: center;
}

.profile-pic-container {
    width: 100px; /* Adjust the width as needed */
    height: 100px; /* Adjust the height as needed */
    border-radius: 50%; /* Make it circular */
    overflow: hidden; /* Ensure the image stays within the circular container */
    margin-right: 20px; /* Adjust the margin as needed */
    position: relative; /* Ensure proper positioning of the default icon */
}

.profile-pic {
    width: 100%;
    height: auto;
}

.name {
    font-size: 24px; /* Adjust the font size as needed */
    /* Add any other styles you want */
}

.default-profile-pic {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    display: none;
}

</style>
<body>
<?php
include 'user_body.php';
?>

>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
<div class="second_header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <a href="user_index.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
        </nav>
    </div>
</div>
<div class="user_settings_section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
<<<<<<< HEAD
                <div class="account-form px-4 py-3" style="margin: 0 auto;">
                    <div class="profile-section mb-">
                        <br><br>
                        <div class="profile-pic-container">
                            <input type="file" id="profile-image-input" name="profile_picture" accept="image/*" onchange="previewImage(this)" style="display: none;">
=======
                <div class="account-form px-4 py-3">
                    <div class="profile-section mb-"><br><br>
                        <div class="profile-pic-container">
                            <input type="file" id="profile-image-input" accept="image/*" onchange="previewImage(this)" style="display: none;">
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
                            <label for="profile-image-input" style="cursor: pointer;">
                                <img id="profile-image-preview" class="profile-pic" src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'images/profile-pic.jpg'; ?>" alt="Profile Picture">
                                <span style="position: absolute; bottom: 5px; right: 5px; background: rgba(255, 255, 255, 0.8); padding: 5px 10px; border-radius: 5px;">Change</span>
                            </label>
                        </div>
                    </div>
<<<<<<< HEAD
                    <form action="update_settings.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmSaveChanges()">
=======

                    <form action="update_settings.php" method="POST">
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
                        <div class="form-group position-relative">
                            <label for="username" class="d-none">Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['firstname'] . ' ' . $user['lastname']; ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="enableEdit('username')">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative">
                            <label for="email" class="d-none">Email:</label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="enableEdit('email')">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative">
                            <label for="contact" class="d-none">Contact Number:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $user['phone_number']; ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="enableEdit('contact')">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative">
                            <label for="address" class="d-none">Address:</label>
                            <div class="input-group">
                                <textarea class="form-control" id="address" name="address" rows="3" readonly><?php echo $user['address']; ?></textarea>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="enableEdit('address')">Edit</button>
                                </div>
                            </div>
                        </div>
<<<<<<< HEAD
                        <button type="submit" class="btn btn-success" id="save_button" style="display:none;margin:0 auto;">Save Changes</button>
                    </form>
                    <div class="logout-btn">
                        <form action="logout.php" method="POST">
                            <button type="submit" class="btn custom-logout-btn">Logout</button>
                        </form>
=======
                        <button type="submit" class="btn btn-success" id="save_button" style="display: none;">Save Changes</button>
                    </form>
                    <div class="logout-btn">
                        <button type="button" class="btn custom-logout-btn">Logout</button>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function enableEdit(fieldId) {
    var field = document.getElementById(fieldId);
    field.removeAttribute('readonly');
    document.getElementById("save_button").style.display = "block";
}

function previewImage(input) {
    var preview = document.getElementById('profile-image-preview');
    var file = input.files[0];
<<<<<<< HEAD
    var allowedTypes = ['image/jpeg', 'image/png'];

    if (file && allowedTypes.includes(file.type)) {
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        reader.readAsDataURL(file);
    } else {
        alert('Only JPEG and PNG formats are allowed.');
        input.value = '';
        preview.src = "images/profile-pic.jpg";
    }
}

function confirmSaveChanges() {
    return confirm('Are you sure you want to save the changes?');
}
=======
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "images/profile-pic.jpg"; // Show placeholder image if no image selected
    }
}
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
</script>

</body>
</html>
