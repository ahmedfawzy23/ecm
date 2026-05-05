@extends('customer.layouts.main')
@section('title','Help')

@section('content')
    <div class="container-fluid py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 font-weight-bold mb-3">Help Center</h1>
                    <p class="lead text-muted">Get help with your orders, account, and more. Browse our guides and
                        tutorials.</p>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <form>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg rounded-lg"
                                placeholder="Search help articles...">
                            <div class="input-group-append">
                                <span class="input-group-text bg-primary text-white border-0 rounded-right">
                                    <i class="fas fa-search"></i>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Categories -->
            <div class="row mb-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow transition">
                        <div class="display-4 text-primary mb-3">
                            <i class="fas fa-cube"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Getting Started</h5>
                        <p class="text-muted mb-4">Learn the basics of browsing and shopping with us.</p>
                        <a href="#getting-started" class="btn btn-outline-primary btn-sm">Learn More</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow transition">
                        <div class="display-4 text-success mb-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Ordering Guide</h5>
                        <p class="text-muted mb-4">Step-by-step instructions for placing an order.</p>
                        <a href="#ordering-guide" class="btn btn-outline-success btn-sm">Learn More</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow transition">
                        <div class="display-4 text-warning mb-3">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Shipping & Delivery</h5>
                        <p class="text-muted mb-4">Information about shipping options and tracking.</p>
                        <a href="#shipping" class="btn btn-outline-warning btn-sm">Learn More</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow transition">
                        <div class="display-4 text-danger mb-3">
                            <i class="fas fa-undo"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Returns & Refunds</h5>
                        <p class="text-muted mb-4">Learn about our return and refund process.</p>
                        <a href="#returns" class="btn btn-outline-danger btn-sm">Learn More</a>
                    </div>
                </div>
            </div>

            <!-- Help Articles -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <!-- Getting Started Section -->
                    <section id="getting-started" class="mb-5 py-5 border-bottom">
                        <h3 class="h3 font-weight-bold mb-4" style="color: #007bff;">
                            <i class="fas fa-cube mr-2"></i>Getting Started
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-user-plus text-primary mr-2"></i>Creating Your Account
                                        </h6>
                                        <p class="card-text">Discover how to sign up for an account and set up your profile
                                            to get started shopping with us.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-key text-primary mr-2"></i>Account Settings
                                        </h6>
                                        <p class="card-text">Manage your personal information, preferences, and security
                                            settings.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Ordering Guide Section -->
                    <section id="ordering-guide" class="mb-5 py-5 border-bottom">
                        <h3 class="h3 font-weight-bold mb-4" style="color: #28a745;">
                            <i class="fas fa-shopping-cart mr-2"></i>Ordering Guide
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-search text-success mr-2"></i>Finding Products
                                        </h6>
                                        <p class="card-text">Learn how to search for products, use filters, and compare
                                            items to find exactly what you need.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-credit-card text-success mr-2"></i>Checkout Process
                                        </h6>
                                        <p class="card-text">A complete walkthrough of the checkout process and payment
                                            options.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-heart text-success mr-2"></i>Wishlist & Favorites
                                        </h6>
                                        <p class="card-text">Save products to your wishlist and track items you're
                                            interested in.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-tag text-success mr-2"></i>Using Promo Codes
                                        </h6>
                                        <p class="card-text">Find and apply discount codes to get the best deals on your
                                            purchases.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Shipping Section -->
                    <section id="shipping" class="mb-5 py-5 border-bottom">
                        <h3 class="h3 font-weight-bold mb-4" style="color: #ffc107;">
                            <i class="fas fa-truck mr-2"></i>Shipping & Delivery
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-shipping-fast text-warning mr-2"></i>Shipping Options
                                        </h6>
                                        <p class="card-text">Explore different shipping methods and delivery timeframes
                                            available to you.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-map-marker-alt text-warning mr-2"></i>Tracking Orders
                                        </h6>
                                        <p class="card-text">Learn how to track your order and stay updated on delivery
                                            status.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Returns Section -->
                    <section id="returns" class="py-5">
                        <h3 class="h3 font-weight-bold mb-4" style="color: #dc3545;">
                            <i class="fas fa-undo mr-2"></i>Returns & Refunds
                        </h3>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-recycle text-danger mr-2"></i>Return Process
                                        </h6>
                                        <p class="card-text">Step-by-step guide on how to initiate and complete a product
                                            return.</p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card border-0 shadow-sm rounded-lg">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold mb-3">
                                            <i class="fas fa-wallet text-danger mr-2"></i>Refund Status
                                        </h6>
                                        <p class="card-text">Track your refund status and understand processing timelines.
                                        </p>
                                        <a href="#" class="btn btn-link btn-sm px-0">Read Article <i
                                                class="fas fa-arrow-right ml-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                    <div class="bg-gradient py-5 px-4 rounded-lg"
                        style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
                        <div class="text-center text-white">
                            <h3 class="font-weight-bold mb-3">Still need help?</h3>
                            <p class="mb-4">Our support team is available 24/7 to assist you.</p>
                            <a href="{{ route('support') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-headset mr-2"></i>Contact Support Team
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-shadow {
            transition: all 0.3s ease;
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.15) !important;
        }

        .form-control-lg:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        section {
            scroll-margin-top: 100px;
        }
    </style>
@endsection
