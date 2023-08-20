<?php
session_start();
require_once('./includes/header.php');

if (!$link) {
    echo "You are not connected";
}

$updateSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location:index.php");
} else {
    $user_id = $_POST['edi'];
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_stmt_init($link);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die('Query Failed');
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
        }
    }
}

if (isset($_POST['submit'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    if (empty($user_name)) {
        $errors['user_name'] = true;
    }
    if (empty($user_email)) {
        $errors['user_email'] = true;
    }
    if (empty($user_password)) {
        $errors['user_password'] = true;
    } else {
        $sql = "UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?";
        $stmt = mysqli_stmt_init($link);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            die("Query Failed");
        } else {
            mysqli_stmt_bind_param($stmt, 'sssi', $user_name, $user_email, $user_password, $user_id);
            mysqli_stmt_execute($stmt);
            $updateSuccess = true;
            $_SESSION['updateSuccess'] = "User updated successfully!";
            header("Location:index.php");
            exit();
        }
    }
}
?>
<div class="container mt-5">
    <?php if ($updateSuccess) : ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['updateSuccess']; ?>
        </div>
        <?php unset($_SESSION['updateSuccess']); ?>
    <?php endif; ?>

    <form action="edit-user.php" method="post">
        <input type="hidden" name="edi" value="<?= $user_id ?>">
        <div class="form-floating mb-3">
            <input type="text" class="form-control <?php echo (isset($errors['user_name']) && $errors['user_name']) ? 'is-invalid' : ''; ?>" id="userName" placeholder="Username" name="user_name" value="<?= $user_name ?>">
            <label for="userName">Username<span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-3">
            <input type="email" class="form-control <?php echo (isset($errors['user_email']) && $errors['user_email']) ? 'is-invalid' : ''; ?>" id="userEmail" placeholder="Email" name="user_email" value="<?= $user_email ?>">
            <label for="userEmail">Email<span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-3">
            <input type="password" class="form-control <?php echo (isset($errors['user_password']) && $errors['user_password']) ? 'is-invalid' : ''; ?>" id="UserPassword" placeholder="Password" name="user_password" value="<?= $user_password ?>">
            <label for="UserPassword">Password<span class="text-danger">*</span></label>
        </div>

        <div>
            <input type="submit" name="submit" class="btn btn-primary btn-block" value="Update" />
        </div>
    </form>
</div>
<?php require_once('./includes/footer.php') ?>