<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'business_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.min' => 'Your name must be at least 2 characters long.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Your password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);
    }

    protected function create(array $data)
    {
        try {
            $user = new User();
            $user->name = $data['name'] ?? '';
            $user->email = $data['email'] ?? '';
            
            // Hash password
            if (isset($data['password']) && !empty($data['password'])) {
                $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                throw new \Exception('Password is required');
            }
            
            $user->business_name = isset($data['business_name']) && !empty($data['business_name']) ? $data['business_name'] : null;
            $user->phone = isset($data['phone']) && !empty($data['phone']) ? $data['phone'] : null;
            
            $user->save();
            
            return $user;
        } catch (\Exception $e) {
            // Log the actual error
            error_log('Registration error: ' . $e->getMessage());
            throw new \Exception('Registration failed: ' . $e->getMessage());
        }
    }
}
