<?php

declare(strict_types=1);
namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthService {
     public function create(RegisterRequest $request): User
     {
          $user = User::updateOrCreate(
               [
                    'email' => $request->email
               ],
               [
                    'name'     => $request->name,
                    'phone'    => $request->phone,
                    'password' => $request->password
               ]
          );
          return $user;
     }
}
