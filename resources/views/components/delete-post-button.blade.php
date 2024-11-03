{{-- resources/views/components/delete-post-button.blade.php --}}
<form method="POST" action="{{ route('posts.destroy', $post) }}">
    @csrf
    @method('DELETE')
    <x-danger-button onclick="return confirm('Tu es sûre de vouloir supprimer cette publication?')">
        {{ __('Supprimer') }}
    </x-danger-button>
</form>
