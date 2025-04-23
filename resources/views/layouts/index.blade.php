 <!DOCTYPE html>
 <html lang="en">
 
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tafis Application</title>

    {{-- site favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendor/images/logoLws.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendor/images/lws-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendor/images/lws-16x16.png') }}">
    {{-- mobile specific metas --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    {{-- css --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/styles/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 
     @yield('head')
     
 </head>
 
 <body>
    @include('sweetalert::alert')
     <div class="header">
         <div class="header-left">
             <div class="menu-icon dw dw-menu"></div>
             <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
             <div class="header-search">
                 <form>
                     <div class="form-group mb-0">
                         <i class="dw dw-search2 search-icon"></i>
                         <input type="text" class="form-control search-input" placeholder="Search Here">
                         <div class="dropdown">
                             <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                 <i class="ion-arrow-down-c"></i>
                             </a>
                             <div class="dropdown-menu dropdown-menu-right">
                                 <div class="form-group row">
                                     <label class="col-sm-12 col-md-2 col-form-label">From</label>
                                     <div class="col-sm-12 col-md-10">
                                         <input class="form-control form-control-sm form-control-line" type="text">
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                     <div class="col-sm-12 col-md-10">
                                         <input class="form-control form-control-sm form-control-line" type="text">
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                                     <div class="col-sm-12 col-md-10">
                                         <input class="form-control form-control-sm form-control-line" type="text">
                                     </div>
                                 </div>
                                 <div class="text-right">
                                     <button class="btn btn-primary">Search</button>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
         <div class="header-right">
             <div class="dashboard-setting user-notification">
                 <div class="dropdown">
                     <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                         <i class="dw dw-settings2"></i>
                     </a>
                 </div>
             </div>
 
             <div class="user-info-dropdown">
                 <div class="dropdown">
                     <a class="dropdown-toggle" href="" role="" data-toggle="dropdown">
                         <!-- <span class="user-icon">
                             <img src="vendors/images/photo1.jpg" alt="">
                         </span> -->
                         <span class="style1">
                             <p></p>
                             Welcome, {{ Session::get('nama') . ' - ' . Session::get('kdBranch') }}
                         </span>
                     </a>
                     <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                         <form action="{{ route('logout') }}" method="get">
                             @csrf
                             @method('DELETE')
                             <button class="dropdown-item" type="submit"><i class="dw dw-logout"></i>Logout</button>
                         </form>
                     </div>
                 </div>
             </div>
             <div class="github-link">
                 <a><img src="{{ asset('vendor/images/lws.png') }}" alt=""></a>
             </div>
         </div>
     </div>
 
     <div class="right-sidebar">
         <div class="sidebar-title">
             <h3 class="weight-600 font-16 text-blue">
                 Layout Settings
                 <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
             </h3>
             <div class="close-sidebar" data-toggle="right-sidebar-close">
                 <i class="icon-copy ion-close-round"></i>
             </div>
         </div>
         <div class="right-sidebar-body customscroll">
             <div class="right-sidebar-body-content">
                 <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                 <div class="sidebar-btn-group pb-30 mb-10">
                     <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                     <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                 </div>
 
                 <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                 <div class="sidebar-btn-group pb-30 mb-10">
                     <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light ">White</a>
                     <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                 </div>
 
                 <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                 <div class="sidebar-radio-group pb-10 mb-10">
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon"
                             class="custom-control-input" value="icon-style-1" checked="">
                         <label class="custom-control-label" for="sidebaricon-1"><i
                                 class="fa fa-angle-down"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon"
                             class="custom-control-input" value="icon-style-2">
                         <label class="custom-control-label" for="sidebaricon-2"><i
                                 class="ion-plus-round"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon"
                             class="custom-control-input" value="icon-style-3">
                         <label class="custom-control-label" for="sidebaricon-3"><i
                                 class="fa fa-angle-double-right"></i></label>
                     </div>
                 </div>
 
                 <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                 <div class="sidebar-radio-group pb-30 mb-10">
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebariconlist-1" name="menu-list-icon"
                             class="custom-control-input" value="icon-list-style-1" checked="">
                         <label class="custom-control-label" for="sidebariconlist-1"><i
                                 class="ion-minus-round"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebariconlist-2" name="menu-list-icon"
                             class="custom-control-input" value="icon-list-style-2">
                         <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                                 aria-hidden="true"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebariconlist-3" name="menu-list-icon"
                             class="custom-control-input" value="icon-list-style-3">
                         <label class="custom-control-label" for="sidebariconlist-3"><i
                                 class="dw dw-check"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebariconlist-4" name="menu-list-icon"
                             class="custom-control-input" value="icon-list-style-4" checked="">
                         <label class="custom-control-label" for="sidebariconlist-4"><i
                                 class="icon-copy dw dw-next-2"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebariconlist-5" name="menu-list-icon"
                             class="custom-control-input" value="icon-list-style-5">
                         <label class="custom-control-label" for="sidebariconlist-5"><i
                                 class="dw dw-fast-forward-1"></i></label>
                     </div>
                     <div class="custom-control custom-radio custom-control-inline">
                         <input type="radio" id="sidebariconlist-6" name="menu-list-icon"
                             class="custom-control-input" value="icon-list-style-6">
                         <label class="custom-control-label" for="sidebariconlist-6"><i
                                 class="dw dw-next"></i></label>
                     </div>
                 </div>
 
                 <div class="reset-options pt-30 text-center">
                     <button class="btn btn-danger" id="reset-settings">Reset Settings</button>
                 </div>
             </div>
         </div>
     </div>
 
     <div class="left-side-bar">
         <div class="brand-logo">
             <a href="">
                 <img src="{{ asset('vendor/images/tafis-logo.png') }}" alt="" class="dark-logo">
                 <img src="{{ asset('vendor/images/tafis-logo-white.png') }}" alt="" class="light-logo">
             </a>
             <div class="close-sidebar" data-toggle="left-sidebar-close">
                 <i class="ion-close-round"></i>
             </div>
         </div>
         <div class="menu-block customscroll">
             <div class="sidebar-menu">
                 <ul id="accordion-menu">
                     <li class="dropdown">
                         {{-- <a href="javascript:;" class="dropdown-toggle">
                             <span class="micon dw dw-analytics-5"></span><span class="mtext style1">T A X</span>
                         </a> --}}
                         <ul class="submenu">
                             <!-- Upload Retur Masukan, Daffa 090224 -->
                             <li class="dropdown">
                                 <a href="index.php?page=upload_retur_masukan" class="dropdown-toggle no-arrow">
                                     <span class="micon fa fa-upload"></span><span class="mtext style1">Upload Retur
                                         Masukan</span>
                                 </a>
                             </li>
                             <!-- Master Supplier, Daffa 260324 -->
                             <li class="dropdown">
                                 <a href="index.php?page=master_supplier" class="dropdown-toggle no-arrow">
                                     <span class="micon fa fa-gear"></span><span class="mtext style1">Master
                                         Supplier</span>
                                 </a>
                             </li>
                         </ul>
                     </li>
 
                     {{-- @if (session('menus'))
                     <li class="dropdown"> 
                         @foreach (session('menus') as $item)
                             @if ($item['header'] !== null)
                                 <a href="javascript:;" class="dropdown-toggle">
                                     <span class="micon fa {{ $item['ikon'] }} "></span><span class="mtext style1">{{ $item['header'] }}</span>
                                 </a>
                                 <ul class="submenu">
                                 @continue;
                             @endif
 
                             <li class="dropdown">
                                 <a href="{{ $item['url'] }}" class="dropdown-toggle no-arrow">
                                     <span class="micon fa {{ $item['ikon'] }}"></span><span class="mtext style1">{{ $item['nama'] }}</span>
                                 </a>
                             </li>
                             @endforeach
                         </ul>
                     </li>
                     @endif        --}}

                    @if (session('authMenus'))
                    @foreach (session('authMenus') as $item)
                    <li class="dropdown">
                        <a href="{{ $item['tipe'] === "menu" ? $item['url'] : 'javascript:;' }}" class="dropdown-toggle {{ $item['tipe'] === "menu" ? 'no-arrow' : '' }}">
                            <span class="micon {{ $item['ikon'] }} "></span><span class="mtext style1">{{ $item['nama'] }}</span>
                        </a>
                        @if (!empty($item['submenu']))
                        @foreach($item['submenu'] as $submenu)
                        <ul class="submenu">
                            <li class="dropdown">
                                <a href="{{ $submenu['url'] }}" class="dropdown-toggle no-arrow">
                                    <span class="micon {{ $submenu['ikon'] }}"></span><span class="mtext style1">{{ $submenu['nama'] }}</span>
                                </a>
                            </li>
                        </ul>
                        @endforeach
                        @endif
                    </li>
                    @endforeach
                    @endif
                 </ul>
             </div>
         </div>
     </div>
 
     <div class="main-container">
         <div class="pd-ltr-20">
             @yield('body')
         </div>
     </div>

     <div class="footer">
         @yield('footer')
     </div>
 
     
 
 
    {{-- javascript --}}
    <script src="{{ asset('vendor/scripts/core.js') }}"></script>
    <script src="{{ asset('vendor/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendor/scripts/process.js') }}"></script>
    <script src="{{ asset('vendor/scripts/layout-settings.js') }}"></script>
 
     <!-- <script src="src/plugins/apexcharts/apexcharts.min.js"></script> -->
     <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
     <script src="{{ asset('src/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('src/plugins/datatables/js/dataTables.responsive.min.js') }}"></script>
     <script src="{{ asset('src/plugins/datatables/js/responsive.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('vendor/scripts/dashboard.js') }}"></script>
     <script src="{{ asset('arsip/assets/DataTables/dataTables.min.js') }}"></script>
 
     <!-- Tambahan CDN buat datatable URM Tax, Daffa 090224 -->
 
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
     <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
     
     <!-- Tambahan Bootstrap 5, kalo jadi rusak ini yang dihapus -->
     
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     @yield('script')

     <script>

     </script>
 </body>
 
 </html>
 