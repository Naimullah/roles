<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Permissions') }}
            </h2>
            <a href="{{route('permissions.index')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
            
        </div>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100"> -->
                   <form action="{{ route('permissions.update',$permissions->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" :value="__('Permission Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="$permissions->name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update Permission') }}
                        </x-primary-button> 
                    </div>
                     </form>
                <!-- </div>
            </div> -->
        </div>
    </div>
</x-app-layout>
