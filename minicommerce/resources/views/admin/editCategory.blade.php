@extends('admin.maindesign')


@section('editcategory')


<div class="mb-4 container">
    <h2>Edit Category</h2>

    <form action="{{ route('admin.category.edit.post', ['category' => $category->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control" name="name" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>

@endsection