<!-- Loading Source Sans Pro font that is used in this theme-->
<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700%7cSource+Sans+Pro:200,400,600,700,900,400italic,700italic&amp;subset=latin,latin-ext" rel="stylesheet" type="text/css">
<!-- Boostrap and other lib styles-->
<!-- build:cssvendor-->
<link rel="stylesheet" href="{{url('assets/frontend/css/vendor.css')}}">
<!-- endbuild-->
<!-- Font-awesome lib-->
<!-- build:cssfontawesome-->
<link rel="stylesheet" href="{{url('assets/frontend/css/font-awesome.css')}}">
<!-- endbuild-->
<!-- Theme styles, please replace "default" with other color scheme from the list available in template/css-->
<!-- build:csstheme-default-->
<link rel="stylesheet" href="{{url('assets/frontend/css/theme-default.css')}}">
<!-- endbuild-->
<!-- Your styles should go in this file-->
<link rel="stylesheet" href="{{url('assets/frontend/css/custom.css')}}">
@yield('additional-styles')