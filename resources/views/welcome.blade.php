@extends('layout')

@section('page_title', 'Home - ')

@section('content')
    <div class="w-100">
        <div class="card-columns container">
            <div class="card text-center"><a href="{{ route('customer.create') }}" class="btn btn-block btn-info">Create Customer</a></div>
            <div class="card text-center"><a href="" class="btn btn-block btn-success">Make Payment</a></div>
        </div>
        <div class="col mt-5">
            @if (count($allcustomers) === 0)
                <h3 class="text-center">No Customer Records Found!</h3>
            @else
                <ul class="list-group">
                    @foreach ($allcustomer as $ac)
                        <li class="list-group-item">{{ $ac->name }}<{{ $ac->email }}></li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection