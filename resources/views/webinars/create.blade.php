@extends('layouts.admin')

@section('title')
    Create Webinar
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('user.home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('webinars.index') }}">Webinars</a></li>
                            <li class="breadcrumb-item active">Create Webinar</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card w-full">
                    <div class="card-header">
                        <h4 class="card-title">Add Webinar</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('webinars.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Type -->
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                                    <option value="webinar" {{ old('type') == 'webinar' ? 'selected' : '' }}>Webinar</option>
                                    <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>Conference</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Link -->
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="url" class="form-control @error('link') is-invalid @enderror" name="link" value="{{ old('link') }}" required>
                                @error('link')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <!-- Start Date -->
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="image">Upload Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" required>
                                @error('image')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('webinars.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
