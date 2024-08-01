<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Repositories\StudentRepository;
use App\Http\Requests\UpdateStudentRequest;
use App\Repositories\DepartmentRepository;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $userRepository;
    protected $departmentRepository;
    /**
     * Display a listing of the resource.
     */
    public function __construct(StudentRepository $studentRepository, UserRepository $userRepository, DepartmentRepository $departmentRepository){
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
    }
    public function index(Request $request)
    {   
        $q = [];
        $q['pageSize'] = $request->query('size', 10);
        $q['ageFrom'] = $request->query('age_from');
        $q['ageTo'] = $request->query('age_to');
        $q['scoreFrom'] = $request->query('score_from');
        $q['scoreTo'] = $request->query('score_to');
        $q['network'] = $request->query('network');
        $q['status'] = $request->query('status');
        $students = $this->studentRepository->filter($q);
        return view('admin.students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->departmentRepository->getNameAndIds();
        return view('admin.students.create',compact('departments',));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->validated();
            if($request->hasFile('avatar')){
                $data['avatar'] = upload_image($request->file('avatar'));
            }
            
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
            $student = $this->studentRepository->create([
                'user_id' => $user->id,
                'student_code' => date('Y').$user->id,
                'avatar' => $data['avatar'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'birthday' => $data['birthday'],
                'address' => $data['address'],
                'department_id' => $data['department_id'],
            ]);
            DB::commit();
            return redirect()->route('students.index')->with('success', __('Create Student Successfully'));
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('students.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = $this->studentRepository->detail($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = $this->studentRepository->detail($id);
        $departments = $this->departmentRepository->getNameAndIds();
        return view('admin.students.edit', compact('student','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, string $id)
    {
        try{
            DB::beginTransaction();
            $data = $request->validated();
            if($request->hasFile('avatar')){
                $data['avatar'] = upload_image($request->file('avatar'));
            }
            
            $this->userRepository->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ],$id);
            $this->studentRepository->update([
                'avatar' => $data['avatar'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'birthday' => $data['birthday'],
                'address' => $data['address'],
                'department_id' => $data['department_id'],
            ], $id);
            DB::commit();
            return response(['success' => true,
                'message' => __('Update Student Successfully')
            ],200);
        }catch(Exception $e){
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->studentRepository->delete($id);
        return redirect()->route('students.index')->with('success', __('Delete Student Successfully'));
    }
}
