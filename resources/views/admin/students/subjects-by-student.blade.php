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
                <a href="{{ isset(auth()->user()->student->id) ? route('profile.edit') : route('students.index') }}"
                   class="btn btn-info">{{ __('Back') }}</a>
            </div>
        </div>
        <div class="card-content">
            <h2 class="card-content__title mt-4 d-flex justify-content-between">
                <div>
                    {{ __('Subject List') }}
                </div>
                <div>
                    @canany(['register_subject', 'self_register_subject'])
                        <a href="{{ route('students.register-subject', $students->id) }}" class="btn btn-primary">+
                            {{ __('Register Subject') }}</a>
                    @endcanany
                </div>
            </h2>
            <div class="card-subject__add-subjects pb-3" id="form-update">
                <div class="pb-3 ">
                    <form id="updateScoreForm" method="POST"
                          action="{{ route('students.update-scores', $students->id) }}">
                        @csrf
                        @method('PUT')
                        <div id="subjectsContainer">
                            @if (session()->has('old_html'))
                                @php
                                    $old_html = session('old_html');
                                @endphp
                                @foreach ($old_html as $subjectId => $score)
                                    <div class="d-flex justify-content-center subjects gap-2 p-2">
                                        <div class="col-8">
                                            <select name="subject[]" class="form-control">
                                                <option value="">Chọn 1 môn học</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        {{ $subject->id == $subjectId ? 'selected' : '' }}>
                                                        {{ $subject->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('subject.' . $loop->index)
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control"
                                                   name="scores[{{ $subjectId }}][score]"
                                                   value="{{ is_array($score) ? implode(', ', $score) : $score }}" />
                                            @error('scores.' . $subjectId . '.score')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-1">
                                            <a class="removeBtn text-white btn btn-danger">x</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($students->subjects as $subject)
                                    <div class="d-flex justify-content-center subjects gap-2 p-2">
                                        <div class="col-8">
                                            <select name="subject[]" class="form-control">
                                                <option value="">Chọn 1 môn học</option>
                                                @foreach ($subjects as $sub)
                                                    <option value="{{ $sub->id }}"
                                                        {{ $sub->id == $subject->id ? 'selected' : '' }}>
                                                        {{ $sub->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control"
                                                   name="scores[{{ $subject->id }}][score]"
                                                   value="{{ $subject->pivot->score !== null ? $subject->pivot->score : '' }}" />
                                        </div>
                                        <div class="col-1">
                                            <a class="removeBtn text-white btn btn-danger">x</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="submit" id="btn-submit"
                                class="btn btn-primary d-none mt-2">{{ __('Update Score') }}</button>
                        @can('update_score')
                            <button type="button" class="btn btn-success mt-2" id="addBtn">+ {{ __('Add Score Subject') }}
                            </button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if (session()->has('old_html'))
        @php
            $old_html = session('old_html');
        @endphp

        <script>
            window.old_html = @json($old_html);
        </script>
    @endif
    <script src="{{ asset('admin/js/update-scores.js') }}"></script>
@endsection
