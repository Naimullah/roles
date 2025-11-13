<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Articles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                @can('create articles')
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('articles.create') }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            + Create Article
                        </a>
                    </div>
                @endcan

                    <table class="min-w-full text-left text-sm text-gray-500 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Text</th>
                                <th class="px-4 py-2">Author</th>
                                <th class="px-4 py-2">Created At</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($articles as $article)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="px-4 py-2">{{ $article->id }}</td>
                                    <td class="px-4 py-2">{{ $article->title }}</td>
                                    <td class="px-4 py-2">{{ $article->text }}</td>

                                    <td class="px-4 py-2">{{ $article->author }}</td>
                                    <td class="px-4 py-2">{{ $article->created_at->format('Y-m-d') }}</td>

                                    <td class="px-4 py-2 flex gap-2">
                                     
                                        {{-- Edit --}}
                                        <a href="{{ route('articles.edit', $article->id) }}"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('articles.destroy', $article->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                Delete
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Empty state --}}
                    @if ($articles->count() == 0)
                        <p class="text-center text-gray-400 mt-4">No articles found.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
