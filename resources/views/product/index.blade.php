<x-app title="Products">
	<product-table :products="{{ $products }}" :user="{{ $user }}" :categories="{{$categories}}"/>
</x-app>