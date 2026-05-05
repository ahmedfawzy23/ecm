@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                @if(session()->has('success'))
                    <div class="alert alert-success w-50">
                        {{ session()->get('success') }}
                    </div>

                @endif
                <div class="card-body">
                    <h4 class="card-title">Banner Management</h4>
                    <p class="card-description">Create and manage website banners and promotional content</p>

                    <div class="row mb-4">
                        <div class="col-lg-8">
                            <div class="card border shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Add New Banner</h5>
                                    <form action="{{ route('admin.create-banner') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label for="bannerImage" class="font-weight-bold">Banner Image</label>
                                            <input type="file" class="form-control-file" id="bannerImage" name="image"
                                                accept="image/*" required>
                                            <small class="form-text text-muted">Upload a banner image. Only the image and
                                                status are stored in the database.</small>
                                        </div>

                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="bannerStatus" name="status"
                                                value="1">
                                            <label class="form-check-label" for="bannerStatus">Active</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-icon-text">
                                            <i class="mdi mdi-content-save btn-icon-prepend"></i>
                                            Save Banner
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
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($banners as $banner)
                                    <tr>
                                        <td>{{ $banner->id }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $banner->image) }}" target="_blank" data-toggle="modal" data-target="#imageModal{{ $banner->id }}">
                                                <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner {{ $banner->id }}"
                                                    class="img-fluid rounded" style="max-width: 180px; cursor: pointer;">
                                            </a>
                                        </td>
                                        <td>
                                            @if($banner->status)
                                                <label class="badge badge-success">Active</label>
                                            @else
                                                <label class="badge badge-secondary">Inactive</label>
                                            @endif
                                        </td>
                                        <td>{{ optional($banner->created_at)->format('Y-m-d H:i') }}</td>
                                        <td>{{ optional($banner->updated_at)->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No banners found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $banners->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    @forelse($banners as $banner)
    <div class="modal fade" id="imageModal{{ $banner->id }}" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel{{ $banner->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel{{ $banner->id }}">Banner {{ $banner->id }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="Banner {{ $banner->id }}" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('storage/' . $banner->image) }}" target="_blank" class="btn btn-primary">Open Full Size</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @empty
    @endforelse
@endsection
