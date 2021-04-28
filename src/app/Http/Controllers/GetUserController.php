<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class GetUserController extends BaseController
{
    public function __invoke(String $id): JsonResponse{

        $user = DB::table('users')->where('id',$id)->first();

        return response()->json([
            'name' => $user->username,
            'passwd' => $user->password

        ], Response::HTTP_OK);
    }
}
