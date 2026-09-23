<?php require 'config.php';
if (!empty($_SESSION['u'])) {
    header('Location: dashboard.php');
    exit;
}
$err = '';
if ($_POST) {
    $s = $pdo->prepare("SELECT * FROM staff WHERE email=? AND active=1");
    $s->execute([trim($_POST['email'])]);
    $u = $s->fetch();
    if ($u && password_verify($_POST['password'], $u['password'])) {
        session_regenerate_id(true);
        $_SESSION['u'] = ['id' => $u['id'],'name' => $u['name'],'role' => $u['role']];
        header('Location: dashboard.php');
        exit;
    }
    $err = 'Wrong email or password, or the account is deactivated.';
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | Visitor Pass</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login">
    <form method="post" class="lf card">
        <div class="lf-head">
            <span class="mark">VP</span>
            <h1>Smart Visitor Pass</h1>
        </div>
        <p class="muted">Sign in to the gate system</p>
        <?php if ($err) { ?>
            <div class="msg bad"><?=h($err)?></div>
        <?php } ?>
        <label>
            Email
            <input type="email" name="email" placeholder="you@company.com" required autofocus>
        </label>
        <label>
            Password
            <input type="password" name="password" placeholder="Your password" required>
        </label>
        <button>Sign in</button>
    </form>
</body>
</html>
