<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="fontiran.com:license" content="Y68A9">
    <link rel="icon" href="/users/build/images/favicon.ico" type="image/ico"/>
    <title>@yield('title')</title>

    <!-- Bootstrap -->
    <link href="/users/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/users/vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/users/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/users/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="/users/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/users/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="/users/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    
    <!-- Custom Theme Style -->
    <link href="/users/build/css/custom.min.css" rel="stylesheet">

</head>
<!-- /header content -->
<body class="nav-md">

@include('sweetalert::alert')   

    
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col menu_fixed hidden-print">
            <div class="left_col  scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="{{ route('home') }}" class="site_title"><i class="fa fa-rocket"></i> <span>سامانه قرعه کشی</span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img 
                        
                        @if (auth()->user()->avatar_url)
                            src="{{auth()->user()->avatar_url}}"
                        @else
                            src="/users/build/images/profile/user.png" 
                        @endif
                         alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        
                        
                        <h2>موجودی :</h2>
                        <span>{{auth()->user()->cash}} تومان</span>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br/>

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3><span class="badge bg-green">کاربر ویژه</span></h3>
                        <ul class="nav side-menu">
                            <li><a><i class="fa fa-edit"></i>حساب کاربری<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{ route('profiles.index') }}">مشاهده پروفایل</a></li>
                                    <li><a href="{{ route('profiles.edit',auth()->user()->id) }}">ویرایش پروفایل</a></li>
                                    
                                    <li><a href="form_advanced.html">عضویت ویژه</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('lotteries.index') }}"><i class="fa fa-flash"></i>قرعه کشی ها</a>

                            </li>
                            <li><a><i class="fa fa-bar-chart-o"></i>امور مالی<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href="{{ route('payments.index') }}">مشاهده لیست تراکنش ها</a></li>
                                    <li><a href="{{ route('checkout.request') }}">درخواست برداشت از حساب</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('tickets.index') }}"><i class="fa fa-support"></i>پشتیبانی</a>
                               
                            </li>
                        </ul>
                    </div>
                    

                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="تنظیمات">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="تمام صفحه" onclick="toggleFullScreen();">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="قفل" class="lock_btn">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="خروج" href="login.html">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>


        
        <!-- top navigation -->
        <div class="top_nav hidden-print">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>





                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                               <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false">
                                <img 
                                @if (auth()->user()->avatar_url)
                                    src="{{auth()->user()->avatar_url}}"
                                @else
                                    src="/users/build/images/profile/user.png" 
                                @endif
                                
                                 alt="">{{auth()->user()->name}}
                                                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;"> نمایه</a></li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>تنظیمات</span>
                                    </a>
                                </li>
                                <li><a href="javascript:;">کمک</a></li>













                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fa fa-sign-out pull-right"></i> خروج</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                </li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-red">6</span>
                            </a>

                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مهری صادقی راد</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>مشاهده تمام اعلان ها</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>




                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fa fa-globe"></i>
                                <span class="badge bg-red">9</span>
                            </a>

                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مهری صادقی راد</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <span class="image"><img src="/users/build/images/img.jpg"
                                                                 alt="Profile Image"/></span>
                                        <span>
                          <span>مرتضی کریمی</span>
                          <span class="time">3 دقیقه پیش</span>
                        </span>
                                        <span class="message">
                          فیلمای فستیوال فیلمایی که اجرا شده یا راجع به لحظات مرده ایه که فیلمسازا میسازن. آنها جایی بودند که....
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <div class="text-center">
                                        <a>
                                            <strong>مشاهده تمام اعلان ها</strong>
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->




        <!-- /header content -->
        
        @yield('content')

        <!-- footer content -->
        <footer class="hidden-print">
            <div class="pull-left">
                لاتاری - سیستم برگزاری قرعه کشی دوستانه به صورت آنلاین 
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>
<div id="lock_screen">
    <table>
        <tr>
            <td>
                <div class="clock"></div>
                <span class="unlock">
                    <span class="fa-stack fa-5x">
                      <i class="fa fa-square-o fa-stack-2x fa-inverse"></i>
                      <i id="icon_lock" class="fa fa-lock fa-stack-1x fa-inverse"></i>
                    </span>
                </span>
            </td>
        </tr>
    </table>
</div>



@yield('scripts')



<!-- jQuery -->
<script src="/users/vendors/jquery/dist/jquery.min.js"></script>

<!-- Bootstrap -->
<script src="/users/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="/users/vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="/users/vendors/nprogress/nprogress.js"></script>
<!-- bootstrap-progressbar -->
<script src="/users/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="/users/vendors/iCheck/icheck.min.js"></script>

<!-- bootstrap-daterangepicker -->
<script src="/users/vendors/moment/min/moment.min.js"></script>

<script src="/users/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<!-- Chart.js -->
<script src="/users/vendors/Chart.js/dist/Chart.min.js"></script>
<!-- jQuery Sparklines -->
<script src="/users/vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- gauge.js -->
<script src="/users/vendors/gauge.js/dist/gauge.min.js"></script>
<!-- Skycons -->
<script src="/users/vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="/users/vendors/Flot/jquery.flot.js"></script>
<script src="/users/vendors/Flot/jquery.flot.pie.js"></script>
<script src="/users/vendors/Flot/jquery.flot.time.js"></script>
<script src="/users/vendors/Flot/jquery.flot.stack.js"></script>
<script src="/users/vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="/users/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="/users/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="/users/vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="/users/vendors/DateJS/build/production/date.min.js"></script>
<!-- JQVMap -->
<script src="/users/vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="/users/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="/users/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>

<!-- Custom Theme Scripts -->
<script src="/users/build/js/custom.min.js"></script>


</body>
</html>
