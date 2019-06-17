<?php

namespace App\Http\Controllers\Api;

use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;

use Phpsa\LaravelApiController\Http\Api\Controller;
use App\Models\Auth\User;

use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

use App\Events\Frontend\Auth\UserRegistered;
use App\Events\Frontend\Auth\UserLoggedIn;

/**
 * Class UpdatePasswordController.
 */
class AuthController extends Controller
{

		 /**
     * Eloquent model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function model()
    {
        return new User;
    }

    /**
     * Repository for the current model.
     *
     * @return App\Repositories\BaseRepository
     */
    protected function repository()
    {
        return new UserRepository;
	}

	/**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }

	/**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt([$this->username() => request('email'), 'password' => request('password')])){
			$user = Auth::user();

			// Check to see if the users account is confirmed and active
			if (! $user->isConfirmed()) {
				auth()->logout();

				// If the user is pending (account approval is on)
				if ($user->isPending()) {
					return $this->errorUnauthorized(__('exceptions.frontend.auth.confirmation.pending'));
				}

				return $this->setStatusCode(401)->respond([
					'message' => 'Your account is not confirmed. Please click the confirmation link in your e-mail',
					'resend' =>  route('frontend.auth.account.confirm.resend', e($user->{$user->getUuidName()}))
				]);
			}

			if (! $user->isActive()) {
				auth()->logout();

				return $this->errorUnauthorized(__('exceptions.frontend.auth.deactivated'));
			}

			event(new UserLoggedIn($user));

			if (config('access.users.single_login')) {
				auth()->logoutOtherDevices($request->password);
			}


			$success['token'] =  $user->createToken('MyApp')->accessToken;
			return $this->respond($success);
		}
		return $this->errorUnauthorized();
	}

	/**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		abort_unless(config('access.registration'), 404);

		$validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
		]);


		if ($validator->fails()) {
            return $this->errorWrongArgs($validator->messages());
		}


		$user = $this->repository->create($request->only('first_name', 'last_name', 'email', 'password'));

        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (config('access.users.confirm_email') || config('access.users.requires_approval')) {
            event(new UserRegistered($user));

			return $this->respondCreated(null, config('access.users.requires_approval') ?
			__('exceptions.frontend.auth.confirmation.created_pending') :
			__('exceptions.frontend.auth.confirmation.created_confirm'));

		}

		$success['token'] =  $user->createToken('MyApp')->accessToken;
		return $this->respond($success);

	}

	public function logout() {
        $accessToken = Auth::user()->token();
        $accessToken->revoke();
        return response()->json(null, 204);
    }




    /**
     * @param UpdatePasswordRequest $request
     *
     * @throws \App\Exceptions\GeneralException
     * @return mixed
     */
    public function session(Request $request)
    {
       return $request->user();
    }
}
