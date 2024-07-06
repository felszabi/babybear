<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('New Attribute') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Add a new attribute.') }}
        </p>
    </header>

    <form method="post" action="{{ route('attribute.new') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')

        <div>
            <x-input-label for="add_attribute_name" :value="__('Attribute Name')" />
            <x-text-input id="add_attribute_name" name="name" type="text" class="mt-1 block w-full" autocomplete="name" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'attribute-added')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>