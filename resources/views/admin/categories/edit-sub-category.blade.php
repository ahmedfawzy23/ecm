@extends('admin.layouts.main')
@section('title', 'Edit SubCategory')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit SubCategory</h4>

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

                    <form class="forms-sample" method="POST" enctype="multipart/form-data"
                        action="{{ route('admin.categories.update-sub-category', $subCategory) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Subcategory Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter subcategory name"
                                        name="name" value="{{ old('name', $subCategory->name) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="category_id">Parent Category</label>
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">Select category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                        </div>

                        @if($subCategory->image)
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <p class="mb-2 fw-bold">Current Image</p>
                                        <div>
                                            <img src="{{ asset('storage/' . $subCategory->image) }}"
                                                alt="{{ $subCategory->name }}" class="img-thumbnail" style="max-height: 120px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                        <a href="{{ route('admin.categories.create-sub-category') }}" class="btn btn-dark">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection