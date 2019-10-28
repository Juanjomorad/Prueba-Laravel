@extends('layouts.master')

@section('title', 'Companies')

@section('header')

@stop

@section('content')
<div class="container pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Companies list
                    <a href="{{ route('companies.create') }}" class="btn btn-success btn-sm float-right">New Company</a>
                </div>
                <div class="card-body">
                    @if(session('info'))
                        <div class="alter alert-success">
                            {{ session('info') }}
                        </div>
                    @endif
                    <table class="table table-hover table-sm">
                        <thead>
                            <th>Name</th>
                            <th>Email</th>
                            <th>WebSite</th>
                            <th>Logo</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                                <tr>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->webSite }}</td>
                                    <td><img src="{{ route('logos', $company->logo) }}" class="img-fluid" width="100"></td>
                                    <td>                                        
                                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="javascript: document.getElementById('delete-{{ $company->id }}').submit()" class="btn btn-danger btn-sm">Delete</a>
                                        <a href="{{ route('employees.index', $company->id) }}" class="btn btn-success btn-sm"><i class="fas fa-user-tie">+</i></a>
                                        <form id="delete-{{ $company->id }}" action="{{ route('companies.destroy', $company->id) }}" method="POST">
                                            @method('delete')
                                            @csrf
                                        </form>                                                                                
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $companies->links() }}
                </div>
                <div class="card-footer">
                    Bienvenido {{ auth()->user()->name }}                    
                    <a href="javascript:document.getElementById('logout').submit()" class="btn btn-secondary float-right ml-2">Logout</a>
                    <a href="{{ route('home') }}" class="btn btn-info float-right">Back</a>
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
