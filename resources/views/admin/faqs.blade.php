@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                @if(session()->has('success'))
                    <div class="alert alert-success w-50 ">
                        {{ session()->get('success') }}
                    </div>
                @endif
                <div class="card-body">
                    <h4 class="card-title">Manage FAQs</h4>
                    <p class="card-description">Create and manage frequently asked questions for customers</p>
                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Add New FAQ</h5>
                                    <form action="{{ route('admin.create-faqs') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="question" class="font-weight-bold">Question</label>
                                            <input type="text" class="form-control form-control-lg" id="question"
                                                name="question" placeholder="Enter FAQ question" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="answer" class="font-weight-bold">Answer</label>
                                            <textarea class="form-control" id="answer" name="answer" rows="4"
                                                placeholder="Enter FAQ answer" required></textarea>
                                        </div>

                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="faqStatus" name="status"
                                                value="1">
                                            <label class="form-check-label" for="faqStatus">Active</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-icon-text">
                                            <i class="mdi mdi-content-save btn-icon-prepend"></i>
                                            Save FAQ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faqs as $faq)
                                    <tr>
                                        <td>{{ $faq->id }}</td>
                                        <td>{{ $faq->question }}</td>
                                        <td>
                                            <small>{{ Str::limit($faq->answer, 50) }}</small>
                                        </td>
                                        <td>
                                            @if($faq->status)
                                                <label class="badge badge-success">Active</label>
                                            @else
                                                <label class="badge badge-secondary">Inactive</label>
                                            @endif
                                        </td>
                                        <td>{{ optional($faq->created_at)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No FAQs found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $faqs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
