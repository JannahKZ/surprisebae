@extends('layouts.app')

@section('title', $category->name ?? 'Services')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ $category->name ?? 'All Services' }}</h2>
        <a href="{{ route('decoServices.create', ['category' => optional($category)->id]) }}" class="btn btn-primary">
            Add Deco Service
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($decoServices->isEmpty())
        <div class="alert alert-info">No Deco Services found in this category.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price (RM)</th>
                        <th>Category</th>
                        <th>Booked Dates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($decoServices as $index => $decoService)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if ($decoService->image)
                                    <img src="{{ asset('storage/' . $decoService->image) }}" alt="Service Image" class="img-thumbnail" width="80">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>{{ $decoService->name }}</td>
                            <td>RM {{ number_format($decoService->price, 2) }}</td>
                            <td>{{ $decoService->category->name ?? 'Uncategorized' }}</td>
                            <td>
                                @if ($decoService->dates->isNotEmpty())
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($decoService->dates as $date)
                                            <li>{{ \Carbon\Carbon::parse($date->date)->format('d M Y') }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">None</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('decoServices.edit', $decoService->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('decoServices.destroy', $decoService->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
