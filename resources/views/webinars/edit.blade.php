@extends('layouts.app')

@section('content')
    <form action="{{ isset($webinar) ? route('webinars.update', $webinar->id) : route('webinars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($webinar))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $webinar->title ?? old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="link">Link</label>
            <input type="url" name="link" class="form-control" value="{{ $webinar->link ?? old('link') }}" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                <option value="webinar" {{ (isset($webinar) && $webinar->type == 'webinar') ? 'selected' : '' }}>Webinar</option>
                <option value="conference" {{ (isset($webinar) && $webinar->type == 'conference') ? 'selected' : '' }}>Conference</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="active" {{ (isset($webinar) && $webinar->status == 'active') ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (isset($webinar) && $webinar->status == 'inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            @if (isset($webinar) && $webinar->image_source)
                <img src="{{ asset('storage/' . $webinar->image_source) }}" width="100" alt="Webinar Image">
            @endif
        </div>

        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" name="start_date" class="form-control" value="{{ isset($webinar) ? $webinar->start_date->format('Y-m-d\TH:i') : old('start_date') }}" required>
        </div>

        <button type="submit" class="btn btn-success">{{ isset($webinar) ? 'Update' : 'Create' }} Webinar</button>
    </form>
@endsection
