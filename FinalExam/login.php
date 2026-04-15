<?php
//starts session
session_start();

//connects to database 
require "includes/connect.php";

$error = '';

//check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    //collect and sanitize user input
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    //check required feilds
    if ($usernameOrEmail === '' || $password === ''){
        $error = "Username/email and password are required!";
    }
    else {
        //SQL query to find a user by username or email
        $sql = "SELECT id, username, email, password
                FROM users1
                WHERE username = :login OR email = :login
                LIMIT 1";

        //prepare the statement        
        $stmt = $pdo->prepare($sql);

        //bind the input value
        $stmt->bindParam(':login', $usernameOrEmail);

        //execute the query
        $stmt->execute();

        //fetch the user from the databaase
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        //verify password
        if ($user && password_verify($password, $user['password'])) {

            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            //redirect to main page
            header("Location: index.php");
            exit;

        } 
        else {
            $error = "Invalid information. Please try again!";
        }
    }
}
?>

<main>
    <h2>Login</h2>

    <!-- error message -->
    <?php if ($error !== ""): ?>
            <?= htmlspecialchars($error); ?>
    <?php endif; ?>

    <!-- login form -->
    <form method="post">
        <label for="username_or_email">Username or Email</label>
        <input
            type="text"
            id="username_or_email"
            name="username_or_email"
            class="form-control mb-3"
            required
        >

        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-4"
            required
        >

        <button type="submit">Login</button>
        <br>
        <a href="register.php">Create Account</a>
    </form>
</main>


    