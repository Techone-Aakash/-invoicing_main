<body class="sb-nav-fixed";>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Techone Aakash</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <div class="navbar-brand mx-2" style="width:fit-content;">
                <a href="#"><i class="fa fa-bell mx-3 text-white" aria-hidden="true"></i><span class="badge badge-notify">300</span></a>
                <a href="/logout.php"><i class="fa fa-power-off mx-3 text-danger" aria-hidden="true"></i></a>
            </div>
<!--            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul> -->
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark text-white" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading text-white">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt text-danger"></i></div>
                                Dashboard
                            </a>    
                            <a class="nav-link" href="/Analytics.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-line text-warning"></i></div>
                                Analytics
                            </a>                                                    
<!--                             <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open text-white"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a> 
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.php">Login</a>
                                            <a class="nav-link" href="Register.php">Register</a>
                                            <a class="nav-link" href="Trouble.php">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>-->
                            <div class="sb-sidenav-menu-heading text-white">Add-ons</div>
                            <a class="nav-link" href="/profile.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user text-info"></i></div>
                                Edit Profile
                            </a>
                            <a class="nav-link" href="/Add_items.php">
                                <div class="sb-nav-link-icon text-danger"><i class="fab fa-product-hunt"></i></div>
                               All Items
                            </a>

                            <div class="sb-sidenav-menu-heading text-white">Tax Invoice</div>
                            <a class="nav-link" href="/Create_invoice.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-receipt text-primary"></i></div>
                               GST Invoice
                            </a>
                            <a class="nav-link" href="/Invoices.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-invoice text-warning"></i></div>
                                Billed Invoices
                            </a>
                            <div class="sb-sidenav-menu-heading text-white">Sales Invoice</div>
                            <a class="nav-link" href="/sales_invoice.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-invoice-dollar text-primary"></i></div>
                               Sales Invoice
                            </a>  
                            <a class="nav-link" href="/invoices_sales.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-invoice text-warning"></i></div>
                                Billed Invoices
                            </a>                          
                        </div>
                    </div>
                    <div class="sb-sidenav-footer bg-danger font-weight-bold">
                        <div class="small">Logged in as:</div>
                        <?php echo "<label class='text-lg-right font-weight-bold'>".$_SESSION['USERNAME'];"</label>"?>
                    </div>
                </nav>
            </div>
<style type="text/css">
    .badge-notify{
   background:red;
   margin-left: -20px;
   padding: 2px;
   font-size: .75rem;
   position:absolute;
   top:8px;
  }
</style>