<x-guest-layout>
    <x-bs-alert status="warning">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </x-bs-alert>

    @if (session('status') == 'verification-link-sent')
        <x-bs-alert>
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </x-bs-alert>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-bs-primary-button value="Kérem a megerősítő e-mailt" />
           
            
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-bs-primary-button value="Kijelentkezek" />
           
            
        </form>
    </div>
</x-guest-layout>
