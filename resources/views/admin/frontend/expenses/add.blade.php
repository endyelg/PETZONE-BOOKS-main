@extends('admin.layouts.app')

@section('title', 'Admin-Add Expenses')

@section('content')
<div class="col-12 mt-5">

{{-- import button --}}
    <div class="container">
        <div>
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="messages">
                  @if (session('success'))
                    <div class="alert alert-success">
                      {{ session('success') }}
                    </div>
                  @endif
                </div>
                <div class="fields">
                    <div class="input-group mb-3">
                        <input type="file" class="form-control" id="import_csv" name="import_csv" accept=".csv">
                        <label class="input-group-text" for="import_csv">Upload</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Import CSV</button>
            </form>
        </div>
    </div>

    <div class="card">
        <form id="expenseForm" action="{{ route('admin.expenses.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="expense_name" type="text" class="form-control" placeholder="Expense Name" aria-label="expense_name">
                    </div>
                    <div class="col">
                        <input name="expense_date" type="date" class="form-control" placeholder="Expense Date" aria-label="expense_date">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="expense_amount" type="text" class="form-control" placeholder="Expense Amount" aria-label="expense_amount">
                    </div>
                    <div class="col">
                        <input name="expense_payment" type="text" class="form-control" placeholder="Expense Payment" aria-label="expense_payment">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input name="expense_img" type="file" accept="image/*" aria-label="expense_img">
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Add Expense</button>
            </div>
        </form>
    </div>
</div>
@endsection