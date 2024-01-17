<?php

require_once "../../classes/category_class.php";

$category = new Category;

$list = $category->getCategoryList();

?>
<style>
    #categoryDropdown::-webkit-scrollbar {
        display: none;
    }
</style>
<header id="top">
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
                    <form action="search.php" method="get">
                        <input required type="text" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>" name="search" id="">
                        <button type="submit">Search</button>
                    </form>
                </div>
                <?php if (isset($_SESSION['username'])) { ?>
                    <div>
                        <a href="../adminpanel/logout.php">Sign out</a>
                        <span>|</span>
                        <a href="myaccount.php">My Account</a>
                    </div>
                <?php } else { ?>
                    <div>
                        <a href="login.php">Sign in</a>
                        <span>|</span>
                        <a href="register1.0.php">Sign up</a>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
    <div class="container-fluid navbar-main-container">
        <div class="margin-side">
            <div class="main-nav-bar">
                <ul class="navlist-item">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] !== '2' && $_SESSION['role'] !== '5' ){?>
                        <li class="nav-item"><a href="../adminpanel/dashboard.php" class="nav-link">Dashboard</a></li>
                    <?php }?>
                    <li class="nav-item active"><a href="../../" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="news.php" class="nav-link">News</a></li>
                    <li class="nav-item"><a href="featurednews.php" class="nav-link">Featured News</a></li>
                    <li class="nav-item">
                        <a class="dropdown-toggle nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Category
                        </a>
                        <ul class="dropdown-menu" id="categoryDropdown" style="height: 200px;overflow:auto">
                            <?php

                            foreach ($list as $item) {
                                echo '<li><a class="dropdown-item" href="category.php?id=' . $item['id'] . '&title=' . $item['title'] . '">' . $item['title'] . '</a></li>';
                            }

                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>