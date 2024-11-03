{{-- resources/views/components/add-comment-form.blade.php --}}
<form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4">
    @csrf
    <textarea 
        name="body" 
        class="w-full border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring-blue-500 transition mb-4" 
        rows="2" 
        placeholder="Ajouter un commentaire..."
    ></textarea>
    <x-primary-button type="submit">
        Commenter
    </x-primary-button>
</form>
