@extends('admin.layouts.app')

@section('title' , 'Admin-Edit Expenses')

@section('content')
<!-- Edit expenses form start -->
<div class="col-12 mt-5">
    <div class="card">
        <form id="expenseEditForm" action="{{ route('admin.expenses.update' , $expense->id) }}" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $expense->expense_name }}" name="expense_name" type="text" class="form-control" placeholder="Expense Name" aria-label="expense_name">
                    </div>
                    <div class="col">
                        <input value="{{ $expense->expense_date }}" name="expense_date" type="date" class="form-control" placeholder="Expense Date" aria-label="expense_date">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $expense->expense_amount }}" name="expense_amount" type="text" class="form-control" placeholder="Expense Amount" aria-label="expense_amount">
                    </div>
                    <div class="col">
                        <input value="{{ $expense->expense_payment }}" name="expense_payment" type="text" class="form-control" placeholder="Expense Payment" aria-label="expense_payment">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <input value="{{ $expense->expense_img }}" name="expense_img" type="file" class="form-control" placeholder="expense_img" aria-label="expense_img"> 
                    </div>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button class="btn btn-primary" type="submit">Edit Expenses</button>
            </div>
        </form>
    </div>
</div>
@endsection