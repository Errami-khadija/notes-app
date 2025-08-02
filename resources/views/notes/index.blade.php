<x-app-layout>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastel Notes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pastel-pink': '#FFE1E6',
                        'pastel-blue': '#E1F0FF',
                        'pastel-purple': '#F0E1FF',
                        'pastel-green': '#E1FFE6',
                        'pastel-yellow': '#FFF9E1',
                        'pastel-orange': '#FFE8E1'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .note-card {
            transition: all 0.3s ease;
            transform: translateY(0);
        }
        .note-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .floating-button {
            transition: all 0.3s ease;
        }
        .floating-button:hover {
            transform: scale(1.1);
        }
        .modal-backdrop {
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-pastel-pink via-pastel-blue to-pastel-purple min-h-screen">
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-md border-b border-white/20 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-400 to-pink-400 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-blue-400">Fekra</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                         <form method="GET" action="{{ route('notes.index') }}" >
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Search notes..."
                                    value="{{ request('search') }}"
                                    class="pl-10 pr-4 py-2 bg-white/60 border border-white/30 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent w-64"
                                />
                                 <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                 </svg>
                        </form>
                    </div>
                    <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-6 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Notes</p>
                        <p class="text-2xl font-bold text-gray-800" id="totalNotes">12</p>
                    </div>
                    <div class="w-12 h-12 bg-pastel-blue rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Categories</p>
                        <p class="text-2xl font-bold text-gray-800">5</p>
                    </div>
                    <div class="w-12 h-12 bg-pastel-green rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Favorites</p>
                        <p class="text-2xl font-bold text-gray-800">3</p>
                    </div>
                    <div class="w-12 h-12 bg-pastel-yellow rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl p-6 border border-white/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Recent</p>
                        <p class="text-2xl font-bold text-gray-800">7</p>
                    </div>
                    <div class="w-12 h-12 bg-pastel-purple rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap gap-3 mb-8">
            <button class="px-6 py-2 bg-white/80 text-gray-800 rounded-full font-medium border border-white/30 hover:bg-white transition-colors filter-tab active" data-filter="all">All Notes</button>
            <button class="px-6 py-2 bg-white/60 text-gray-600 rounded-full font-medium border border-white/30 hover:bg-white/80 transition-colors filter-tab" data-filter="work">Work</button>
            <button class="px-6 py-2 bg-white/60 text-gray-600 rounded-full font-medium border border-white/30 hover:bg-white/80 transition-colors filter-tab" data-filter="personal">Personal</button>
            <button class="px-6 py-2 bg-white/60 text-gray-600 rounded-full font-medium border border-white/30 hover:bg-white/80 transition-colors filter-tab" data-filter="ideas">Ideas</button>
            <button class="px-6 py-2 bg-white/60 text-gray-600 rounded-full font-medium border border-white/30 hover:bg-white/80 transition-colors filter-tab" data-filter="favorites">Favorites</button>
        </div>

        <!-- Notes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="notesGrid">
            <!-- Sample Notes -->
               @foreach ($notes as $note)
            <div class="note-card bg-pastel-pink/80 backdrop-blur-sm rounded-2xl p-6 border border-white/30 cursor-pointer" data-category="work"
                 onclick="openViewNoteModal(`{{ $note->title }}`, `{{ addslashes($note->content) }}`, `{{ $note->updated_at->format('d M Y - H:i') }}`)">
                <div class="flex items-start justify-between mb-4">
                    <span class="px-3 py-1 bg-pink-200/60 text-pink-700 text-xs font-medium rounded-full">Work</span>
                    <button class="text-gray-400 hover:text-pink-600 transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    </button>
                </div>
                <h3 class="font-semibold text-gray-800 mb-2">{{ $note->title }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $note->content }}</p>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>{{ $note->updated_at->format('d M Y - H:i')}}</span>
                    <span><form action="{{ route('notes.destroy', $note->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form></span>
                </div>
            </div>
             @endforeach

        </div>

            <div class="mt-6">
                 {{ $notes->withQueryString()->links() }}
              </div>
    </main>

    <!-- Floating Add Button -->
    <button class="floating-button fixed bottom-8 right-8 w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full shadow-lg hover:shadow-xl flex items-center justify-center z-50" onclick="openNoteModal()">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
    </button>

    <!-- Note Modal -->
    <div id="noteModal" class="fixed inset-0 bg-black/30 modal-backdrop hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden">
            <div class="p-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-800">Create New Note</h2>
                    <button onclick="closeNoteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
          <form method="POST" action="{{ route('notes.store') }}">
    @csrf
    <div class="p-6 space-y-4">
        <input
            type="text"
            name="title"
            placeholder="Note title..."
            class="w-full text-lg font-medium border border-gray-300 rounded-lg px-4 py-2 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-300"
            required
        >
        
        <select name="category" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-300">
            <option value="">Select Category</option>
            <option value="Work">Work</option>
            <option value="Personal">Personal</option>
            <option value="Ideas">Ideas</option>
            <option value="Other">Other</option>
        </select>
        
        <textarea
            name="content"
            placeholder="Start writing your note..."
            class="w-full h-60 border border-gray-300 rounded-lg px-4 py-2 placeholder-gray-400 resize-none focus:outline-none focus:ring-2 focus:ring-purple-300"
            required
        ></textarea>
    </div>

    <div class="p-4 border-t border-gray-100 flex justify-end">
        <div class="flex items-center space-x-3">
            <button type="button" onclick="closeNoteModal()" class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                Cancel
            </button>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl hover:from-purple-600 hover:to-pink-600 transition-colors">
                Save Note
            </button>
        </div>
    </div>
</form>

        </div>
    </div>

    <!-- View Note Modal -->
<div id="viewNoteModal" class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50 p-4 modal-backdrop">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-auto p-6">
        <div class="flex justify-between items-center border-b pb-4 mb-4">
            <h2 id="modalNoteTitle" class="text-2xl font-semibold text-gray-800">Note Title</h2>
            <button onclick="closeViewNoteModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="text-sm text-gray-500 mb-4" id="modalNoteDate">Updated at</div>
        <div id="modalNoteContent" class="text-gray-700 whitespace-pre-wrap leading-relaxed">
            Note content...
        </div>
    </div>
</div>


<!-- Note Modal -->
<div id="noteModal" class="fixed inset-0 bg-black/30 modal-backdrop hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl">
        <form method="POST" action="{{ route('notes.store') }}" class="p-6 space-y-4">
            @csrf
            <div class="flex justify-between items-center border-b pb-4">
                <h2 class="text-xl font-semibold text-gray-800">Add New Note</h2>
                <button type="button" onclick="closeNoteModal()" class="text-gray-400 hover:text-gray-600 transition">
                    ✖
                </button>
            </div>

            <!-- Title -->
            <input name="title" required type="text" placeholder="Note title..." class="w-full text-lg font-medium border border-gray-200 rounded-lg p-2 placeholder-gray-400">

            <!-- Category -->
            <select name="category" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-300">
                <option value="">Select Category</option>
                <option value="work">Work</option>
                <option value="personal">Personal</option>
                <option value="ideas">Ideas</option>
                <option value="other">Other</option>
            </select>

            <!-- Content -->
            <textarea name="content" required placeholder="Start writing your note..." class="w-full h-40 border border-gray-200 rounded-lg p-2 placeholder-gray-400 resize-none"></textarea>

            <!-- Actions -->
            <div class="flex justify-end pt-4 border-t">
                <button type="button" onclick="closeNoteModal()" class="mr-3 px-4 py-2 text-gray-500 hover:text-gray-700">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openNoteModal() {
    document.getElementById("noteModal").classList.remove("hidden");
    document.getElementById("noteModal").classList.add("flex");
}
function closeNoteModal() {
    document.getElementById("noteModal").classList.add("hidden");
    document.getElementById("noteModal").classList.remove("flex");
}
</script>


<script>
    function openViewNoteModal(title, content, date) {
        document.getElementById('modalNoteTitle').textContent = title;
        document.getElementById('modalNoteContent').textContent = content;
        document.getElementById('modalNoteDate').textContent = "Updated at: " + date;
        document.getElementById('viewNoteModal').classList.remove('hidden');
        document.getElementById('viewNoteModal').classList.add('flex');
    }

    function closeViewNoteModal() {
        document.getElementById('viewNoteModal').classList.add('hidden');
        document.getElementById('viewNoteModal').classList.remove('flex');
    }
</script>


    
</body>
</html>
</x-app-layout>
