<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $title, $content, $image, $price, $product_id;
    public $isModalOpen = false;
    public $pageSize = 5;

    public function render()
    {
        return view('livewire.product', [
            'products' => Product::where('user_id', Auth::id())
                ->latest()
                ->paginate($this->pageSize)
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->user_id = Auth::id();
        $this->title = $product->title;
        $this->content = $product->content;
        $this->image = $product->image;
        $this->price = $product->price;

        $this->openModalPopover();
    }

    public function store()
    {
        $filePath = $this->image->store('products');

        Product::updateOrCreate(['id' => $this->product_id], [
            'user_id' => Auth::id(),
            'title' => $this->title,
            'content' => $this->content,
            'image' => $filePath,
            'price' => $this->price,
        ]);
        session()->flash('message', $this->product_id ? 'Product updated.' : 'Product created.');
        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        session()->flash('message', 'Product deleted.');
    }

    //==================================================
    // Private Functions
    //==================================================

    private function resetCreateForm()
    {
        $this->product_id = '';
        $this->title = '';
        $this->content = '';
        $this->image = '';
        $this->price = 0;
    }
}
