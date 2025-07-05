<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{

    public function PolicyPage()
    {
        return view('pages.policy-page');
    }


    public function PolicyByType(Request $request){
        $policy=Policy::where('type','=',$request->type)->first();
      return ResponseHelper::Out("success", $policy, 200);
    }

      public function index()
    {
        return view('admin.policies');
    }

    public function getPolicy($type)
    {
        $policy = Policy::where('type', $type)->first();
        return response()->json($policy);
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:about,refund,terms,how to buy,contact,complain',
            'des' => 'required',
        ]);

        $policy = Policy::updateOrCreate(
            ['type' => $request->type],
            ['des' => $request->des]
        );

        return response()->json(['status' => 'success', 'message' => 'Policy saved successfully.']);
    }

}
