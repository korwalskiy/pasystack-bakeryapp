@extends('layout')

@section('page_title', 'Home - ')

@section('content')
    <div class="w-100">
        <div class="card-columns container">
            <div class="card px-0 text-center"><a href="{{ route('customer.create') }}" class="btn btn-block btn-info"><i class="fas fa-user-plus"></i> Create Customer</a></div>
            <div class="card px-0 text-center"><a href="" class="btn btn-block btn-success"><i class="fas fa-credit-card"></i> Make Payment</a></div>
            <div class="card px-0 text-center"><a href="{{ route('settings') }}" class="btn btn-block btn-danger"><i class="fas fa-cog"></i> Settings</a></div>
        </div>
        <div class="col mt-5">
            @if (count($allcustomers) === 0)
                <h3 class="text-center">No Customer Records Found!</h3>
            @else
                <ul class="list-group">
                    @foreach ($allcustomers as $ac)
                        <li class="list-group-item">{{ $ac->name }}<{{ $ac->email }}></li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection