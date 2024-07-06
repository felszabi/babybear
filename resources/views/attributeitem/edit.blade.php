<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Attribute Item name set') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form method="post" action="{{ route('attributeitem.update',['itemid'=> $attributeitem->id]) }}" class="mt-6 space-y-6">
				        @csrf
				        @method('post')

				        <div>
				            <x-input-label for="edit_attributeitem_name" :value="__('Attribute Name')" />
				            <x-text-input id="edit_attributeitem_name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" value="{{ $attributeitem->name }}" />
				            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
				        </div>

				        <div class="flex items-center gap-4">
				            <x-primary-button>{{ __('Save') }}</x-primary-button>
				        </div>
				    </form>
                </div>
                <div class="max-w-xl">
                	
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
