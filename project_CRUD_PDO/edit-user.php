<?php
session_start();
require_once('./includes/header.php');

if (!$pdo) {
    echo "You are not connected";
}

$updateSuccess = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header("Location:index.php");
} else {
    $id = $_POST['edi'];
    $sql = "SELECT * FROM users WHERE user_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_id = $user['user_id'];
        $user_name = $user['user_name'];
        $user_email = $user['user_email'];
        $user_password = $user['user_password'];
    }
}

if (isset($_POST['submit'])) {
    $user_id = $_POST['edi'];
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
        $sql = "UPDATE users SET user_name = :name, user_email = :email, user_password = :password WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':name' => $user_name,
            ':email' => $user_email,
            ':password' => $user_password,
            ':id' => $user_id,
        ]);
        $updateSuccess = true;
        $_SESSION['updateSuccess'] = "User updated successfully!";
        header("Location:index.php");
    }
}
?>
<div class="container mt-5">
    <form action="edit-user.php" method="post">
        <input type="hidden" name="edi" value="<?= $user_id ?>">
        <div class="form-floating mb-3">
            <input type="text"
                class="form-control <?php echo (isset($errors['user_name']) && $errors['user_name']) ? 'is-invalid' : ''; ?>"
                id="userName" placeholder="Username" name="user_name" value="<?= $user_name ?>">
            <label for="userName">Username<span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-3">
            <input type="email"
                class="form-control <?php echo (isset($errors['user_email']) && $errors['user_email']) ? 'is-invalid' : ''; ?>"
                id="userEmail" placeholder="Email" name="user_email" value="<?= $user_email ?>">
            <label for="userEmail">Email<span class="text-danger">*</span></label>
        </div>

        <div class="form-floating mb-3">
            <input type="password"
                class="form-control <?php echo (isset($errors['user_password']) && $errors['user_password']) ? 'is-invalid' : ''; ?>"
                id="UserPassword" placeholder="Password" name="user_password" value="<?= $user_password ?>">
            <label for="UserPassword">Password<span class="text-danger">*</span></label>
        </div>

        <div>
            <input type="submit" name="submit" class="btn btn-primary btn-block" value="Update" />
        </div>
    </form>
</div>
<?php require_once('./includes/footer.php') ?>