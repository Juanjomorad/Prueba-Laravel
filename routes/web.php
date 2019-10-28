<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Company;
use App\Employee;

Route::middleware('auth')->group(function () {
    /*Route::get('companies', function () {
        $companies = Company::orderBy('created_at', 'desc')->get()->paginate(10);
        return view('companies.index', compact('companies'));
    })->name('companies.index');*/
    Route::get('companies', function () {
        $companies = Company::orderBy('created_at', 'desc')->paginate(10);
        return view('companies.index', ['companies' => $companies]);
    })->name('companies.index');
    
    Route::get('companies/create', function () {
        return view('companies.create');
    })->name('companies.create');
    
    Route::post('companies', function(Request $request){
         
        if($request->hasFile('logo')){
            $logo = $request->file('logo'); 
            $extension = $logo->getClientOriginalExtension();
            Storage::disk('public')->put('logos/'.$logo->getFilename().'.'.$extension,  File::get($logo));

            $newCompany = new Company;
            $newCompany->name = $request->input('name');
            $newCompany->email = $request->input('email');
            $newCompany->logo = $logo->getFilename().'.'.$extension;
            $newCompany->webSite = $request->input('webSite');
            $newCompany->save();
        } else {
            $newCompany = new Company;
            $newCompany->name = $request->input('name');
            $newCompany->email = $request->input('email');
            $newCompany->logo = null;
            $newCompany->webSite = $request->input('webSite');
            $newCompany->save();
        }          

        
    
        return redirect()->route('companies.index')->with('info', 'Company created sucessfully');
    })->name('companies.store');
    
    Route::delete('companies/{id}', function($id){
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('info', 'Company deleted sucessfully');
    })->name('companies.destroy');
    
    Route::get('companies/{id}/edit', function($id){
        $company = Company::findOrFail($id);
        return view('companies.edit', compact('company'));
    })->name('companies.edit');
    
    Route::put('companies/{id}', function(Request $request, $id){       
        if($request->hasFile('logo')){
            $logo = $request->file('logo'); 
            $extension = $logo->getClientOriginalExtension();
            Storage::disk('public')->put('logos/'.$logo->getFilename().'.'.$extension,  File::get($logo));        

            $company = Company::findOrFail($id);
            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->logo = $logo->getFilename().'.'.$extension;
            $company->webSite = $request->input('webSite');
            $company->save();
        } else {
            $company = Company::findOrFail($id);
            $company->name = $request->input('name');
            $company->email = $request->input('email');
            $company->logo = null;
            $company->webSite = $request->input('webSite');
            $company->save();
        }
        return redirect()->route('companies.index')->with('info', 'Company edited sucessfully');
    })->name('companies.update');

    //Employees

    Route::get('employees/{companyId}', function ($companyId) {        
        $employees = Employee::orderBy('created_at', 'desc')->where('company_id', $companyId)->paginate(10);
        return view('employees.index', ['employees' => $employees, 'companyId' => $companyId]);
    })->name('employees.index');
    
    Route::get('employees/{companyId}/create', function ($companyId) {
        return view('employees.create',['companyId' => $companyId]);//->with('companyId', $companyId)
    })->name('employees.create');
    
    Route::post('employees', function(Request $request){
        $newEmployee = new Employee;
        $newEmployee->firstName = $request->input('firstName');
        $newEmployee->lastName = $request->input('lastName');
        $newEmployee->company_id = $request->input('company_id');
        $newEmployee->phone = $request->input('phone');
        $newEmployee->email = $request->input('email');
        $newEmployee->save();
    
        return redirect()->route('employees.index',['companyId' => $request->input('company_id')])->with('info', 'Employee created sucessfully');
    })->name('employees.store');
    
    Route::delete('employees/{id}', function($id){
        $employee = Employee::findOrFail($id);
        $companyId = $employee->company_id;
        $employee->delete();
        return redirect()->route('employees.index', ['companyId' => $companyId])->with('info', 'Employee deleted sucessfully');
    })->name('employees.destroy');
    
    Route::get('employees/{id}/edit', function($id){
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    })->name('employees.edit');
    
    Route::put('employees/{id}', function(Request $request, $id){
        $employee = Employee::findOrFail($id);
        $employee->firstName = $request->input('firstName');
        $employee->lastName = $request->input('lastName');
        $employee->company_id = $request->input('company_id');
        $employee->phone = $request->input('phone');
        $employee->email = $request->input('email');
        $employee->save();
        return redirect()->route('employees.index', ['companyId' => $request->input('company_id')])->with('info', 'Employee edited sucessfully');
    })->name('employees.update');

    Route::get('/logos/{filename?}', function ($filename)
{
    $path = storage_path('app/public') . '/logos/' . $filename;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
})->name('logos');
});



Auth::routes();
Route::get('/', function () {
    return view('home');
})->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
