<body>
    <!--Main Navigation-->
    <header>
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <?php
                    $pages = glob($_SERVER['DOCUMENT_ROOT'] . "/resources/views/*.php");
                    foreach ($pages as $page) {
                        $page       = pathinfo($page);
                        $pageName   = ucwords(str_replace('_', ' ', explode('.', $page['basename'])[0]));
                        $pageDir    = explode('.', $page['basename'])[0];
                        echo '<a href="/admin/' . $pageDir . '" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-bar fa-fw me-3"></i><span>' . $pageName . '</span></a>';
                    }
                    ?>
                    <!-- <a href="#" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                        <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span>Webiste traffic </span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-lock fa-fw me-3"></i><span>Password</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-line fa-fw me-3"></i><span>Analytics</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-pie fa-fw me-3"></i><span>SEO</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-bar fa-fw me-3"></i><span>Orders</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-globe fa-fw me-3"></i><span>International</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-building fa-fw me-3"></i><span>Partners</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-calendar fa-fw me-3"></i><span>Calendar</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-users fa-fw me-3"></i><span>Users</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-money-bill fa-fw me-3"></i><span>Sales</span></a> -->
                </div>
            </div>
        </nav>

        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <a class="navbar-brand" href="#">
                    <img src="/img/uhppote.png" height="30" alt="" loading="lazy" />
                </a>

                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg" class="rounded-circle" height="22" alt="" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#">My profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!--Main Navigation-->
    <main style="margin-top: 58px">
        <div class="container pt-4">