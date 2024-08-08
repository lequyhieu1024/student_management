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
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importExel">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" stroke-width="1.5" fill="currentColor"
                    class="bi bi-filetype-xlsx" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M14 4.5V11h-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM7.86 14.841a1.13 1.13 0 0 0 .401.823q.195.162.479.252.284.091.665.091.507 0 .858-.158.355-.158.54-.44a1.17 1.17 0 0 0 .187-.656q0-.336-.135-.56a1 1 0 0 0-.375-.357 2 2 0 0 0-.565-.21l-.621-.144a1 1 0 0 1-.405-.176.37.37 0 0 1-.143-.299q0-.234.184-.384.188-.152.513-.152.214 0 .37.068a.6.6 0 0 1 .245.181.56.56 0 0 1 .12.258h.75a1.1 1.1 0 0 0-.199-.566 1.2 1.2 0 0 0-.5-.41 1.8 1.8 0 0 0-.78-.152q-.44 0-.777.15-.336.149-.527.421-.19.273-.19.639 0 .302.123.524t.351.367q.229.143.54.213l.618.144q.31.073.462.193a.39.39 0 0 1 .153.326.5.5 0 0 1-.085.29.56.56 0 0 1-.255.193q-.168.07-.413.07-.176 0-.32-.04a.8.8 0 0 1-.249-.115.58.58 0 0 1-.255-.384zm-3.726-2.909h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415H1.5l1.24-2.016-1.228-1.983h.931l.832 1.438h.036zm1.923 3.325h1.697v.674H5.266v-3.999h.791zm7.636-3.325h.893l-1.274 2.007 1.254 1.992h-.908l-.85-1.415h-.035l-.853 1.415h-.861l1.24-2.016-1.228-1.983h.931l.832 1.438h.036z" />
                </svg> {{ __('Import Scores By Exel') }}
            </button>
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
    <div class="modal fade" id="importExel" tabindex="-1" aria-labelledby="importExel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title border-bottom"> {{ __('Import Scores By Exel') }} </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="{{ route('students.get-template') }}">
                        {{ __('Please Download Exel Template Here') }}
                    </a>
                    {!! Form::open([
                        'url' => route('students.import'),
                        'method' => 'POST',
                        'id' => 'importExelForm',
                        'class' => 'mt-2',
                    ]) !!}
                    <div class="col-12 mb-2">
                        {!! Form::file('file', ['class' => 'form-control']) !!}
                    </div>
                    <span class="text-danger mb-3" id="error"></span>
                    <div class="form-group mt-2">
                        {!! Form::submit(__('Confirm'), ['class' => 'btn btn-primary', 'accept/xlsx, csv']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#importExelForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#error').text('');
                        $('#importExel').modal('hide');
                        alert('{{ __('Import Successfully') }}');
                    },
                    error: function(response) {
                        if (response.responseJSON.errors.file) {
                            $('#error').text(response.responseJSON.errors.file);
                        }
                        if (response.responseJSON.message) {
                            $('#error').text(response.responseJSON.message);
                        }
                        if (response.status == 404) {
                            $('#error').text(response.responseJSON.errors[0]);
                        }
                    }
                });
            });
        });
    </script>
@endsection
