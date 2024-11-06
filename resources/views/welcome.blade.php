<x-layout header="Posts" :isAuth="$isAuthenticated"> 
    <div id="posts">
        @forelse ($posts as $post)
            <li>{{ $post["title"] }} -----{{$post["content"]}} </li>
         
        @empty
            <p>No posts</p>
        @endforelse
    </div>
</x-layout>

