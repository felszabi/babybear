<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('All Attribute Item') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('List of attributes item.') }}
        </p>
    </header>

    <ul>
    @foreach ($attributeitems as $aitem)
        <li>{{ $aitem->name }}<a href="{{route('attributeitem.edit',['itemid'=>$aitem->id])}}"> módosít </a>
        <a href="{{route('attributeitem.destroy',['itemid'=>$aitem->id])}}"> töröl </a> </li>
    @endforeach
    </ul>
</section>