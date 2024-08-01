@extends('admin.app')
@section('content')
    <div class="card p-4">
        <div class="card-title">
            <h1 class="text-primary">{{ __('Create Student') }}</h1>
        </div>
        <div class="card-form row">
            {!! Form::open(['route' => 'students.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            <div class="row">
                <div class="form-group col-md-6 mb-3">
                    {!! Form::label('name', __('Student Name'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::text('name', old('name'), [
                        'class' => 'form-control',
                        'placeholder' => __('Student Name'),
                    ]) !!}
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-3">
                    {!! Form::label('email', __('Email'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::email('email', old('email'), [
                        'class' => 'form-control',
                        'placeholder' => __('Email'),
                    ]) !!}
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4 mb-3">
                    {!! Form::label('phone', __('Phone'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::number('phone', old('phone'), [
                        'class' => 'form-control',
                        'placeholder' => __('Phone'),
                    ]) !!}
                    @error('phone')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4 mb-3">
                    {!! Form::label('gender', __('Gender'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::select('gender', [true => __('Male'), false => __('Female')], old('gender'), [
                        'class' => 'form-control',
                        'placeholder' => '--' . __('Chose Gender') . '--',
                    ]) !!}
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4 mb-3">
                    {!! Form::label('birthday', __('Birthday'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::date('birthday', old('birthday'), [
                        'class' => 'form-control',
                        'placeholder' => __('Birthday'),
                    ]) !!}
                    @error('birthday')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-3">
                    {!! Form::label('address', __('Address'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::text('address', old('address'), [
                        'class' => 'form-control',
                        'placeholder' => __('Address'),
                    ]) !!}
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-3">
                    {!! Form::label('avatar', __('Avatar'), ['class' => 'mb-1']) !!}
                    {!! Form::file('avatar', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-6 mb-3">
                    {!! Form::label('department_id', __('Chose Department'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::select('department_id', $departments, old('department_id'), [
                        'class' => 'form-control',
                        'placeholder' => '--' . __('Chose Department') . '--',
                    ]) !!}
                    @error('department_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-3">
                    {!! Form::label('password', __('Password'), ['class' => 'mb-1']) !!} <span class="text-danger">(*)</span>
                    {!! Form::password('password', [
                        'class' => 'form-control',
                        'placeholder' => __('Password'),
                    ]) !!}
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::submit(__('Create Student'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::reset(__('Reset'), [
                        'type' => 'reset',
                        'class' => 'btn btn-secondary',
                    ]) !!}
                    <a href="{{ route('students.index') }}" class="btn btn-info">{{ __('Back') }}</a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
