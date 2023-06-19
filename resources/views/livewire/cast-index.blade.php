<section class="container mx-auto p-6 font-mono">
    <div class="w-full flex mb-4 p-2 justify-end">
        <form class="flex space-x-4 shadow bg-white rounded-md m-2 p-2">
            <div class="p-1 flex items-center">
                <label for="tmdb_id_g" class="block text-sm font-medium text-gray-700 mr-4">Cast Tmdb Id</label>
                <div class="relative rounded-md shadow-sm">
                    <input wire:model="castTMDBId" id="tmdb_id_g" name="tmdb_id_g"
                        class="px-3 py-2 border border-gray-300 rounded" placeholder="Cast ID" />
                </div>
            </div>
            <div class="p-1">
                <button type="button" wire:click="generateCast"
                    class="inline-flex items-center justify-center py-2 px-4 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-green-700 transition duration-150 ease-in-out disabled:opacity-50">
                    <span>Generate</span>
                </button>
            </div>
        </form>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr
                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Poster</th>
                        <th class="px-4 py-3">Manage</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if (count($casts))
                        @foreach ($casts as $cast)
                            <tr wire:key="cast-{{ $cast->id . $cast->tmdb_id }}" class="text-gray-700">
                                <td class="px-4 py-3 border">
                                    {{ $cast->name }}
                                </td>
                                <td class="px-4 py-3 text-ms font-semibold border">
                                    {{ $cast->slug }}
                                </td>
                                <td class="px-4 py-3 text-xs border">
                                    <img src="https://image.tmdb.org/t/p/w500/{{ $cast->poster_path }}"
                                        class="w-12 h-12 rounded" />
                                </td>
                                <td class="px-4 py-3 text-sm border">
                                    <x-m-secondary-button wire:click="showEditCastModal({{ $cast->id }})">Edit
                                    </x-m-secondary-button>
                                    <x-m-button wire:click="deleteCast({{ $cast->id }})"
                                        class="bg-red-500 hover:bg-red-700 text-white">
                                        Delete
                                    </x-m-button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-gray-700">
                            <td colspan="5" class="px-4 py-3 border text-center">No Record Found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="m-2 p-2">
                {{ $casts->links() }}
            </div>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="showCastModal">
        <x-slot name="title">Update Cast</x-slot>
        <x-slot name="content">
            <form>
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <input type="text" wire:model="castName" id="name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('castName')
                            <span class="text-red-500 -textsm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Poster Path</label>
                    <div class="mt-2">
                        <input type="text" wire:model="castPosterPath" id="name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        @error('castPosterPath')
                            <span class="text-red-500 -textsm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-m-secondary-button wire:click="toggleCastModal(true)">Cancel</x-m-secondary-button>&nbsp;
            <x-m-button wire:click="updateCast">Update</x-m-button>
        </x-slot>
    </x-jet-dialog-modal>
</section>
