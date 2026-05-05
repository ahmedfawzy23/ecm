@extends('customer.layouts.main')
@section('title','main')
@section('content')


    <!-- Featured Start -->
    @include('customer.layouts.featured')
    <!-- Featured End -->


    <!-- Categories Start -->
    @include('customer.layouts.categories')
    <!-- Categories End -->


    <!-- Offer Start -->
    @include('customer.layouts.offer')
    <!-- Offer End -->


    <!-- Products Start -->

    @include('customer.layouts.products')
    <!-- Products End -->


    <!-- Subscribe Start -->
    @include('customer.layouts.subscribe')
    <!-- Subscribe End -->


    <!-- Just Arrived Start -->
    @include('customer.layouts.just_arrived')
    <!-- Just Arrived End -->


    <!-- Vendor Start -->
    @include('customer.layouts.vendor')
    <!-- Vendor End -->


@endsection
