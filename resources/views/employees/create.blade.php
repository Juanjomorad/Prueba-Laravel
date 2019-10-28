@extends('layouts.master')

@section('title', 'Employees')

@section('header')

@stop

@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Add employee to company
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employees.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Employee firstName</label>
                                <input type="text" class="form-control" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="">Employee lastName</label>
                                <input type="text" class="form-control" name="lastName" required>
                            </div>
                            <input type="text" class="form-control d-none" name="company_id" value="{{ $companyId }}">                            
                            <div class="form-group">
                                <label for="">Employee phone</label>
                                <input type="phone" class="form-control" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="">Employee email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('employees.index', $companyId) }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    
@stop