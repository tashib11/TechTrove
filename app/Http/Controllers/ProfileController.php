<?php
namespace App\Http\Controllers;
use App\Helper\ResponseHelper;
use App\Models\CustomerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function ProfilePage(){
        return view('pages.profile-page');
    }
    public function CreateProfile(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $request->merge(['user_id' => $user_id]);

        $data = CustomerProfile::updateOrCreate(
            ['user_id' => $user_id],
            $request->input()
        );

        return ResponseHelper::Out('Thank You', $data, 200);
    }

    public function ReadProfile(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $profile = CustomerProfile::where('user_id', $user_id)->first();

        if ($profile) {
            return ResponseHelper::Out('success', $profile, 200);
        } else {
            return ResponseHelper::Out('fail', 'Profile not found', 404);
        }
    }

    public function CheckProfile(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $exists = CustomerProfile::where('user_id', $user_id)->exists();

        return ResponseHelper::Out('success', ['hasProfile' => $exists], 200);
    }

}
