<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectFormRequest;
use App\Repositories\SubjectRepository;

class SubjectController extends Controller
{
    protected $subjectReposittory;
    public function __construct(SubjectRepository $subjectReposittory){
        $this->subjectReposittory = $subjectReposittory;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = $this->subjectReposittory->getAll();
        return view('admin.subjects.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectFormRequest $request)
    {
        $this->subjectReposittory->create($request->all());
        return redirect()->route('subjects.index')->with('success', __('Created Successfully'));        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $subject = $this->subjectReposittory->detail($id);
        return view('admin.subjects.form',compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubjectFormRequest $request, string $id)
    {
        $this->subjectReposittory->update($request->all(),$id);
        return redirect()->route('subjects.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->subjectReposittory->delete($id);
        return redirect()->route('subjects.index')->with('success', __('Deleted Successfully'));
    }
}
