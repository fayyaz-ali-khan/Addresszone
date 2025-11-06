<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Traits\FileHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;


class ProfileController
{
    use FileHandler;

    public function show(): JsonResponse
    {
        return response()->json(['user' => new UserResource(request()->user())]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = request()->user();
        $data = $request->validated();

        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];

        if ($request->boolean('delete_action.image') && !$request->hasFile('image')) {
            if ($user->image) {
                $this->deleteFile($user->image);
            }
            $data['image'] = null;
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image) {
                $this->deleteFile($user->image);
            }
            $data['image'] = $this->storeFile($request->file('image'), 'images/users');
        }

        if ($request->boolean('delete_action.CNIC_Front_Image') && !$request->hasFile('CNIC_Front_Image')) {
            if ($user->CNIC_Front_Image) {
                $this->deleteFile($user->CNIC_Front_Image);
            }
            $data['CNIC_Front_Image'] = null;
        }
        if ($request->hasFile('CNIC_Front_Image') && $request->file('CNIC_Front_Image')->isValid()) {
            if ($user->CNIC_Front_Image) {
                $this->deleteFile($user->CNIC_Front_Image);
            }
            $data['CNIC_Front_Image'] = $this->storeFile($request->file('CNIC_Front_Image'), 'images/users/cnic');
        }

        if ($request->boolean('delete_action.CNIC_Back_Image') && !$request->hasFile('CNIC_Back_Image')) {
            if ($user->CNIC_Back_Image) {
                $this->deleteFile($user->CNIC_Back_Image);
            }
            $data['CNIC_Back_Image'] = null;
        }
        if ($request->hasFile('CNIC_Back_Image') && $request->file('CNIC_Back_Image')->isValid()) {
            if ($user->CNIC_Back_Image) {
                $this->deleteFile($user->CNIC_Back_Image);
            }
            $data['CNIC_Back_Image'] = $this->storeFile($request->file('CNIC_Back_Image'), 'images/users/cnic');
        }

        if ($request->boolean('delete_action.Passport_Front_Image') && !$request->hasFile('Passport_Front_Image')) {
            if ($user->Passport_Front_Image) {
                $this->deleteFile($user->Passport_Front_Image);
            }
            $data['Passport_Front_Image'] = null;
        }
        if ($request->hasFile('Passport_Front_Image') && $request->file('Passport_Front_Image')->isValid()) {
            if ($user->Passport_Front_Image) {
                $this->deleteFile($user->Passport_Front_Image);
            }
            $data['Passport_Front_Image'] = $this->storeFile($request->file('Passport_Front_Image'), 'images/users/passport');
        }

        $user->fill($data)->save();

        return response()->json(['message' => 'Profile updated successfully', 'user' => new UserResource($user)]);
    }


    public function changePassword(): JsonResponse
    {
        $user = request()->user();

        $data = request()->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 403);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        $user->tokens()->delete();

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'message' => 'Password updated successfully',
            'user'  => new UserResource($user),
            'token' => $token,
        ]);
    }
}
