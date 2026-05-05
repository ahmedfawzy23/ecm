@extends('customer.layouts.main')
@section('title', 'Support')
@section('content')
    <div class="container-fluid py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 font-weight-bold mb-3">Customer Support</h1>
                    <p class="lead text-muted">We're here to help! Contact our support team through any of the channels
                        below.</p>
                </div>
            </div>
            <!-- Contact Form -->

            <!-- Contact Start -->
            <div class="container-fluid pt-5">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="text-center mb-4">
                    <h2 class="section-title px-5"><span class="px-2">Contact For Any Queries</span></h2>
                </div>
                <div class="row px-xl-5">
                    <div class="col-lg-7 mb-5">
                        <div class="contact-form">
                            <div id="success"></div>
                            <form method="POST" action="{{ route('contact.store') }}">
                                @csrf
                                <div class="control-group">
                                    <input type="text" class="form-control" id="name" placeholder="Your Name" name="name"
                                        required="required" data-validation-required-message="Please enter your name" />
                                    <p class="help-bloc k text-danger"></p>
                                </div>
                                <div class="control-group">
                                    <input type="email" class="form-control" id="email" placeholder="Your Email"
                                        name="email" required="required"
                                        data-validation-required-message="Please enter your email" />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="control-group">
                                    <input type="text" class="form-control" id="subject" placeholder="Subject"
                                        name="subject" required="required"
                                        data-validation-required-message="Please enter a subject" />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="control-group">
                                    <textarea class="form-control" rows="6" id="message" placeholder="Message"
                                        name="message" required="required"
                                        data-validation-required-message="Please enter your message"></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div>
                                    <button class="btn btn-primary py-2 px-4" type="submit">Send
                                        Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-5 mb-5">
                        <h5 class="font-weight-semi-bold mb-3">Get In Touch</h5>
                        <p>Justo sed diam ut sed amet duo amet lorem amet stet sea ipsum, sed duo amet et. Est elitr dolor
                            elitr erat sit sit. Dolor diam et erat clita ipsum justo sed.</p>
                        <div class="d-flex flex-column mb-3">
                            <h5 class="font-weight-semi-bold mb-3">Store 1</h5>
                            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA
                            </p>
                            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                            <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                        </div>
                        <div class="d-flex flex-column">
                            <h5 class="font-weight-semi-bold mb-3">Store 2</h5>
                            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>123 Street, New York, USA
                            </p>
                            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>info@example.com</p>
                            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>+012 345 67890</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Contact End -->


            <!-- FAQ Quick Links -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <h3 class="h4 font-weight-bold mb-4">Common Issues</h3>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card border-0 bg-light rounded-lg p-4 h-100 hover-shadow">
                                <h6 class="font-weight-bold mb-3">
                                    <i class="fas fa-box text-primary mr-2"></i>Track Your Order
                                </h6>
                                <p class="text-muted small mb-3">Unable to find your tracking number or shipment status.</p>
                                <a href="{{ route('faqs') }}" class="btn btn-link btn-sm px-0">View Answer <i
                                        class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card border-0 bg-light rounded-lg p-4 h-100 hover-shadow">
                                <h6 class="font-weight-bold mb-3">
                                    <i class="fas fa-undo text-danger mr-2"></i>Return a Product
                                </h6>
                                <p class="text-muted small mb-3">Questions about how to return or exchange items.</p>
                                <a href="{{ route('faqs') }}" class="btn btn-link btn-sm px-0">View Answer <i
                                        class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4">
                            <div class="card border-0 bg-light rounded-lg p-4 h-100 hover-shadow">
                                <h6 class="font-weight-bold mb-3">
                                    <i class="fas fa-lock text-warning mr-2"></i>Account Security
                                </h6>
                                <p class="text-muted small mb-3">Having trouble accessing your account or password issues.
                                </p>
                                <a href="{{ route('help') }}" class="btn btn-link btn-sm px-0">Get Help <i
                                        class="fas fa-arrow-right ml-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Methods -->
            <div class="row mb-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow">
                        <div class="display-3 text-primary mb-3">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Email Support</h5>
                        <p class="text-muted mb-4">Response within 24 hours</p>
                        <h6 class="font-weight-bold">support@eshopper.com</h6>
                        <p class="text-muted small mb-4">support@eshopper.com</p>
                        <a href="mailto:support@eshopper.com" class="btn btn-outline-primary btn-sm">Send Email</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow">
                        <div class="display-3 text-success mb-3">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Phone Support</h5>
                        <p class="text-muted mb-4">Mon-Fri 9AM-6PM EST</p>
                        <h6 class="font-weight-bold">1-800-ESHOPPER</h6>
                        <p class="text-muted small mb-4">1-800-374-67737</p>
                        <a href="tel:1-800-374-67737" class="btn btn-outline-success btn-sm">Call Now</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow">
                        <div class="display-3 text-warning mb-3">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Live Chat</h5>
                        <p class="text-muted mb-4">Available 24/7</p>
                        <p class="text-muted small mb-4">Chat with our support agents instantly</p>
                        <a href="#" class="btn btn-outline-warning btn-sm">Start Chat</a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100 text-center py-5 px-4 rounded-lg hover-shadow">
                        <div class="display-3 text-info mb-3">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5 class="font-weight-bold mb-3">Visit Us</h5>
                        <p class="text-muted mb-4">Our office location</p>
                        <p class="text-muted small mb-4">123 Commerce Street<br>New York, NY 10001</p>
                        <a href="#" class="btn btn-outline-info btn-sm">Get Directions</a>
                    </div>
                </div>
            </div>


            <!-- Support Hours & Response Times -->
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-sm rounded-lg p-5 bg-light">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <h6 class="font-weight-bold text-primary mb-2">
                                    <i class="fas fa-clock display-4 d-block mb-3"></i>
                                    Support Hours
                                </h6>
                                <p class="mb-0">
                                    <strong>Monday - Friday:</strong> 9AM - 6PM EST<br>
                                    <strong>Saturday:</strong> 10AM - 4PM EST<br>
                                    <strong>Sunday:</strong> Closed<br>
                                    <strong>Holidays:</strong> Closed
                                </p>
                            </div>

                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <h6 class="font-weight-bold text-success mb-2">
                                    <i class="fas fa-tachometer-alt display-4 d-block mb-3"></i>
                                    Response Times
                                </h6>
                                <p class="mb-0">
                                    <strong>Live Chat:</strong> Immediate<br>
                                    <strong>Email:</strong> 24 hours<br>
                                    <strong>Phone:</strong> During business hours<br>
                                    <strong>Urgent:</strong> Priority handling
                                </p>
                            </div>

                            <div class="col-md-4 text-center">
                                <h6 class="font-weight-bold text-warning mb-2">
                                    <i class="fas fa-smile display-4 d-block mb-3"></i>
                                    Satisfaction
                                </h6>
                                <p class="mb-0">
                                    <strong>Customer Satisfaction:</strong> 98%<br>
                                    <strong>Average Rating:</strong> 4.8/5<br>
                                    <strong>Resolution Rate:</strong> 95%<br>
                                    <strong>Available:</strong> Always here to help
                                </p>
                            </div>
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

        .form-control,
        .form-control-lg {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-control-lg:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-warning:hover,
        .btn-outline-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .rounded-lg {
            border-radius: 0.75rem;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }
    </style>
@endsection
