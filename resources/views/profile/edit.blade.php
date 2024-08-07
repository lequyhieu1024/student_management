@extends('admin.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card p-4">
                <div class="card-title">
                    <h1>
                        Tài khoản
                    </h1>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img src="/{{ $user->avatar }}" alt="user-avatar" class="d-block rounded" height="100"
                            width="100" />
                        <form class="button-wrapper" method="post" action="{{ route('profile.update-avatar', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <label for="upload" class="btn btn-outline-secondary  me-2 mb-4" tabindex="0">
                                <span>Thay ảnh đại diện</span>
                                <input type="file" id="upload" name="avatar" class="account-file-input" hidden
                                    accept="image/*" onchange="this.form.submit()" />
                            </label>
                            <p class="text-muted mb-0">Tải lên ảnh đại diện của bạn</p>
                            @if ($errors->has('avatar'))
                                <span class="text-danger">{{ $errors->first('avatar') }}</span>
                            @endif
                        </form>
                    </div>
                    <div class="mt-5">
                        <a href="{{ route('students.subject', auth()->user()->student->id) }}" class="btn btn-primary">Xem
                            bảng
                            điểm của tôi</a>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label"> {{ __('Student Code') }} </label>
                            <input class="form-control" type="text" value="{{ $user->student->student_code }}"
                                disabled />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Họ và tên</label>
                            <input class="form-control" type="text" value="{{ $user->name }}" disabled />
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" type="text" value="{{ $user->email }}" disabled />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input class="form-control" type="text" value="{{ $user->student->phone }}" disabled />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Ngày sinh</label>
                            <input class="form-control" type="text" value="{{ $user->student->birthday }}" disabled />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input class="form-control" value="{{ $user->student->address }}" disabled />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Giới tính</label>
                            <input class="form-control" value="{{ \App\Enums\Gender::getLabel($user->student->gender) }}"
                                disabled />
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Khoa</label>
                            <input class="form-control" value="{{ $user->student->department->name }}" disabled />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
