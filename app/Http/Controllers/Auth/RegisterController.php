<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\CompanyGroupRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CompanyRepository;
use App\Repositories\CompanyGroupRepository;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /** @var UserRepositoryInterface */
    private $userRepo;

    /** @var CompanyRepositoryInterface */
    private $companyRepo;

    /** @var CompanyGroupRepositoryInterface */
    private $companyGroupRepo;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        UserRepositoryInterface $userRepo = null,
        CompanyRepositoryInterface $companyRepo = null,
        CompanyGroupRepositoryInterface $companyGroupRepo = null
    ) {
        $this->middleware('guest');
        $this->userRepo = $userRepo ?? new UserRepository();
        $this->companyRepo = $companyRepo ?? new CompanyRepository();
        $this->companyGroupRepo = $companyGroupRepo ?? new CompanyGroupRepository();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $companyGroup = $this->companyGroupRepo->create([
            'name' => $data['name'],
        ]);

        $company = $this->companyRepo->create([
            'name' => $data['name'],
            'company_group_id' => $companyGroup->id,
            'is_master' => true,
        ]);

        return $this->userRepo->create([
            'name' => $data['name'],
            'role' => Role::COMPANY,
            'company_id' => $company->id,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
