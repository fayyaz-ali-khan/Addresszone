<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Traits\FileHandler;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
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

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($user->image) {
                $this->deleteFile($user->image);
            }
            $data['image'] = $this->storeFile($request->file('image'), 'images/users');
        }

        if ($request->hasFile('CNIC_Front_Image') && $request->file('CNIC_Front_Image')->isValid()) {
            if ($user->CNIC_Front_Image) {
                $this->deleteFile($user->CNIC_Front_Image);
            }
            $data['CNIC_Front_Image'] = $this->storeFile($request->file('CNIC_Front_Image'), 'images/users/cnic');
        }
        if ($request->hasFile('CNIC_Back_Image') && $request->file('CNIC_Back_Image')->isValid()) {
            if ($user->CNIC_Back_Image) {
                $this->deleteFile($user->CNIC_Back_Image);
            }
            $data['CNIC_Back_Image'] = $this->storeFile($request->file('CNIC_Back_Image'), 'images/users/cnic');
        }
        if ($request->hasFile('Passport_Front_Image') && $request->file('Passport_Front_Image')->isValid()) {
            if ($user->Passport_Front_Image) {
                $this->deleteFile($user->Passport_Front_Image);
            }
            $data['Passport_Front_Image'] = $this->storeFile($request->file('Passport_Front_Image'), 'images/users/passport');
        }

        $user->fill($data)->save();

        return response()->json(['message' => 'Profile updated successfully', 'user' => $user]);
    }
}
