<header class="config" id="top">
    <div class="container-fluid top-nav">
        <div class="margin-side">
            <div class="top-navbar-content">
                <p>Date Today: <?php date_default_timezone_set('Asia/Manila');
                                echo  date("F d, Y"); ?></p>
                <?php if (isset($_SESSION['username'])) { ?>
                    <p>Hi, <?php echo  $_SESSION['username']; ?></p>
                <?php  } ?>
            </div>
        </div>
    </div>
    <div class="container-fluid logo-side-nav">
        <div class="margin-side">
            <div class="logo-content-side">
                <div style="display: flex;">
                    <img src="../../assets/newsassets/logo.jpg" class="logo-img">
                    <h1 class="logo-text">GA<span style="color: #FFC000">ZSE</span>NT</h1>
                </div>
                <div>
                    <a href="logout.php">Sign out</a><span style="margin:0 10px">|</span>
                    <a href="adminmyaccount.php">My Account</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid navbar-main-container">
        <div class="margin-side">
            <div class="main-nav-bar">
                <ul class="navlist-item">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link">Dashboard</a></li>
                    <li class="nav-item">
                        <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Manage News
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($_SESSION['validator'] !== "1") { ?>
                                <li><a class="dropdown-item" href="create_news.php">Create a news</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="news_list.php">News list</a></li>
                            <li><a class="dropdown-item" href="unpublish_news.php">Unpublished news</a></li>
                        </ul>
                    </li>
                    <?php if ($_SESSION['role'] === '1') { ?>
                        <li class="nav-item">
                            <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Manage Writers
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="register.php">Add writers</a></li>
                                <li><a class="dropdown-item" href="view_writers.php">View writers</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Manage Moderator
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="register.php?mode=moderator">Add Moderator</a></li>
                                <!-- <li><a class="dropdown-item" href="view_writers.php">View writers</a></li> -->
                            </ul>
                        </li>
                        <li class="nav-item"><a href="users.php" class="nav-link">Users</a></li>
                        <li class="nav-item"><a href="category.php" class="nav-link">Category</a></li>
                    <?php } ?>
                    <li class="nav-item"><a href="assets.php" target="_blank" class="nav-link">Assets</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>