@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Support Questions</h4>
                    <p class="card-description">Manage customer support questions and responses</p>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Filter by Status</label>
                                <select class="form-control">
                                    <option>All Questions</option>
                                    <option>Answered</option>
                                    <option>Unanswered</option>
                                    <option>Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Search Questions</label>
                                <input type="text" class="form-control" placeholder="Search by question or customer...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Question</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>How do I track my order?</td>
                                    <td>Shipping</td>
                                    <td><label class="badge badge-success">Answered</label></td>
                                    <td><span class="text-warning">Medium</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-info">Reply</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>Product arrived damaged</td>
                                    <td>Returns</td>
                                    <td><label class="badge badge-warning">Pending</label></td>
                                    <td><span class="text-danger">High</span></td>
                                    <td>2024-01-16</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-info">Reply</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Mike Johnson</td>
                                    <td>Payment not processed</td>
                                    <td>Payment</td>
                                    <td><label class="badge badge-danger">Unanswered</label></td>
                                    <td><span class="text-danger">High</span></td>
                                    <td>2024-01-17</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-info">Reply</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Sarah Wilson</td>
                                    <td>Size guide confusion</td>
                                    <td>Product</td>
                                    <td><label class="badge badge-success">Answered</label></td>
                                    <td><span class="text-success">Low</span></td>
                                    <td>2024-01-18</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-info">Reply</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <nav aria-label="Support questions pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
