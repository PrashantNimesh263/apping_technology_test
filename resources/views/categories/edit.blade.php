@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
            @error('name')
            <div class="alert alert-danger mt-2">{{ $message }}</div>
             @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
