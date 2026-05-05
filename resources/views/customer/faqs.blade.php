@extends('customer.layouts.main')
@section('title', 'FAQs')

@section('content')
    <div class="container-fluid py-5">
        <div class="container">
            <!-- Page Header -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 font-weight-bold mb-3">Frequently Asked Questions</h1>
                    <p class="lead text-muted">Find answers to common questions about our products, shipping, returns, and
                        more.</p>
                </div>
            </div>

            <!-- FAQs Content -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <!-- General Questions -->
                    <div class="mb-5">
                        <h3 class="h4 font-weight-bold mb-4 text-primary border-bottom pb-3">
                            <i class="fas fa-question-circle mr-2"></i>General Questions
                        </h3>

                        <div class="accordion" id="generalAccordion">
                            @foreach($faqs as $key => $faq)
                                <!-- Question -->
                                <div class="card border-0 mb-3 shadow-sm">
                                    <div class="card-header bg-light border-0 p-0">
                                        <button class="btn btn-link text-left w-100 p-4 font-weight-bold" type="button"
                                            data-toggle="collapse" data-target="#q{{ $key + 1 }}">
                                            <i class="fas fa-chevron-down mr-2"></i>{{ $faq->question }}
                                        </button>
                                    </div>
                                    <div id="q{{ $key + 1 }}" class="collapse" data-parent="#generalAccordion">
                                        <div class="card-body p-4 bg-white">
                                            {{ $faq->answer }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <!-- Contact Section -->
            <div class="row mt-5">
                <div class="col-lg-10 mx-auto">
                    <div class="bg-light p-5 rounded-lg border">
                        <h3 class="font-weight-bold mb-3">Didn't find your answer?</h3>
                        <p class="mb-4">Our support team is here to help. Contact us for any questions not covered here.</p>
                        <a href="{{ route('support') }}" class="btn btn-primary">
                            <i class="fas fa-headset mr-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        .btn-link {
            text-decoration: none;
            color: #333 !important;
            transition: all 0.3s ease;
        }

        .btn-link:hover {
            color: #007bff !important;
        }

        .collapsed .fa-chevron-down {
            transform: rotate(-90deg);
            transition: transform 0.3s ease;
        }

        .fa-chevron-down {
            transition: transform 0.3s ease;
        }
    </style>
@endsection
