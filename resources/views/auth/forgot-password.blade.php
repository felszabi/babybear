<x-guest-layout>
    <x-bs-alert status="warning">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </x-bs-alert>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <x-bs-text-input class="" :value="old('email')" id="email" name="email" label="E-mail" :messages="$errors->get('email')"/>

        <x-bs-primary-button value="E-mail küldése a jelszóval" />
            

    </form>
</x-guest-layout>
