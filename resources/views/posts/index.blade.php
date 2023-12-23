@extends('layouts.post')
@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold text-center mt-40 mb-10">Welcome to the best Developers Blog</h1>

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
                                    {{-- {!! {{ Str::limit($post->content, 200, '...') }} !!} --}}
                                </p>
                                <div class="flex justify-between mt-4">
                                    <div class="flex items-center">
                                        <p class="text-sm text-gray-400">{{ $post->user->name }}</p>
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
