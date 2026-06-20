@extends('layouts.sidebar')

@section('header', 'Edit Inventory Item')

@section('content')

<div class="form-card">

<form action="{{ route('inventory.update', $inventory->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="item_name" value="{{ $inventory->item_name }}" required>
    <br><br>

    <input type="number" name="quantity" value="{{ $inventory->quantity }}" required>
    <br><br>

    <input type="number" step="0.01" name="price" value="{{ $inventory->price }}" required>
    <br><br>

    <input type="text" name="category" value="{{ $inventory->category }}">
    <br><br>

    <textarea name="description">{{ $inventory->description }}</textarea>
    <br><br>

    <select name="status">
        <option value="available" {{ $inventory->status == 'available' ? 'selected' : '' }}>Available</option>
        <option value="damaged" {{ $inventory->status == 'damaged' ? 'selected' : '' }}>Damaged</option>
        <option value="lost" {{ $inventory->status == 'lost' ? 'selected' : '' }}>Lost</option>
    </select>

    <br><br>

    <button type="submit">Update</button>

</form>

</div>

@endsection