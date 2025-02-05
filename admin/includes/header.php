<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
<?php
// Sidebar-Menu structure -->
$menuItems = [
    [
        "menuTitle" => "User",
        "icon" => "fa-solid fa-user-gear",
        "pages" => [
            ["title" => "Admin", "url" => "index.php"],
            ["title" => "Settings", "url" => "user.php"],
        ],
    ],
    [
        "menuTitle" => "Home",
        "icon" => "fa-solid fa-house",
        "pages" => [
            ["title" => "Banner", "url" => "banner.php"],
            ["title" => "Features", "url" => "features.php"],
        ],
    ],
    [
        "menuTitle" => "About Us",
        "icon" => "fa fa-info-circle",
        "pages" => [
            ["title" => "About", "url" => "about.php"],
            ["title" => "Statistics", "url" => "statistics.php"],
        ],
    ],
    [
        "menuTitle" => "Services",
        "icon" => "fa fa-briefcase",
        "pages" => [
            ["title" => "Our Services", "url" => "ourServices.php"],
            ["title" => "Services", "url" => "services.php"],
        ],
    ],
    [
        "menuTitle" => "Products",
        "icon" => "fa fa-shopping-bag",
        "pages" => [
            ["title" => "Categories", "url" => "category.php"],
            ["title" => "Products", "url" => "products.php"],
        ],
    ],
    [
        "menuTitle" => "Contact",
        "icon" => "fa-solid fa-address-book",
        "pages" => [
            ["title" => "Information", "url" => "contact.php"],
        ],
    ]
];
?>

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

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Logo -->
    <a href="./" class="brand-link">
        <img src="../assets/img/logo.png" alt="Admin Panel Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../assets/img/default.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="./" class="d-block">Iqbolshoh Ilhomjonov</a>
            </div>
        </div>

        <!-- Sidebar menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php foreach ($menuItems as $menuItem): ?>
                    <?php
                    $isActive = false;
                    $isMenuOpen = false;
                    foreach ($menuItem['pages'] as $page) {
                        if ($currentPage === $page['url']) {
                            $isActive = true;
                            $isMenuOpen = true;
                            break;
                        }
                    }
                    ?>
                    <li class="nav-item has-treeview <?= $isMenuOpen ? 'menu-open' : '' ?>">
                        <a class="nav-link <?= $isActive ? 'active' : '' ?>">
                            <i class="nav-icon <?= $menuItem['icon'] ?>"></i>
                            <p>
                                <?= $menuItem['menuTitle'] ?>
                                <?php if (!empty($menuItem['pages'])): ?>
                                    <i class="right fas fa-angle-left"></i>
                                <?php endif; ?>
                            </p>
                        </a>
                        <?php if (!empty($menuItem['pages'])): ?>
                            <ul class="nav nav-treeview">
                                <?php foreach ($menuItem['pages'] as $page): ?>
                                    <li class="nav-item">
                                        <a href="<?= $page['url'] ?>"
                                            class="nav-link <?= $currentPage === $page['url'] ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p><?= $page['title'] ?></p>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<?php
function renderHeader($pageTitle, $breadcrumbItems)
{
    ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <?= $pageTitle; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php foreach ($breadcrumbItems as $item): ?>
                            <?php if ($item['url'] === '#'): ?>
                                <li class="breadcrumb-item active"><?= $item['title']; ?></li>
                            <?php else: ?>
                                <li class="breadcrumb-item"><a href="<?= $item['url']; ?>"><?= $item['title']; ?></a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<script>
    function logout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, log me out!'
        }).then((result) => {
            if (result.value) {
                window.location.href = './logout/';
            }
        });
    }
</script>