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
                </div>
            </div>
        </nav>

        <script type="text/javascript">
            // var connection = new WebSocket('ws://localhost:62183');
            // connection.onmessage = function(e) {
            //     location.reload();
            // };
        </script>

        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">

                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <a class="navbar-brand" href="#">
                    <img src="/img/uhppote.png" height="30" alt="" loading="lazy" />
                </a>

                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <a class="nav-link hidden-arrow d-flex align-items-center" href="/Logout" id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                        Logout
                    </a>
                </ul>
            </div>
        </nav>
    </header>
    <!--Main Navigation-->
    <main style="margin-top: 58px">
        <div class="container pt-5">