<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <x-bs-text-input class="" id="email" name="email" label="E-mail" :messages="$errors->get('email')"/>

        <!-- Password -->
        <x-bs-text-input class="" type="password" id="password" name="password" label="Jelszó" :messages="$errors->get('password')"/>
        

        <!-- Remember Me -->
        <x-bs-check-input class="" checked id="remember" name="remember" value="Jegyezzen meg!" />
       

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="mx-3 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <x-bs-primary-button value="Bejelentkezek" />
            
        </div>
    </form>
</x-guest-layout>
