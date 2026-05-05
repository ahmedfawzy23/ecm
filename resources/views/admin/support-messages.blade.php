@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Support Messages</h4>
                    <p class="card-description">View and manage all customer support messages and conversations</p>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Filter by Status</label>
                                <select class="form-control">
                                    <option>All Messages</option>
                                    <option>New</option>
                                    <option>Replied</option>
                                    <option>Closed</option>
                                    <option>Archived</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Filter by Priority</label>
                                <select class="form-control">
                                    <option>All Priorities</option>
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>High</option>
                                    <option>Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Search Messages</label>
                                <input type="text" class="form-control" placeholder="Search by subject or sender...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sender</th>
                                    <th>Subject</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Last Reply</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div>
                                            <strong>John Doe</strong><br>
                                            <small class="text-muted">john@example.com</small>
                                        </div>
                                    </td>
                                    <td>Order Status Inquiry</td>
                                    <td><span class="badge badge-warning">Medium</span></td>
                                    <td><label class="badge badge-info">New</label></td>
                                    <td>2 hours ago</td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-success">Reply</button>
                                        <button class="btn btn-sm btn-outline-secondary">Archive</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div>
                                            <strong>Jane Smith</strong><br>
                                            <small class="text-muted">jane@example.com</small>
                                        </div>
                                    </td>
                                    <td>Product Return Request</td>
                                    <td><span class="badge badge-danger">High</span></td>
                                    <td><label class="badge badge-success">Replied</label></td>
                                    <td>1 day ago</td>
                                    <td>2024-01-14</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-success">Reply</button>
                                        <button class="btn btn-sm btn-outline-secondary">Archive</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <div>
                                            <strong>Mike Johnson</strong><br>
                                            <small class="text-muted">mike@example.com</small>
                                        </div>
                                    </td>
                                    <td>Payment Issue</td>
                                    <td><span class="badge badge-danger">Urgent</span></td>
                                    <td><label class="badge badge-warning">Pending</label></td>
                                    <td>3 days ago</td>
                                    <td>2024-01-12</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-success">Reply</button>
                                        <button class="btn btn-sm btn-outline-secondary">Archive</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>
                                        <div>
                                            <strong>Sarah Wilson</strong><br>
                                            <small class="text-muted">sarah@example.com</small>
                                        </div>
                                    </td>
                                    <td>General Inquiry</td>
                                    <td><span class="badge badge-success">Low</span></td>
                                    <td><label class="badge badge-secondary">Closed</label></td>
                                    <td>1 week ago</td>
                                    <td>2024-01-08</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">View</button>
                                        <button class="btn btn-sm btn-outline-secondary">Reopen</button>
                                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <nav aria-label="Support messages pagination">
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
