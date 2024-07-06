<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('All Attribute') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('List of attributes.') }}
        </p>
    </header>

    <ul>
    @foreach ($attributes as $attribute)
        <li>{{ $attribute->name }}<a href="{{route('attribute.edit',['attributeid'=>$attribute->id])}}"> módosít </a>
        <a href="{{route('attribute.destroy',['attributeid'=>$attribute->id])}}"> töröl </a> </li>
    @endforeach
    </ul>
</section>