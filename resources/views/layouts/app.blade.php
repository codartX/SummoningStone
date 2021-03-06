<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @yield('header_meta_extras')
  @yield('header_css')
  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <!-- Bootstrap 3.3.5 -->
  <link href="{{ asset("bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- END GLOBAL MANDATORY STYLES -->
  <!-- BEGIN THEME STYLES -->
  <!-- Theme style -->
  <link href="{{ asset("css/styles.css")}}" rel="stylesheet" type="text/css" />
  <!-- END THEME STYLES -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link href="{{ asset("img/favicon.png")}}" rel="shortcut icon" />
</head>
<body>
@yield('body_main')
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- jQuery 2.2.0 -->
<script src="{{ asset ("plugins/jQuery/jQuery-2.2.0.min.js") }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ asset ("bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="{{ asset ("plugins/slimScroll/jquery.slimscroll.min.js") }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset ("plugins/fastclick/fastclick.js") }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset ("js/scripts.js") }}" type="text/javascript"></script>
@yield('body_script')
</body>
</html>
