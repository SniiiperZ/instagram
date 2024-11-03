{{-- resources/views/components/post-header.blade.php --}}
<div>
    <h3 class="font-bold text-lg">
        <a href="{{ route('profile.show', $user) }}" class="text-blue-500">{{ $user->name }}</a>
    </h3>
    <p class="text-gray-600">{{ $caption }}</p>
</div>
