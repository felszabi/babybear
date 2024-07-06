<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <x-bs-text-input class="" :value="old('email', $request->email)" id="email" name="email" label="E-mail" :messages="$errors->get('email')"/>

        

        <!-- Password -->
         <x-bs-text-input class="" type="password" id="password" name="password" label="Jelszó" :messages="$errors->get('password')"/>


        <!-- Confirm Password -->
        <x-bs-text-input class="" type="password" id="password_confirmation" name="password_confirmation" label="Jelszó újra" :messages="$errors->get('password_confirmation')"/>
        
        <x-bs-primary-button value="Mentés" />
           

    </form>
</x-guest-layout>
