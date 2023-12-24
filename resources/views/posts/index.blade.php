@extends('layouts.post')
@section('content')
    <div class="pt-16">
        <form action="/">
            <div class="relative border-2 border-gray-100 m-4 rounded-lg">
                <div class="absolute top-4 left-3">
                    <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i>
                </div>
                <input type="text" name="search"
                    class="h-14 w-full pl-10 pr-20 rounded-lg z-0 focus:shadow focus:outline-none" placeholder="Search ..." />
                <div class="absolute top-2 right-2">
                    <button type="submit"
                        class="h-10 w-20 text-white rounded-lg bg-gray-500 hover:bg-gray-800">Search</button>
                </div>
            </div>
        </form>
        <h1 class="text-3xl font-semibold text-center mt-10 mb-10">Welcome to the best Developers Blog</h1>

        <section class="max-w-3xl mx-auto">

            @forelse ($posts as $post)
                <div class="bg-white shadow-md rounded-md p-4 mb-4">
                    <a href="{{ route('home.show', $post->slug) }}">
                        <div class="flex">
                            <img src="@if ($post->thumbnail === null) {{ asset('/no-thumbnail-image.jpg') }}
            @else
            {{ asset('storage/' . $post->thumbnail) }} @endif"
                                alt="Post Thumbnail" class="w-16 h-16 mr-4 rounded">
                            <div>
                                <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
                                <p class="text-gray-600">
                                    {!! Illuminate\Support\Str::limit($post->content, 200) !!}
                                </p>
                                <ul class="flex justify-center">
                                    @forelse ($post->tags as $tag)
                                        <li
                                            class="flex items-center justify-center bg-gray-800 text-white rounded-xl py-1 px-3 mr-2 text-xs">
                                            <a href="/?tag={{ $tag }}"> {{ $tag }} </a>
                                        </li>
                                    @empty
                                    @endforelse
                                </ul>

                                <div class="flex justify-between mt-4">
                                    <div class="flex items-center">
                                        <p class="text-sm text-gray-400">
                                            @if (Auth::id() == $post->user_id)
                                                <b>You</b>
                                            @else
                                                {{ $post->user->name }}
                                            @endif
                                        </p>
                                    </div>
                                    <p class="text-sm text-gray-400">{{ $post->comments->count() . ' comments' }}</p>

                                    <p class="text-sm text-gray-400">{{ $post->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="bg-white shadow-md rounded-md p-4 mb-4">
                    <h2 class="text-xl font-semibold mb-2">There is no Posts until now </h2>
                    <p class="text-gray-600">login or register to make some posts.</p>
                </div>
            @endforelse
        </section>



        <div class="mt-4 flex justify-center">
            {{ $posts->links() }}
        </div>



        <div class="flex justify-center mt-6">



            @auth
                <a href="{{ route('filament.admin.auth.login') }}"
                    class="bg-gray-800 hover:bg-gray-600 text-white py-2 px-4 rounded-md mr-4">Create
                    New Post </a>
            @else
            @endauth

        </div>
    </div>
@endsection
