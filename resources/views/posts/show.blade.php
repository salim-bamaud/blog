@extends('layouts.post')
@section('content')
    @if (session()->has('success'))
        <h3 class="bg-green-500 text-white rounded p-4 mt-20 m-4"> {{ session('success') }} </h3>
    @endif


    <div class="bg-white shadow-md rounded-md p-4 mt-20 m-10 flex justify-center text-center">
        <div class="flex flex-col items-center">
            <h2 class="text-xl font-semibold mb-2 mt-4">{{ $post->title }}</h2>
            <img src="
            @if ($post->thumbnail === null) {{ asset('/no-thumbnail-image.jpg') }}
            @else
            {{ asset('storage/' . $post->thumbnail) }} @endif"
                alt="Post Thumbnail" class="w-100 h-80 mt-10 mb-8 rounded">
            <p class="text-gray-600">{{ $post->content }}</p>
            <p class="text-sm text-gray-400">{{ $post->user->name }}</p>
            <p class="text-sm text-gray-400">{{ $post->created_at->format('M d, Y') }}</p>

            <div class="mt-10 p-4 justify-start">
                comments: {{ ' ' . $post->comments->count() }}
                <hr>

                <!-- Comment Form -->
                @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        @error('content')
                            <p class="text-red-500">error occured!</p>
                        @enderror
                        <textarea name="content" class="w-full p-2 rounded-md border-gray-300" placeholder="Write a comment..." rows="3"></textarea>

                        <button type="submit"
                            class="mt-0 mb-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Submit</button>
                    </form>
                @else
                    <div class="m-4">
                        <a href="{{ route('filament.admin.auth.login') }}"
                            class="mb-4 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">Log in
                            to comment </a>
                    </div>
                @endauth
                <!-- Displaying comments -->
                @forelse ($post->comments as $comment)
                    @if ($comment->parent_id == null)
                        <div class="bg-gray-100 p-4 rounded-md mb-4">
                            <p class="text-sm text-gray-400">
                                @if (Auth::id() == $comment->user_id)
                                    {{ 'You' . ' @' . $comment->created_at->format('M d, Y') }}
                                @else
                                    {{ $comment->user->name . ' @ ' . $comment->created_at->format('M d, Y') }}
                                @endif
                            </p>
                            <p class="text-gray-600">{{ $comment->content }}</p>

                            <!-- Show replies -->
                            @if ($comment->replies->count() > 0)
                                <div class="mt-4 ml-4">
                                    <h4 class="text-sm font-medium">Replies:</h4>
                                    @foreach ($comment->replies as $reply)
                                        <div class="bg-gray-200 p-2 rounded-md mt-2">
                                            <p class="text-sm text-gray-400">
                                                @if (Auth::id() == $reply->user_id)
                                                    {{ 'You' . ' @' . $reply->created_at->format('M d, Y') }}
                                                @else
                                                    {{ $reply->user->name . ' @ ' . $reply->created_at->format('M d, Y') }}
                                                @endif
                                            </p>
                                            <p class="text-gray-600">{{ $reply->content }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @auth
                                <!-- Reply field and button -->
                                <form action="{{ route('comments.store', $comment->id) }}" method="POST"
                                    class="mt-4 flex opacity-60">
                                    @csrf
                                    <div class="mr-2 flex-grow">
                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                        <input type="text" name="content" id="content" class="w-full rounded-md"
                                            placeholder="Write a reply">
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="bg-blue-500 text-white px-2 py-1 rounded-md text-sm">Reply</button>
                                    </div>
                                </form>
                            @endauth
                        </div>
                    @endif
                @empty
                    <div class="bg-gray-100 p-4 rounded-md mb-4">
                        <p class="text-sm text-gray-400">
                            No comments.</p>
                    </div>
                @endforelse

                @auth
                    <!-- Add the report button -->
                    <button class="text-red-500" id="reportButton{{ $post->id }}" data-toggle="modal"
                        data-target="#reportModal{{ $post->id }}">Report</button>

                    <!-- Add the report modal -->
                    <div class="hidden" id="reportModal{{ $post->id }}">
                        <form action="{{ route('post.report', $post->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="text" name="content" id="reason" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                @endauth

            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the report button element
            var reportButton = document.getElementById('reportButton{{ $post->id }}');

            // Get the report modal element
            var reportModal = document.getElementById('reportModal{{ $post->id }}');

            // Add click event listener to the report button
            reportButton.addEventListener('click', function() {
                if (reportModal.style.display === 'block') {
                    // Hide the report modal
                    reportModal.classList.remove('show');
                    reportModal.style.display = 'none';
                    reportModal.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('modal-open');
                } else {
                    // Show the report modal
                    reportModal.classList.add('show');
                    reportModal.style.display = 'block';
                    reportModal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('modal-open');
                }
            });
        });
    </script>
@endsection
