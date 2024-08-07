<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\StudentRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    protected $studentRepository;
    protected $userRepository;

    public function __construct(StudentRepository $studentRepository, UserRepository $userRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = $this->userRepository->show(Auth::user()->id);
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function updateAvatar(ProfileUpdateRequest $request)
    {
        $data['avatar'] = upload_image($request->file('avatar'));
        $user = $this->userRepository->show(Auth::user()->id);
        $student = $this->studentRepository->update($data, $user->student->id);
        if (!$student) {
            return redirect()->back()->with('error', __('Update Failed'));
        }
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
