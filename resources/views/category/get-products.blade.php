<x-app title="{{$category->name}}">

	<category-products :products="{{ $products }}" :user="{{ $user }}" :categories="{{$categories}}" :category="{{$category}}"/>
</x-app>
