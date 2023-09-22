<x-app title="{{$user->name}}">
	<show-user :products="{{ $products }}" :user="{{ $user }}" :roles="{{$roles}}"/>
</x-app>
