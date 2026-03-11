@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Product Details</h1>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="img-fluid rounded"
                             style="max-height: 300px; object-fit: cover;">
                    @else
                        <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                             style="height: 250px;">
                            <span class="text-muted"><i class="bi bi-image" style="font-size: 3rem;"></i></span>
                        </div>
                    @endif
                </div>

                <div class="col-md-8">
                    <h2 class="mb-3">{{ $product->name }}</h2>

                    <table class="table table-borderless">
                        <tr>
                            <th width="130" class="text-muted">Price</th>
                            <td><span class="fs-5 fw-semibold text-success">${{ number_format($product->price, 2) }}</span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Quantity</th>
                            <td>
                                <span class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->quantity > 0 ? $product->quantity . ' in stock' : 'Out of stock' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Description</th>
                            <td>{{ $product->description ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Created</th>
                            <td>{{ $product->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Updated</th>
                            <td>{{ $product->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this product?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
