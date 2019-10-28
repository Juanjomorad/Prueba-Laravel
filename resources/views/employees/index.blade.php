@extends('layouts.master')

@section('title', 'employees')

@section('header')

@stop

@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Employees list
                    <a href="{{ route('employees.create',$companyId) }}" class="btn btn-success btn-sm float-right">New employee</a>
                </div>
                <div class="card-body">
                    @if(session('info'))
                        <div class="alter alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    <table class="table table-hover table-sm">
                        <thead>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{ $employee->firstName }}</td>
                                    <td>{{ $employee->lastName }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>                                        
                                        <a href="{{ route('employees.edit', [ $employee->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="javascript: document.getElementById('delete-{{ $employee->id }}').submit()" class="btn btn-danger btn-sm">Delete</a>
                                        <form id="delete-{{ $employee->id }}" action="{{ route('employees.destroy', [$employee->id]) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                        </form>                                                                                
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $employees->links() }}
                </div>
                <div class="card-footer">
                    Bienvenido {{ auth()->user()->name }}                    
                    <a href="javascript:document.getElementById('logout').submit()" class="btn btn-secondary float-right ml-2">Logout</a>
                    <a href="{{ route('companies.index') }}" class="btn btn-info float-right">Back</a>
                    <form action="{{ route('logout') }}" id="logout" method="post">
                        @csrf
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer')

@stop
