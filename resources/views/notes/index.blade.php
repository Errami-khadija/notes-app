<x-app-layout>
<div class="max-w-2xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Your Notes</h1>

     <!-- Search Form -->
        <form method="GET" action="{{ route('notes.index') }}" class="mb-6">
            <input
                type="text"
                name="search"
                placeholder="Search notes..."
                value="{{ request('search') }}"
                class="w-full border border-gray-300 rounded px-4 py-2"
            />
        </form>

    <a href="{{ route('notes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        + Add New Note
    </a>

    <ul class="mt-6 space-y-4">
        @foreach ($notes as $note)
            <li class="border p-4 rounded shadow">
                <h2 class="text-xl font-semibold">{{ $note->title }}</h2>
                <p class="text-gray-700">{{ $note->content }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    🕒 Created on: {{ $note->created_at->format('d M Y - H:i') }}
                </p>
                <p class="text-sm text-gray-500">
                    ✏️ Last updated: {{ $note->updated_at->format('d M Y - H:i') }}
                </p>

                <div class="mt-2 flex space-x-2">
                    <a href="{{ route('notes.edit', $note->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach

        <div class="mt-6">
           {{ $notes->withQueryString()->links() }}
        </div>
    </ul>
</div>
</x-app-layout>
