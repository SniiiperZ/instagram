<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Conversations
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-4">
        @if($conversations->isEmpty())
            <p class="text-center text-gray-500">Aucune conversation disponible</p>
        @else
            <div class="space-y-4">
                @foreach($conversations as $conversation)
                    <a href="{{ route('messages.show', ['conversation' => $conversation->id]) }}" class="block">
                        <div class="border rounded-lg p-4 shadow-sm hover:shadow-md transition duration-200 ease-in-out bg-white">
                            <h3 class="text-lg font-semibold text-gray-800">
                                Conversation avec {{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}
                            </h3>
                            <p class="text-gray-600 text-sm mt-2">
                                Dernier message : 
                                <span class="font-light">
                                    {{ $conversation->messages->last()->message ?? 'Aucun message' }}
                                </span>
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
