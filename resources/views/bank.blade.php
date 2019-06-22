@extends('layout')

@section('page_title', 'Banks - ')

@section('content')
<div class="w-100">
    <div class="container">
        <hr>
        <div class="row">
            <h3 class="w-100 mb-4 text-center">Banks on Paystack</h3>
            @forelse ($banks as $b)
                <div class="p-2 col-3 mb-2">
                    <div class="card p-2 text-center">{{ $b->name }}</div>
                </div>
            @empty
                <h4 class="text-center col">No Bank records found!</h4>
            @endforelse
        </div>
        <hr>
        <div class="col mt-5">
            <form method="post" class="form-inline d-inline">
                {{ csrf_field() }}
                @if (count($banks))
                    <button class="btn btn-lg btn-warning"><i class="fas fa-exclamation-triangle"></i> Fetch Banks Again</button>
                @else
                    <button class="btn btn-lg btn-success">Fetch Banks</button>
                @endif
            </form>
            <a href="/" class="btn btn-primary btn-lg float-right">Go back</a>
        </div>
    </div>
</div>
@endsection