<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feed hozzáadása') }}
        </h2>
    </x-slot>

    <div class="mx-auto w-75">
        <form method="post" action="{{ route('feed.store') }}">
            @csrf
            @method('post')
            <x-bs-text-input class="" :value="old('name')" id="name" name="name" label="Feed név" :messages="$errors->get('name')"/>
            
            <x-bs-text-input class="" :value="old('src')" id="src" name="src" label="Forrás" :messages="$errors->get('src')"/>

            <x-bs-text-input class="" :value="old('filename')" id="filename" name="filename" label="Fájl" :messages="$errors->get('filename')"/>

            <x-bs-text-input class="" :value="old('keycolumn')" id="keycolumn" name="keycolumn" label="Kulcsmező" :messages="$errors->get('keycolumn')"/>
            
            <x-bs-text-input class="" type="number" :value="old('pricemod')" id="pricemod" name="pricemod" label="Ár szorzó" :messages="$errors->get('pricemod')"/>

            <x-bs-primary-button value="Létrehozás" />
        </form>
    </div>

    
</x-app-layout>