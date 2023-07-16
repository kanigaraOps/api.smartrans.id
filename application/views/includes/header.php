<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Smartrans-Admin Panel</title>
    <!-- plugins:css -->


    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/jquery-bar-rating/dist/themes/fontawesome-stars.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/pwstabs/assets/jquery.pwstabs.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/icheck/skins/all.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/dragula/dist/dragula.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/quill/dist/quill.snow.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/simplemde/dist/simplemde.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/style.css">

    <!-- endinject -->
    <link rel="shortcut icon" href="<?= base_url(); ?>asset/images/logo.png" />

    <style type="text/css">
        @media screen and (max-width: 500px) {
            #mobileshow {
                display: none;
            }
        }
    </style>

</head>

<body>

    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>asset/images/logo_dashboard.png" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>asset/images/logo.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>

                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <div class="row row-offcanvas row-offcanvas-right">
                <!-- partial:../../partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <div class="nav-link">
                                <div class="profile-image">
                                    <img src="<?= base_url(); ?>images/admin/<?= $this->session->userdata('image') ?>" onerror="this.onerror=null;this.src='<?= base_url(); ?>asset/images/logo.png';" />
                                    <span class="online-status online"></span>
                                    <!--change class online to offline or busy as needed-->
                                </div>
                                <div class="profile-name">
                                    <p class="name">
                                        <?= $this->session->userdata('nama') ?>
                                    </p>
                                    <p class="designation">
                                    <?= $this->session->userdata('role') ?>
                                    </p>
                                </div>
                            </div>
                        </li>

                        <?php if($this->session->userdata('role') == 'super admin'){?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>">
                                <i class="icon-rocket menu-icon"></i>
                                <span class="menu-title">Dashboard</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transaction" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Now</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transaction">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Transaction Ride Now</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Jurnal Ride Now</a></li>
                                     <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction/laporan_ap">Laporan AP</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transactionltr" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Later</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transactionltr">
                                <ul class="nav flex-column sub-menu">           
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr">Transaction Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal/later">Jurnal Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction/addberkah">Input Berkah</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/parammargin">Parameter Margin Shuttle</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/rekonshuttle">Rekon Shuttle</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transactionkurir" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Smart Kurir</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transactionkurir">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Transaction Smart Kurir</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Jurnal Kurir</a></li> 
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transactionfood" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Smart Food</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transactionfood">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Transaction Food</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Jurnal Food</a></li> 
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Finance</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="tables">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet">Wallet</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet/tambahtopup">Manual Top Up</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet/tambahwithdraw">Manual Withdraw</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false" aria-controls="drivers">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Drivers</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="drivers">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver">Drivers</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>newregistration">New Registration Driver</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver">Tracking Driver Car</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver_bike">Tracking Driver Bike</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>users">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#tables2" aria-expanded="false" aria-controls="tables2">
                                <i class="icon-basket-loaded menu-icon"></i>
                                <span class="menu-title">Merchant</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="tables2">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>categorymerchant">Merchant Category</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra">All Merchant</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra/newregmitra">New Registration Merchant</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#service" aria-expanded="false" aria-controls="tables2">
                                <i class="icon-layers menu-icon"></i>
                                <span class="menu-title">Service</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="service">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>services">Service</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>partnerjob">Vehicle Type</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#harting" aria-expanded="false" aria-controls="tables2">
                                <i class="icon-layers menu-icon"></i>
                                <span class="menu-title">Harting</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="harting">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>harting">Distance</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>promocode">
                                <i class="icon-tag menu-icon"></i>
                                <span class="menu-title">Promo Code</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>promoslider">
                                <i class="icon-screen-smartphone menu-icon"></i>
                                <span class="menu-title">Slider</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>news">
                                <i class="icon-docs menu-icon"></i>
                                <span class="menu-title">News</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>sendemail">
                                <i class="icon-envelope-letter menu-icon"></i>
                                <span class="menu-title">Send Email</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>appnotification">
                                <i class="icon-paper-plane menu-icon"></i>
                                <span class="menu-title">App Notification</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#movic" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Travelin Setups</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="movic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/addpricetravelin">Add Zona</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/tariftravelin">Zona</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#movic" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">MOVIC Setups</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="movic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/addprice">Add Tarif</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/addzona">Add Zona</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/zonaMovic">List Zona</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/tarifMovic">MPV ALLIN</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/tarifMovicBasic">MPV Basic</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#basicsetup" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Basic Setups</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="basicsetup">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>appsettings">App Settings</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area">Country Area</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>area/pricecards">Price Cards</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction/terminal">Setup AP</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>profile">
                                <i class="icon-user-following menu-icon"></i>
                                <span class="menu-title">Profile</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#subadmin" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Sub Admin</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="subadmin">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>profile/list">List Sub Admin</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>profile/tambah">New Registration</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>login/logout">
                                <i class="icon-logout menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </li>
                        <?php }elseif($this->session->userdata('role') == 'admin'){?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>">
                                <i class="icon-rocket menu-icon"></i>
                                <span class="menu-title">Dashboard</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transaction" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Now</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transaction">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Transaction Ride Now</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Jurnal Ride Now</a></li> 
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transactionltr" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Later</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transactionltr">
                                <ul class="nav flex-column sub-menu">                                    
                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr">Transaction Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal/later">Jurnal Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction/addberkah">Input Berkah</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/parammargin">Parameter Margin Shuttle</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/rekonshuttle">Rekon Shuttle</a></li>
                                </ul>
                            </div>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Finance</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="tables">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet">Wallet</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet/tambahwithdraw">Manual Withdraw</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false" aria-controls="drivers">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Drivers</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="drivers">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver">Drivers</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>newregistration">New Registration Driver</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver">Tracking Driver Car</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver_bike">Tracking Driver Bike</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>users">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#tables2" aria-expanded="false" aria-controls="tables2">
                                <i class="icon-basket-loaded menu-icon"></i>
                                <span class="menu-title">Merchant</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="tables2">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>categorymerchant">Merchant Category</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra">All Merchant</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra/newregmitra">New Registration Merchant</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#subadmin" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Sub Admin</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="subadmin">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>profile/list">List Sub Admin</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>profile/tambah">New Registration</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>login/logout">
                                <i class="icon-logout menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </li>
                        <?php } elseif($this->session->userdata('role') == 'operator'){?>
                            <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>">
                                <i class="icon-rocket menu-icon"></i>
                                <span class="menu-title">Dashboard</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transaction" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Now</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transaction">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Transaction Ride Now</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Jurnal Ride Now</a></li> 
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transactionltr" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Later</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transactionltr">
                                <ul class="nav flex-column sub-menu">           
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr">Transaction Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal/later">Jurnal Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction/addberkah">Input Berkah</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/parammargin">Parameter Margin Shuttle</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/rekonshuttle">Rekon Shuttle</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false" aria-controls="drivers">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Drivers</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="drivers">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver">Drivers</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver">Tracking Driver Car</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver_bike">Tracking Driver Bike</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>users">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Users</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>login/logout">
                                <i class="icon-logout menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </li>
                        <?php }elseif($this->session->userdata('role') == 'finance'){?>
                            <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transaction" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Now</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transaction">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Transaction Ride Now</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Jurnal Ride Now</a></li> 
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#transactionltr" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Transaction Ride Later</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="transactionltr">
                                <ul class="nav flex-column sub-menu">                                    

                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr">Transaction Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal/later">Jurnal Ride Later</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction/addberkah">Input Berkah</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/parammargin">Parameter Margin Shuttle</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transactionltr/rekonshuttle">Rekon Shuttle</a></li>
                                </ul>
                            </div>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Finance</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="tables">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet">Wallet</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet/tambahwithdraw">Manual Withdraw</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false" aria-controls="drivers">
                                <i class="icon-people menu-icon"></i>
                                <span class="menu-title">Drivers</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="drivers">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver">Drivers</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>newregistration">New Registration Driver</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver">Tracking Driver Car</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver_bike">Tracking Driver Bike</a></li>
                                </ul>
                            </div>
                        </li>
                        
                        <?php } ?> 
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#akun" aria-expanded="false" aria-controls="tables">
                                <i class="icon-wallet menu-icon"></i>
                                <span class="menu-title">Akun</span>
                                <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                            </a>
                            <div class="collapse" id="akun">
                                <ul class="nav flex-column sub-menu">                                    
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>transaction">Tambahkan Akun</a></li>
                                    <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>trxjurnal">Ubah Akun</a></li> 
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>login/logout">
                                <i class="icon-logout menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </li>

                    </ul>
                </nav> 