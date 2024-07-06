<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('New Product') }}
        </h2>
    </x-slot>

    <div class="mx-auto w-75">
        <form method="post" action="{{ route('product.store') }}">
            @csrf
            @method('post')
            <x-bs-text-input class="" :value="old('name')" id="name" name="name" label="Terméknév" :messages="$errors->get('name')"/>
            
            <x-bs-text-input class="" :value="old('sku')" id="sku" name="sku" label="SKU" :messages="$errors->get('sku')"/>

            <x-bs-text-input class="" type="number" :value="old('price')" id="price" name="price" label="Ár" :messages="$errors->get('price')"/>

            <x-bs-primary-button value="Létrehozás" />
        </form>
    </div>

    
</x-app-layout>