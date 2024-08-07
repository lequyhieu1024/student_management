<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;
use App\Http\Requests\DepartmentFormRequest;

class DepartmentController extends Controller
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function index(Request $request)
    {

        $departments = $this->departmentRepository->getAll($request->all());
        return view('admin.departments.index', compact('departments'));
    }
    public function create()
    {
        return view('admin.departments.form');
    }
    public function store(DepartmentFormRequest $request)
    {
        $this->departmentRepository->create($request->all());
        return redirect()->route('departments.index')->with('success', __('Created Successfully'));
    }
    public function edit($id)
    {
        $department = $this->departmentRepository->findOrFail($id);
        return view('admin.departments.form', compact('department'));
    }
    public function update(DepartmentFormRequest $request, $id)
    {
        $this->departmentRepository->update($request->all(), $id);
        return redirect()->route('departments.index')->with('success', __('Updated Successfully'));
    }
    public function destroy($id)
    {
        // dd(1);
        $this->departmentRepository->delete($id);
        return redirect()->route('departments.index')->with('success', __('Deleted Successfully'));
    }
}
