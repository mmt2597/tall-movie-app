<section class="container mx-auto p-6 font-mono">
    <div class="w-full flex mb-4 p-2 justify-end">
        <x-jet-button wire:click="toggleTagModal(true)">Create Tag</x-jet-button>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr
                        class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Manage</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($tags && !$tags->isEmpty())
                        @foreach ($tags as $tag)
                            <tr class="text-gray-700" wire:key="{{ $loop->index }}">
                                <td class="px-4 py-3 border">
                                    {{ $tag->tag_name }}
                                </td>
                                <td class="px-4 py-3 text-ms font-semibold border">{{ $tag->slug }}</td>
                                <td class="px-4 py-3 text-sm border">
                                    <x-m-secondary-button wire:click="showEditTagModal({{ $tag->id }})">Edit
                                    </x-m-secondary-button>
                                    <x-m-button wire:click="deleteTag({{ $tag->id }})"
                                        class="bg-red-500 hover:bg-red-700 text-white">
                                        Delete
                                    </x-m-button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="p-2 text-center">No Records Found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <x-jet-dialog-modal wire:model="showTagModal">
        @if ($tagId)
            <x-slot name="title">Update Tag</x-slot>
        @else
            <x-slot name="title">Create Tag</x-slot>
        @endif
        <x-slot name="content">
            <form>
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                    <div class="mt-2">
                        <input type="text" wire:model="tagName" id="name"
                            class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">
            <x-m-secondary-button wire:click="toggleTagModal">Cancel</x-m-secondary-button>&nbsp;
            @if ($tagId)
                <x-m-button wire:click="updateTag">Update</x-m-button>
            @else
                <x-m-button wire:click="createTag">Create</x-m-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>
</section>
