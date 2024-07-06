<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name  -->
        <x-bs-text-input class="" id="regname" name="name" label="Név" :messages="$errors->get('name')"/>


        <!-- Email Address -->
        <x-bs-text-input class="" id="regemail" name="email" label="E-mail" :messages="$errors->get('email')"/>


        <!-- Password -->

        <x-bs-text-input class="" type="password" id="regpassword" name="password" label="Jelszó" :messages="$errors->get('password')"/>


        <!-- Confirm Password -->
        <x-bs-text-input class="" type="password" id="regpassword_confirmation" name="password_confirmation" label="Jelszó újra" :messages="$errors->get('password_confirmation')"/>
        

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-bs-primary-button class="" value="Regisztrálok" />
            
        </div>
    </form>
</x-guest-layout>
