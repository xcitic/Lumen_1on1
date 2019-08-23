<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{

  /**
   * Creates a new User instance and persists it to the database
   * @param  UserStoreRequest $request [validate & sanitize input]
   * @return Array  [token & user object]
   */
  public function register(Request $request)
  {


      $password = password_hash($request->password, PASSWORD_DEFAULT);

      try {
        $user = User::create([
          'name' => $request->name,
          'email' => $request->email,
          'password' => $password,
        ]);
        $user->save();

        // Generate token with passport
        $token = $user->createToken('bearer')->accessToken;

        $token = ['token' => $token];

        $response = [
          'user' => $user,
          'token' => $token
        ];

        return response()->json($response, 200);

      } catch (\Exception $e) {
        return response(['errors' => 'Invalid input'], 422);
      }

      return response(['errors' => 'Invalid input'], 422);

  }

  /**
   * User login
   * @param  UserLoginRequest $request [description]
   * @return Object                    [User object & Token]
   */
  public function login(Request $request)
  {

    // find the user
    $user = User::where('email', $request->email)->first();

    if ($user) {
      // check the hashed password
      if (password_verify($request->password, $user->password))
      {
        // Generate token with passport
        $token = $user->createToken('bearer')->accessToken;

        $response = [
          'user' => $user,
          'token' => $token
        ];
        return response($response, 200);
      }
    }

    return response(['errors' => 'Wrong email or password'], 422);

  }

  public function getUser() {
    $user = User::all();

    return response()->json($user);
  }


}
