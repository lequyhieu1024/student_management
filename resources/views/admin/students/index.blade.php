@extends('admin.app')
@section('content')
    <style>
        .badges {
            width: 25px;
            font-size: 1em;
            border-radius: 20px;
            position: absolute;
            top: 0;
            right: 0;
            background-color: red;
            color: white;
        }
    </style>
    <div class="card p-4 table-responsive">
        <h1>{{ __('Student List') }}</h1>
        <div class="mb-4">
            <a href="{{ route('students.create') }}" class="btn btn-primary">+ {{ __('Create Student') }}</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <th>{{ __('Student Code') }}</th>
                <th>{{ __('Student Name') }}</th>
                <th>{{ __('Gender') }}</th>
                <th>{{ __('Birthday') }}</th>
                {{-- <th>{{ __('Total Subject Being Studied') }}</th> --}}
                <th>{{ __('Status') }}</th>
                <th class="col-3 mb-1">{{ __('Action') }}</th>
            </thead>
            <tbody>
                {{ Form::open(['method' => 'GET', 'route' => 'students.index']) }}
                <div class="filter row mb-4">
                    {{-- PAGINATION --}}
                    <div class="col-6 col-md-2">
                        <div class="d-flex align-items-center gap-1">
                            <span>{{ __('Show') }}</span>
                            {!! Form::select(
                                'size',
                                [
                                    10 => 10,
                                    50 => 50,
                                    200 => 200,
                                    500 => 500,
                                    3000 => 3000,
                                ],
                                request('size'),
                                [
                                    'class' => 'form-select',
                                    'id' => 'pagination',
                                ],
                            ) !!}
                            <span> {{ __('entries') }} </span>
                        </div>
                    </div>
                    {{-- PAGINATION END --}}
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="d-flex align-items-center gap-1">
                            <span>{{ __('Age From') }}</span>
                            {{ Form::text('age_from', request('age_from'), ['class' => 'form-control']) }}
                            <span>{{ __('To') }}</span>
                            {{ Form::text('age_to', request('age_to'), ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="d-flex align-items-center gap-1">
                            <span>{{ __('Score Average') }}</span>
                            {{ Form::text('score_from', request('score_from'), ['class' => 'form-control']) }}
                            <span>{{ __('To') }}</span>
                            {{ Form::text('score_to', request('score_to'), ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="d-flex align-items-center gap-1">
                            {{ Form::select('network', \App\Enums\Network::getSelectOptions(), request('network'), ['class' => 'form-select']) }}
                        </div>
                    </div>
                    <div class="col-md-2 mb-2">
                        <div class="d-flex align-items-center gap-1">
                            {{ Form::select('status', \App\Enums\Status::getSelectOptions(), request('status'), ['class' => 'form-select']) }}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('students.index') }}" class="btn btn-info"><i
                                class="bi bi-arrow-clockwise"></i></a>
                        {{ Form::button('<i class="bi bi-search"></i>', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
                    </div>
                </div>
                {{ Form::close() }}
    </div>
    @foreach ($students as $student)
        <tr>
            <td>{{ $student->student_code }}</td>
            <td>{{ $student->user->name }}</td>
            <td>{{ \App\Enums\Gender::getLabel($student->gender) }}
            </td>
            <td>{{ date('d/m/Y', strtotime($student->birthday)) }}</td>
            {{-- <td>{{ $student->subjects->count() }}</td> --}}
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
                <a href="{{ route('students.subject', $student->id) }}" title="Xem những môn đang học"
                    class="btn btn-secondary position-relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-card-checklist" viewBox="0 0 16 16">
                        <path
                            d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z" />
                        <path
                            d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0M7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0" />
                    </svg>
                    <span class="position-absolute top-0 start-100 translate-middle badges rounded-pill bg-danger">
                        {{ $student->subjects->count() }}
                    </span>
                </a>
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
