<x-app title="{{$user->name}}">
	<show-category :products="{{ $products }}" :user="{{ $user }}"/>
</x-app>
