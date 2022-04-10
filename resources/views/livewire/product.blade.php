<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Product Management') }}
    </h2>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                role="alert">
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
            @endif
            <button wire:click="create()"
                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                Create Student
            </button>
            @if($isModalOpen)
            @include('livewire.create')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">No.</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">Price</th>
                        <th class="px-4 py-2">Created_At</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td class="border px-4 py-2">{{ $product->id }}</td>
                        <td class="border px-4 py-2">
                            <img src="/images/{{ $product->image }}" alt="" />
                        </td>
                        <td class="border px-4 py-2">{{ $product->title }}</td>
                        <td class="border px-4 py-2 text-right">{{ number_format($product->price) }}</td>
                        <td class="border px-4 py-2">{{ $product->created_at}}</td>
                        <td class="border px-4 py-2">
                            <button wire:click="edit({{ $product->id }})" type="button"
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-500 text-base font-bold text-white shadow-sm hover:bg-blue-600">
                                Edit
                            </button>
                            <button wire:click="delete({{ $product->id }})" type="button"
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-red-500 text-base font-bold text-white shadow-sm hover:bg-red-600">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
