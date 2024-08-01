<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentFormRequest;
use App\Repositories\DepartmentRepository;

class DepartmentController extends Controller
{
    protected $departmentRepository;
    public function __construct(DepartmentRepository $departmentRepository){
        $this->departmentRepository = $departmentRepository;
    }
    public function index()
    {
        $departments = $this->departmentRepository->getAll();
        return view('admin.departments.index',compact('departments',));
    }
    public function create(){
        return view('admin.departments.form');
    }
    public function store(DepartmentFormRequest $request){
        $this->departmentRepository->create($request->all());
        return redirect()->route('departments.index')->with('success',__('Created Successfully'));
    }
    public function edit($id){
        $department = $this->departmentRepository->detail($id);
        return view('admin.departments.form',compact('department'));
    }
    public function update(DepartmentFormRequest $request, $id){
        $this->departmentRepository->update($request->all(),$id);
        return redirect()->route('departments.index')->with('success',__('Updated Successfully'));
    }
    public function destroy($id){
        $this->departmentRepository->delete($id);
        return redirect()->route('departments.index')->with('success',__('Deleted Successfully'));
    }
}
