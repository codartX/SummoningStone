@extends('layouts/app')

@section('title', 'Summoning Stone')

@section('body_main')
  <!-- Header -->
  @include('layouts/header')

  <!-- Main content -->
  @yield('content_main')
  <!-- /.content -->

@endsection
