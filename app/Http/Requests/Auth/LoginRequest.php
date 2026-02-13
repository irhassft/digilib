<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input = $this->only('email', 'password');
        $credentials = [];

        // Log input untuk debug
        Log::info('Login attempt', [
            'input_email_username' => $input['email'],
            'password_length' => strlen($input['password']),
        ]);

        // Check if input is email or username
        if (filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            $credentials = ['email' => $input['email'], 'password' => $input['password']];
            Log::info('Login attempt - using email', ['email' => $input['email']]);
        } else {
            $credentials = ['username' => $input['email'], 'password' => $input['password']];
            Log::info('Login attempt - using username', ['username' => $input['email']]);
        }

        // Manual authentication to support unhashed stored passwords
        $field = key($credentials);
        $value = $credentials[$field];

        $user = User::where($field, $value)->first();

        // If user not found or password doesn't match, treat as failed
        if (! $user) {
            RateLimiter::hit($this->throttleKey());
            Log::warning('Login failed - user not found', ['field' => $field, 'value' => $value]);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $stored = $user->password;

        $matches = false;

        // If stored looks like a bcrypt hash, use Hash::check
        if (is_string($stored) && preg_match('/^\$2[aby]\$/', $stored)) {
            $matches = Hash::check($input['password'], $stored);
        } else {
            // Plaintext comparison (use hash_equals to mitigate timing attacks)
            $matches = hash_equals((string) $stored, (string) $input['password']);
        }

        if (! $matches) {
            RateLimiter::hit($this->throttleKey());
            Log::warning('Login failed - invalid password', ['user_id' => $user->id]);

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // Authentication successful — log the user in
        Auth::login($user, $this->boolean('remember'));

        Log::info('Login success', ['user_id' => $user->id]);
        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
