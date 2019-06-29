@extends('layout')

@section('page_title', 'Add Customer - ')

@section('content')
<div class="w-100">
    <div class="container">
        <h3 class="text-center">Create Customer Form</h3>
        <div class="col mt-5 mb-5">
            <form action="{{ route('customer.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name</label><br>
                    <input type="text" class="form-control" name="name" id="name" />
                </div>
                <div class="form-group">
                    <label for="email">Email</label><br>
                    <input type="text" class="form-control" name="email" id="email" />
                </div>
                <div class="form-group">
                    <label for="account_number">Account Number</label><br>
                    <input type="text" class="form-control" name="account_number" id="account_number" />
                </div>
                <div class="form-group">
                    <label for="bank_code">Bank</label><br>
                    <select class="form-control" name="bank_code">
                        <option disabled>Choose Bank</option>
                        @foreach ($banks as $b)
                            <option value="{{ $b->code }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label><br>
                    <textarea class="form-control" name="description" id="description"></textarea>
                </div>

                <input type="submit" value="Add Customer" class="btn btn-success" />
            </form>
        </div>
        <hr>
        <div class="col mt-5 text-center">
            <a href="/" class="btn btn-primary">Go back</a>
        </div>
    </div>
</div>
@endsection