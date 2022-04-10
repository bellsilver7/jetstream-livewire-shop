<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;

    public $products, $title, $content, $image, $price, $product_id;
    public $isModalOpen = false;

    public function render()
    {
        $this->products = Product::all();
        return view('livewire.product');
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

    private function resetCreateForm()
    {
        $this->title = '';
        $this->content = '';
        $this->image = '';
        $this->price = 0;
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->user_id = 1;
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
            'user_id' => 1,
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
}
