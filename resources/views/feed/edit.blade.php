<form action="{{route('feed.update',$feed)}}" method="post">
	@csrf
    @method('post')
    <x-bs-text-input class="" :value="$feed->name" id="name" name="name" label="Feed név" :messages="$errors->get('name')"/>

    <x-bs-text-input class="" :value="$feed->src" id="src" name="src" label="Forrás" :messages="$errors->get('src')"/>

    <x-bs-text-input class="" :value="$feed->filename" id="filename" name="filename" label="Fájl" :messages="$errors->get('filename')"/>

    <x-bs-text-input class="" :value="$feed->keycolumn" id="keycolumn" name="keycolumn" label="Kulcsmező" :messages="$errors->get('keycolumn')"/>
    
    <x-bs-text-input class="" type="number" :value="$feed->pricemod" id="pricemod" name="pricemod" label="Ár szorzó" :messages="$errors->get('pricemod')"/>

    <x-bs-primary-button value="Módosít" />
</form>