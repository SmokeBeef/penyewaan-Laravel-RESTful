<?php

namespace App\Http\Controllers;


use App\Http\Requests\admin\AdminRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Generator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', "create"]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AdminRequest $req)
    {
        $credentials = $req->validated();
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() // get data from admin now
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    public function create(AdminRequest $req): Response
    {
        $data = $req->validated();

        $check_username = Admin::where("username", $data["username"])->first();

        if ($check_username) {
            return response([
                "errors" => ["username already exist"]
            ], 400);
        }

        $admin = new Admin($data);

        $admin->password = Hash::make($data["password"]);


        $admin->save();

        return response([
            "message" => "success"
        ], 201);
    }
    // public function login(AdminRequest $req): Response
    // {
    //     $tokenKey = "token:username:";
    //     $data = $req->validated();

    //     $admin = Admin::where("username", $data["username"])->first();

    //     if (!$admin || !Hash::check($data["password"], $admin->password)) {
    //         return response([
    //             "errors" => ["username or password wrong"]
    //         ], 404);
    //     }

    //    $token = Str::uuid()->toString();

    //    Cache::set($tokenKey.$admin->username, $token,now()->addSecond(10));

    //    return response([
    //     "message" => "success",
    //     "data" => [
    //         "token" => $token
    //     ]
    //    ]);
    // }
}
