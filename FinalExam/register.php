<?php
require "includes/connect.php";
require "includes/header.php";

// set up variables
$errors = [];
$success = "";
$username = "";
$email = "";

// only process when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // validation
    if ($username === '') {
        $errors[] = "Username is required!";
    }

    if ($email === '') {
        $errors[] = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Must be a valid email address!";
    }

    if ($password === '') {
        $errors[] = "Password is required!";
    }

    if ($confirmPassword === '') {
        $errors[] = "Please confirm your password!";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match!";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // check if username or email already exists
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users1 WHERE username = :username OR email = :email");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email
        ]);

        $existingUser = $stmt->fetch();

        if ($existingUser) {
            $errors[] = "Username or email already exists!";
        }
    }

    // insert user if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users1 (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashedPassword
        ]);

        $success = "Account created successfully!";
        $username = "";
        $email = "";
    }
}
?>

<main>
    <h2>Sign Up</h2>
    
    <!-- display errors -->
    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- success message -->
    <?php if ($success): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>

    <!-- registration form -->
    <form method="post" >

        <label for="username" ">Username</label>
        <input
            type="text"
            id="username"
            name="username"
            class="form-control mb-3"
            value="<?= htmlspecialchars($username); ?>"
            required
        >

        <label for="email" >Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control mb-3"
            value="<?= htmlspecialchars($email); ?>"
            required
        >

        <label for="password" >Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-3"
            required
        >

        <label for="confirm_password" >Confirm Password</label>
        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
            class="form-control mb-3"
            required
        >

        <button type="submit" >Create Account</button>
        <a href="login.php" >Login Instead</a>
    </form>
</main>


