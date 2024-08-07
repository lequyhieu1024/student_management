@extends('admin.app')
@section('content')
    <div class="card p-4">
        <div class="border-bottom d-flex justify-content-between">
            <div class="card-title d-flex align-items-center gap-5">
                <div>
                    <img width="100" height="100" src="/{{ $students->avatar }}" alt="">
                </div>
                <div>
                    <h1 class="text-primary">
                        {{ $students->user->name }} - {{ $students->student_code }}
                    </h1>
                    <p class="d-flex gap-4">
                        <span>
                            <i class="bi bi-cake2"></i> {{ date('d-m-Y', strtotime($students->birthday)) }}
                        </span>
                        <span>
                            <i class="bi bi-envelope-at"></i> {{ $students->user->email }}
                        </span>
                        <span>
                            <i class="bi bi-telephone-inbound"></i> {{ $students->phone }}
                        </span>
                    </p>
                </div>
            </div>
            <div>
                <a href="{{ route('students.index') }}" class="btn btn-info">{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-content">
            <h2 class="card-content__title mt-4 d-flex justify-content-between">
                <div>
                    {{ __('Subject List') }}
                </div>
                <div>
                    <a onclick="viewModal2()" class="btn btn-warning d-none btn-update"><i class="bi bi-pen"></i>
                        {{ __('Update Score') }}</a>
                    <a href="{{ route('students.register-subject', $students->id) }}" class="btn btn-primary">+
                        {{ __('Register Subject') }}</a>
                </div>
            </h2>
            <div class="card-content__content table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>{{ __('Option') }}</th>
                        <th>{{ __('STT') }}</th>
                        <th>{{ __('Subject Name') }}</th>
                        <th>{{ __('Score') }}</th>
                    </thead>
                    <tbody>
                        @forelse ($students->subjects as $index => $subject)
                            <tr>
                                <td class="col-1">
                                    <input type="checkbox" name="student_subjects[]" class="student_subject"
                                        value="{{ $subject->pivot->id }}" data-subject-id="{{ $subject->id }}"
                                        data-subject-name="{{ $subject->name }}"
                                        data-score="{{ $subject->pivot->score ? $subject->pivot->score : '' }}"
                                        onchange="toggleUpdateButton('student_subject','btn-update' )">

                                </td>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $subject->name }}</td>
                                <td class="col-2">
                                    <div class="position-relative">
                                        <input type="text" disabled name="score" class="form-control pr-5"
                                            value="{{ $subject->pivot->score ? $subject->pivot->score : 'N/A' }}" />
                                        <button type="button"
                                            onclick="viewModal(`{{ route('students.edit-score', [$students->id, $subject->id]) }}`)"
                                            class="btn btn-outline-warning position-absolute"
                                            style="top: 0; right: 0; height: 100%;">
                                            @if ($subject->pivot->score)
                                                <i class="bi bi-pen"></i>
                                            @else
                                                <i class="bi bi-plus"></i>
                                            @endif
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">{{ __('No data') }}</td>
                            </tr>
                        @endforelse
                        <tr>
                            <td colspan="3"></td>
                            <td class="col-2">
                                {{ __('Score Average') }} : <b>{{ $students->subjects->avg('pivot.score') ?? 0.0 }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="updateScoreModal" tabindex="-1" aria-labelledby="updateScoreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title border-bottom"> {{ __('Update Score') }} </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateScoreForm" method="POST" action="{{ route('students.update-scores') }}"
                        onsubmit="return validator()">
                        @csrf
                        <div class="row" id="subjectsContainer"></div>
                        <input type="hidden" name="student_id" id="studentId" value="{{ $students->id }}">
                        <button type="submit" class="btn btn-primary">{{ __('Update Score') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('admin/js/update-scores.js') }}"></script>
