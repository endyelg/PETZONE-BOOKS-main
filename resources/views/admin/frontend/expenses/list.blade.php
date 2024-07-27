@extends('admin.layouts.app')

@section('title', 'Admin-Expenses')

@section('content')
<div class="main-content-inner">
    <div class="row">
        <div class="table-responsive">
        <table id="ctable" class="table table-striped table-hover custom-table">
        <link rel="stylesheet" href="{{ asset('css/table.css') }}">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Expense Name</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Expense Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="expenses-table">
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{ $expense->id }}</td>
                            <td>{{ $expense->expense_name }}</td>
                            <td>{{ $expense->expense_date }}</td>
                            <td>{{ $expense->expense_amount }}</td>
                            <td>{{ $expense->expense_payment }}</td>
                            <td>
                            @if($expense->expense_img)
                                <img src="{{ asset('storage/' . $expense->expense_img) }}" alt="Expense Image" width="50">
                            @else
                                No Image
                            @endif
                        </td>
                            <td>
                            <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="btn btn-primary">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </a>
                                <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @for ($i = 0; $i < (10 - count($expenses)); $i++) <tr>
                    <td colspan="7">&nbsp;</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
                    <!-- Centered Pagination links -->
        <div class="pagination-wrapper" style="display: flex; justify-content: right;">
            {{ $expenses->links() }}
        </div>
        </div>
    </div>
</div>
@endsection