<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <a href="{{ route('users.index') }}"
                       class="inline-block mb-4 bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded">
                        ← Back
                    </a>

                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-600 text-white rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        {{-- Name --}}
                        <div class="mb-4">
                            <label class="block mb-2">Name</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   class="w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg"
                                   required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <label class="block mb-2">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg"
                                   required>
                        </div>

                        {{-- Password --}}
                        <div class="mb-4">
                            <label class="block mb-2">Password</label>
                            <input type="password"
                                   name="password"
                                   class="w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg"
                                   required>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">
                            <label class="block mb-2">Confirm Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="w-full border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg"
                                   required>
                        </div>

                        {{-- Roles as Checkboxes --}}
                        @if(isset($roles) && $roles->count())
                            <div class="mb-4">
                                <label class="block mb-2 font-semibold">Assign Roles</label>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($roles as $role)
                                        <label class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 p-2 rounded">
                                            <input type="checkbox"
                                                   name="roles[]"
                                                   value="{{ $role->id }}"
                                                   class="form-checkbox"
                                                   {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                            <span>{{ $role->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Create User
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
