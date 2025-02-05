<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<?php
// Count the number of unchecked messages
$count = (new Database())->eQuery("SELECT COUNT(*) AS no_checked_count FROM messages WHERE status = 'no_checked';")[0]['no_checked_count'];
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="./" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a onclick="logout()" class="nav-link">Logout</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" href="messages.php">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge" <?php echo $count === 0 ? 'style="display: none;"' : ''; ?>>
                    <?php echo $count; ?>
                </span>
            </a>
        </li>
    </ul>
</nav>