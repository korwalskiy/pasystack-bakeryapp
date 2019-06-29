@extends('layout')

@section('page_title', 'Make Transfer - ')

@section('content')
<div class="w-100">
    <div class="container">
        <h3 class="text-center">Initiate Transfer Form</h3>
        <div class="col mt-5 mb-5">
            <form action="{{ route('transfer.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="bank_code">Choose Supplier</label><br>
                    <select class="form-control" name="customer_id">
                        <option value="0">--Select--</option>
                        @foreach ($allsuppliers as $s)
                            <option value="{{ $s->recipient_code }}">{{ $s->customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="amount">Amount to Tranfer</label><br>
                    <input type="text" class="form-control" name="amount" id="amount" />
                </div>
                <div class="form-group">
                    <label for="reason">Reason</label><br>
                    <textarea class="form-control" name="reason" id="reason"></textarea>
                </div>

                <input name="submit" type="submit" value="Initaite Transfer" class="btn btn-success" />
            </form>
        </div>
        <hr>
        <div class="col mt-5 text-center">
            <a href="/" class="btn btn-primary">Go back</a>
        </div>
    </div>
</div>
@endsection