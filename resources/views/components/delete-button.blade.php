<form action="{{ $route }}" method="POST" onsubmit="return confirm('Tu es sûre de vouloir supprimer cette publication?');" class="absolute top-4 right-4">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</form>
