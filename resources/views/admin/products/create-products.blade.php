@extends('admin.layouts.main')
@section('title', 'Create Product')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Product</h4>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form class="forms-sample" action="{{ route('admin.products.store') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" name="name"
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" id="quantity" placeholder="Quantity" name="quantity"
                                value="{{ old('quantity') }}">
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" placeholder="Price" name="price"
                                value="{{ old('price') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" placeholder="Description"
                                name="description" value="{{ old('description') }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" placeholder="Image" name="image">
                        </div>
                        <div class="form-group">
                            <label for="image">Sub Category</label>
                            <div class="col-sm-9">
                                <select name="sub_category_id" class="form-control">
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" disabled class="font-weight-bold">{{$category->name}}
                                        </option>
                                        @foreach ($category->subCategories as $subCategory)
                                            <option value="{{$subCategory->id}}" {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>
                                                --{{$subCategory->name}}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <button class="btn btn-dark">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row mt-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">All Products</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Quantity</th>
                                    <th>Sub Category</th>
                                    <th>Category</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ Str::limit($product->description, 50) }}</td>
                                        <td>${{ number_format($product->price, 2) }}</td>
                                        <td>
                                            @if($product->getFirstMediaUrl('products'))
                                                <img src="{{ $product->getFirstMediaUrl('products') }}" alt="{{ $product->name }}"
                                                    class="img-thumbnail" style="width: 50px; height: 50px; cursor: pointer;"
                                                    data-toggle="modal" data-target="#imageModal{{ $product->id }}">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ $product->subCategory->name ?? 'N/A' }}</td>
                                        <td>{{ $product->subCategory->category->name ?? 'N/A' }}</td>
                                        <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning">Edit</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                        </td>
                                    </tr>

                                    <!-- Modal for Image -->
                                    <div class="modal fade" id="imageModal{{ $product->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="imageModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="imageModalLabel{{ $product->id }}">
                                                        {{ $product->name }} Image
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ $product->getFirstMediaUrl('products') }}"
                                                        alt="{{ $product->name }}" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($products->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
