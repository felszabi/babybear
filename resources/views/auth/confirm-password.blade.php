<x-guest-layout>
    
    <x-bs-alert status="warning">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </x-bs-alert>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <x-bs-text-input class="" type="password" id="confirmpassword" name="password" label="Jelszó" :messages="$errors->get('password')"/>
        <x-bs-primary-button value="Megerősítem" />
            
       
    </form>
</x-guest-layout>
