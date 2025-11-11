<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Http\Requests\LoginRequest;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 登録・更新クラス
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        Fortify::authenticateUsing(function (Request $request) {
            $loginRequest = app(LoginRequest::class);

            $loginRequest->setContainer(app())
                        ->setRedirector(app('redirect'))
                        ->merge($request->all());

            $validated = $loginRequest->validate($request, $loginRequest->rules(), $loginRequest->messages());

            // ユーザー認証
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user;
            }
                return null;
        });

        // ログイン画面
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // 登録画面
        Fortify::registerView(function () {
            return view('auth.register');
        });
    }
}