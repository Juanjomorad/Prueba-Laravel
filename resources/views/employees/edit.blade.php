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
                        Edit employee
                    </div>
                    <div class="card-body">
                        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                            @method('put')
                            @csrf                            
                            <div class="form-group">
                                <label for="">Employee firstname</label>
                                <input type="text" class="form-control" name="firstName" value="{{ $employee->firstName }}" required>
                            </div>
                            <div class="form-group">
                                <label for="">Employee lastname</label>
                                <input type="text" class="form-control" name="lastName" value="{{ $employee->lastName }}" required>
                            </div>                          
                            <input type="text" class="form-control d-none" name="company_id" value="{{ $employee->company_id }}">                                         
                            <div class="form-group">
                                <label for="">Employee phone</label>
                                <input type="phone" class="form-control" name="phone" value="{{ $employee->phone }}">
                            </div>
                            <div class="form-group">
                                <label for="">Employee email</label>
                                <input type="email" class="form-control" name="email" value="{{ $employee->email }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('employees.index', $employee->company_id) }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer')
    
@stop