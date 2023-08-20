<?php require_once('./includes/header.php'); ?>
<?php
if (isset($_COOKIE['_ua_'])) {
    header("Location: index.php");
    exit();
}
$errors = [];
if (isset($_POST['submit'])) {
    $user_name = trim($_POST["user_name"]);
    $user_email = trim($_POST["user_email"]);
    $user_password = trim($_POST["user_password"]);

    if (empty($user_name)) {
        $errors['user_name'] = true;
    }
    if (empty($user_email)) {
        $errors['user_email'] = true;
    }
    if (empty($user_password)) {
        $errors['user_password'] = true;
    }
    if (empty($errors)) {
        
        $sql = "SELECT * FROM users WHERE user_email = :user_email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':user_email' => $user_email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($user_password, $user['user_password'])) {
            setcookie('_ua_', md5(1), time() + 60 * 20, '', '', '', true);
            header("Location: index.php");
            exit();
        } else {
            $errors['login_fail'] = true;
        }
    }
}

?>

<div class="c container">
    <h2 class="text-uppercase mt-5 sign-in" style="text-align:center">Sign In</h2>

    <?php if (isset($errors['login_fail'])) : ?>
    <div class='alert alert-danger'>Wrong credentials!</div>
    <?php endif; ?>

    <form method="POST" action="sign-in.php" class="py-2 d-flex justify-content-center flex-column">
        <div class="form-group m-3">
            <label for="username">Username</label>
            <input type="text" name="user_name"
                class="form-control <?php echo (isset($errors['user_name']) && $errors['user_name']) ? 'is-invalid' : ''; ?>"
                id="username" placeholder="Enter Username">
        </div>
        <div class="form-group m-3">
            <label for="email">Email address</label>
            <input type="email" name="user_email"
                class="form-control  <?php echo (isset($errors['user_email']) && $errors['user_email']) ? 'is-invalid' : ''; ?>"
                id="email" placeholder="Enter Email Address">
        </div>
        <div class="form-group m-3">
            <label for="password">Password</label>
            <input type="password" name="user_password"
                class="form-control  <?php echo (isset($errors['user_password']) && $errors['user_password']) ? 'is-invalid' : ''; ?>"
                id="password" placeholder="Enter Password">
        </div>
        <button type="submit" name="submit" class="btn btn-primary m-3 align-self-end">SIGN IN</button>
    </form>
</div>

<?php require_once('./includes/footer.php'); ?>