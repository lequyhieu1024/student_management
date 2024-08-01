@extends('admin.app')
@section('content')
    <div class="card p-4">
        <h1>{{ __('Student List') }}</h1>
        <div class="mb-4">
            <a href="{{ route('students.create') }}" class="btn btn-primary">+ {{ __('Create Student') }}</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Student Code') }}</th>
                <th>{{ __('Student Name') }}</th>
                <th>{{ __('Gender') }}</th>
                <th>{{ __('Birthday') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Action') }}</th>
            </thead>
            <tbody>
                <div class="filter row mb-4">
                    {{-- PAGINATION --}}
                    <div class="col-6 col-md-2">
                        <div class="d-flex align-items-center gap-1">
                            <span>{{ __('Show') }}</span>
                            <form action="{{ route('students.index') }}" method="GET" id="pagination-form">
                                <select name="size" class="form-select" id="pagination" onchange="this.form.submit()">
                                    <option value="10" {{ request('size') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="50" {{ request('size') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="200" {{ request('size') == 200 ? 'selected' : '' }}>200</option>
                                    <option value="500" {{ request('size') == 500 ? 'selected' : '' }}>500</option>
                                    <option value="3000" {{ request('size') == 3000 ? 'selected' : '' }}>3000</option>
                                </select>
                            </form>
                            <span> {{ __('entries') }} </span>
                        </div>
                    </div>
                </div>
                {{-- PAGINATION END --}}
                <div class="filter row mb-4">
                    <form action="{{ route('students.index') }}" method="GET">
                        {{-- FILTER BY AGE --}}
                        <div class="col-md-3">
                            <div class="d-flex align-items-center gap-1">
                                <span>{{ __('Age From') }}</span>
                                <input type="text" class="form-control" name="age_from">
                                <span>{{ __('To') }}</span>
                                <input type="text" class="form-control" name="age_to">
                            </div>
                        </div>
                        {{-- FILTER BY AGE END --}}
                        {{-- FILTER BY SCORE --}}
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center gap-1">
                                <span>{{ __('Score From') }}</span>
                                <input type="text" class="form-control" name="score_from">
                                <span>{{ __('To') }}</span>
                                <input type="text" class="form-control" name="score_to">
                            </div>
                        </div>
                        {{-- FILTER BY SCORE END --}}
                        {{-- FILTER BY SCORE --}}
                        {{-- NETWORK --}}
                        <div class="col-md-2 mb-2">
                            <div class="d-flex align-items-center gap-1">
                                <select name="network" class="form-select">
                                    <option>-- {{ __('Chose Network') }} --</option>
                                    <option value="1" {{ request('network') == 1 ? 'selected' : '' }}>Vinaphone
                                    </option>
                                    <option value="2" {{ request('network') == 2 ? 'selected' : '' }}>Viettel</option>
                                    <option value="3" {{ request('network') == 3 ? 'selected' : '' }}>Mobifone
                                    </option>
                                </select>
                            </div>
                        </div>
                        {{-- NETWORK END --}}
                        {{-- SUBJECT --}}
                        <div class="col-md-2 mb-2">
                            <div class="d-flex align-items-center gap-1">
                                <select name="status" class="form-select">
                                    <option>--{{ __('Chose Status') }}--</option>
                                    <option value="1" {{ request('status') == 1 ? 'selected' : '' }}>Đã học hết môn
                                    </option>
                                    <option value="2" {{ request('status') == 2 ? 'selected' : '' }}>Chưa học hết môn
                                    </option>
                                </select>
                            </div>
                        </div>
                        {{-- SUBJECT END --}}
                        <div class="col-md-2">
                            <button class="btn btn-primary">{{ __('Search') }}</button>
                        </div>
                    </form>
                </div>
    </div>
    @foreach ($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->student_code }}</td>
            <td>{{ $student->name }}</td>
            <td>{{ $student->gender ? __('Male') : __('Female') }}</td>
            <td>{{ date('d/m/Y', strtotime($student->birthday)) }}</td>
            <td>
                @if ($student->status == 0)
                    <span class="badge bg-danger">{{ __('Banned') }}</span>
                @elseif($student->status == 1)
                    <span class="badge bg-primary">{{ __("Haven't studied yet") }}</span>
                @elseif($student->status == 2)
                    <span class="badge bg-info">{{ __('Studying') }}</span>
                @elseif($student->status == 3)
                    <span class="badge bg-success">{{ __('Finished') }}</span>
                @endif
            </td>
            <td>
                <a href="#" onclick="viewModal(`{{ route('students.show', $student->id) }}`)" class="btn btn-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-eye-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                        <path
                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                    </svg>
                </a>
                <a href="#" onclick="viewModal(`{{ route('students.edit', $student->id) }}`)"
                    class="btn btn-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                </a>
                {!! Form::open([
                    'method' => 'DELETE',
                    'route' => ['students.destroy', $student->id],
                    'style' => 'display:inline;',
                ]) !!}
                {!! Form::button('<i class="bi bi-trash-fill"></i>', [
                    'type' => 'submit',
                    'class' => 'btn btn-danger',
                    'onclick' => 'return confirm("' . __('Are you sure?') . '")',
                ]) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
    </table>
    <div class="col-12">
        {{ $students->links() }}
    </div>
    </div>
@endsection
