{{-- resources/views/components/comments-list.blade.php --}}
<div class="mt-4 border-t border-gray-200 pt-2">
    @foreach ($comments as $comment)
        <div class="flex items-start space-x-2 mb-4">
            <a href="{{ route('profile.show', $comment->user) }}" class="text-blue-500 font-semibold">{{ $comment->user->name }}:</a>
            <p class="text-gray-600">{{ $comment->body }}</p>
        </div>
    @endforeach
</div>
