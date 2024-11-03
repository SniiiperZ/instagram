<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    <form action="{{ route('search') }}" method="GET" class="flex items-center space-x-2">
        <input 
            type="text" 
            name="query" 
            placeholder="Rechercher une publication ou des utilisateurs..."
            class="border-gray-300 rounded-md p-2 w-full focus:border-blue-500 focus:ring-blue-500 transition"
        >
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
            Rechercher
        </button>
    </form>
</div>
