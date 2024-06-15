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
                <div class="account-form px-4 py-3" style="margin: 0 auto;">
                    <div class="profile-section mb-">
                        <br><br>
                        <div class="profile-pic-container">
                            <input type="file" id="profile-image-input" name="profile_picture" accept="image/*" onchange="previewImage(this)" style="display: none;">
                            <label for="profile-image-input" style="cursor: pointer;">
                                <img id="profile-image-preview" class="profile-pic" src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'images/profile-pic.jpg'; ?>" alt="Profile Picture">
                                <span style="position: absolute; bottom: 5px; right: 5px; background: rgba(255, 255, 255, 0.8); padding: 5px 10px; border-radius: 5px;">Change</span>
                            </label>
                        </div>
                    </div>
                    <form action="update_settings.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmSaveChanges()">
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
                        <button type="submit" class="btn btn-success" id="save_button" style="display:none;margin:0 auto;">Save Changes</button>
                    </form>
                    <div class="logout-btn">
                        <form action="logout.php" method="POST">
                            <button type="submit" class="btn custom-logout-btn">Logout</button>
                        </form>
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
</script>

</body>
</html>
