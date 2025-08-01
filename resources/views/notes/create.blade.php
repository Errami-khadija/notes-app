<x-app-layout>
<div class="max-w-xl mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Add Note</h1>

    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Title</label>
            <input type="text" name="title" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Content</label>
            <textarea name="content" rows="5" class="w-full border p-2 rounded" required></textarea>
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Save
        </button>
    </form>
</div>
</x-app-layout>
