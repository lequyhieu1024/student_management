<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Models\Student;
use App\Repositories\RoleRepository;
use Exception;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Imports\StudentsImport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImportStudentExcelRequest;
use App\Repositories\UserRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\StudentRepository;
use App\Repositories\SubjectRepository;
use App\Http\Requests\StudentFormRequest;
use App\Repositories\DepartmentRepository;
use App\Http\Requests\RegisterSubjectFormRequest;

class StudentController extends Controller
{
    protected $studentRepository;
    protected $userRepository;
    protected $departmentRepository;
    protected $subjectRepository;
    protected $roleRepository;

    /**
     * Display a listing of the resource.
     */
    public function __construct(StudentRepository $studentRepository, UserRepository $userRepository, DepartmentRepository $departmentRepository, SubjectRepository $subjectRepository, RoleRepository $roleRepository)
    {
        $this->middleware('permission:list_student')->only(['index']);
        $this->middleware('permission:create_student')->only(['create', 'store']);
        $this->middleware('permission:show_student')->only(['show']);
        $this->middleware('permission:update_student')->only(['edit', 'update']);
        $this->middleware('permission:destroy_student')->only(['destroy']);
        $this->middleware('permission:update_score')->only(['editScore', 'updateScores']);
        $this->middleware('permission:self_register_subject|register_subject')->only(['registerSubject', 'storeRegisterSubject']);
        $this->middleware('permission:import_excel')->only(['import', 'getTemplate']);
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
        $this->departmentRepository = $departmentRepository;
        $this->subjectRepository = $subjectRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index(Request $request)
    {
        $students = $this->studentRepository->filter($request->all());
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = $this->departmentRepository->getNameAndIds();
        return view('admin.students.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            if ($request->hasFile('avatar')) {
                $data['avatar'] = upload_image($request->file('avatar'));
            }
            dd($this->roleRepository->findOrFail(16)->name);
            $user = $this->userRepository->create($data)->assignRole($this->roleRepository->findOrFail(16)->name);
            $data['user_id'] = $user->id;
            $data['student_code'] = date('Y') . $user->id;
            $this->studentRepository->create($data);
            SendEmailJob::dispatch($data);
            DB::commit();
            return redirect()->route('students.index')->with('success', __('Create Student Successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = $this->studentRepository->show($id);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = $this->studentRepository->show($id);
        $departments = $this->departmentRepository->getNameAndIds();
        return view('admin.students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentFormRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if ($request->hasFile('avatar')) {
                $data['avatar'] = upload_image($request->file('avatar'));
                $this->studentRepository->findOrFail($id)->avatar ? unlink($this->studentRepository->findOrFail($id)->avatar) : '';
            } else {
                $data['avatar'] = $this->studentRepository->findOrFail($id)->avatar;
            }
            $this->userRepository->updateUser($data, $this->studentRepository->show($id)->user_id);
            $this->studentRepository->updateStudent($data, $id);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully!',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->show($id);
            unlink($student->avatar);
            $student->delete($id);
            // $student->user->delete();
            DB::commit();
            return redirect()->route('students.index')->with('success', __('Delete Student Successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function getSubjects($id)
    {
        $students = $this->studentRepository->show($id);
        return view('admin.students.subjects-by-student', compact('students'));
    }

    public function editScore($studentId, $subjectId)
    {
        $score = $this->studentRepository->getScoreByStudentSubjectId($studentId, $subjectId);
        return view('admin.students.update-score', compact('score', 'studentId', 'subjectId'));
    }
    public function updateScores(Request $request)
    {
        $this->studentRepository->updateScore($request->student_id, $request->scores);
        return redirect()->route('students.subject', $request->student_id)->with('success', __('Updated Successfully'));
    }
    public function registerSubject($id)
    {
        $subjects = $this->subjectRepository->getSubjectDoesntHasStudent($id);
        return view('admin.students.register-subject', compact('subjects', 'id'));
    }
    public function storeRegisterSubject(RegisterSubjectFormRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $student = $this->studentRepository->findOrFail($id);
            $studentSubject = $student->subjects->pluck('id')->toArray();
            $subejectId = is_array($request->subject_id) ? $request->subject_id : [$request->subject_id];

            if (!empty(array_intersect($studentSubject, $subejectId))) {
                if (!auth()->user()->student) {
                    return redirect()->route('students.subject', $id)->with('error', __('Registation Failed'));
                }
                return redirect()->back()->with('error', __('Registation Failed'));
            }
            $this->studentRepository->registerSubject($id, $request->subject_id);
            DB::commit();
            if (!auth()->user()->student) {
                return redirect()->route('students.subject', $id)->with('success', __('Registation Successfully'));
            }
            return redirect()->back()->with('success', __('Registation Successfully'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function getTemplate()
    {
        return Excel::download(new StudentsExport, 'students_subjects_scores.xlsx');
    }
    public function import(ImportStudentExcelRequest $request)
    {
        $import = new StudentsImport();
        Excel::import($import, $request->file('file'));
        $errors = $import->getErrors();

        if (count($errors) > 0) {
            return response()->json(['errors' => $errors], 404);
        }
        return response()->json(['success' => __('Import Successfully')]);
    }
    public function getListSubjectAjax()
    {
        $subjects = $this->subjectRepository->all();
        return response()->json([
            'success' => true,
            'subject' => $subjects
        ], 200);
    }
}
