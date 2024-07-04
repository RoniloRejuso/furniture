<?php 
session_start();
include 'dbcon.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: user_login.php");
    exit();
}

if (isset($_GET['user_id'])) {
$user_id = $_GET['user_id'];
$query = "SELECT * FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User data not found.";
    exit();
    }   
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


    .button-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    #save_button{
        background-color: #964B33;
        border: transparent;
        color: white;
        padding: 8px 20px;
        cursor: pointer;
        margin-left: 60px;
    }

    #cancel_button {
        background-color: #493A2D;
        border: transparent;
        color: white;
        padding: 8px 20px;
        cursor: pointer;
        margin-right: 80px;
    }
    .custom-logout-btn {
        background-color: #493A2D;
        color: #fff;
    }

    #save_button:hover,
    #cancel_button,
    .custom-logout-btn:hover {
        opacity: 0.7;
    }

</style>
<body>
<?php include 'user_body.php'; ?>

<div class="second_header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <a href="user_product.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Home</a>
        </nav>
    </div>
</div>
<div class="user_settings_section text-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="account-form px-4 py-3" style="margin: 0 auto;">
                    <div class="profile-section mb-3">
                        <div class="profile-pic-container">
                            <input type="file" id="profile-image-input" name="profile_picture" accept="image/*" onchange="previewImage(this)" style="display: none;">
                            <label for="profile-image-input" style="cursor: pointer;">
                                <img id="profile-image-preview" class="profile-pic" src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'images/profile-pic.jpg'; ?>" alt="Profile Picture">
                            </label>
                        </div>
                    </div>
                    
                    <form id="user-settings-form" action="update_settings.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmSaveChanges(event)">
                        <div class="form-group position-relative" id="name-group">
                            <label for="username" class="d-none">Name:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['firstname'] . ' ' . $user['lastname']; ?>" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="splitName()">Edit</button>
                                </div>
                            </div>
                        </div>
                        <div id="split-name-group" style="display: none;">
                            <div class="form-group position-relative">
                                <label for="firstname" class="d-none">First Name:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="enableEdit('firstname')">Edit</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group position-relative">
                                <label for="lastname" class="d-none">Last Name:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $user['lastname']; ?>" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="enableEdit('lastname')">Edit</button>
                                    </div>
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
                        <div class="button-container mb-1">
                            <button type="submit" class="btn btn-success" id="save_button" style="display:none;">Save Changes</button>
                            <button type="button" class="btn btn-secondary" id="cancel_button" onclick="cancelChanges()" style="display:none;"><i class="fas fa-times"></i></button>
                        </div>
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
    // Trim leading and trailing spaces
    if (fieldId === 'firstname' || fieldId === 'lastname') {
        field.value = field.value.trim();
    }
    // Show save and cancel buttons
    document.getElementById("save_button").style.display = "block";
    document.getElementById("cancel_button").style.display = "block";
}

function cancelChanges() {
    var username = document.getElementById('username');
    var firstname = document.getElementById('firstname');
    var lastname = document.getElementById('lastname');
    var email = document.getElementById('email');
    var contact = document.getElementById('contact');
    var address = document.getElementById('address');
    
    // Reset fields to original values
    username.value = "<?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?>";
    firstname.value = "<?php echo htmlspecialchars($user['firstname']); ?>";
    lastname.value = "<?php echo htmlspecialchars($user['lastname']); ?>";
    email.value = "<?php echo htmlspecialchars($user['email']); ?>";
    contact.value = "<?php echo htmlspecialchars($user['phone_number']); ?>";
    address.value = "<?php echo htmlspecialchars($user['address']); ?>";

    // Disable edit mode and hide save/cancel buttons
    document.getElementById("save_button").style.display = "none";
    document.getElementById("cancel_button").style.display = "none";
    document.getElementById("split-name-group").style.display = "none";
    document.getElementById("name-group").style.display = "block";
    document.getElementById("firstname").setAttribute('readonly', 'readonly');
    document.getElementById("lastname").setAttribute('readonly', 'readonly');
    document.getElementById("email").setAttribute('readonly', 'readonly');
    document.getElementById("contact").setAttribute('readonly', 'readonly');
    document.getElementById("address").setAttribute('readonly', 'readonly');
}

function confirmSaveChanges(event) {
    event.preventDefault(); // Prevent default form submission

    // Validate first name and last name
    var firstname = document.getElementById('firstname').value.trim();
    var lastname = document.getElementById('lastname').value.trim();

    if (firstname === '' || lastname === '') {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please enter both first name and last name!',
        });
        return;
    }

    // Further validations can be added here if needed

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to save the changes?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#964B33',
        cancelButtonColor: '#493A2D',
        confirmButtonText: 'Save Changes'
    }).then((result) => {
        if (result.isConfirmed) {
            combineNames(); // Combine the names before submitting the form
            document.getElementById('user-settings-form').submit(); // Submit the form
        }
    });
}

function splitName() {
    var username = document.getElementById('username');
    var nameGroup = document.getElementById('name-group');
    var splitNameGroup = document.getElementById('split-name-group');
    var fullName = username.value.split(' ');
    var firstName = fullName.slice(0, -1).join(' ');
    var lastName = fullName.slice(-1).join(' ');

    document.getElementById('firstname').value = firstName;
    document.getElementById('lastname').value = lastName;

    nameGroup.style.display = 'none';
    splitNameGroup.style.display = 'block';
    enableEdit('firstname');
    enableEdit('lastname');
}

function combineNames() {
    var firstName = document.getElementById('firstname').value;
    var lastName = document.getElementById('lastname').value;
    document.getElementById('username').value = firstName + ' ' + lastName;
}

function previewImage(input) {
    var preview = document.getElementById('profile-image-preview');
    var file = input.files[0];
    var allowedTypes = ['image/jpeg'];

    if (file && allowedTypes.includes(file.type)) {
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        reader.readAsDataURL(file);
    } else {
        alert('Only JPEG formats are allowed.');
        input.value = '';
        preview.src = "images/profile-pic.jpg";
    }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
