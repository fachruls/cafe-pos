<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // Wajib untuk upload file
use App\Models\Product;
use App\Models\Category;

class ProductManager extends Component
{
    use WithFileUploads;

    public $name, $price, $category_id, $image;
    public $cat_name, $cat_type = 'food';

    public function saveCategory()
    {
        $this->validate([
            'cat_name' => 'required',
            'cat_type' => 'required'
        ]);
        
        Category::create([
            'name' => $this->cat_name, 
            'type' => $this->cat_type
        ]);
        
        $this->reset(['cat_name', 'cat_type']);
        session()->flash('success_cat', 'Kategori sukses diracik');
    }

    public function saveProduct()
    {
        $this->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'image' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);
        
        // Simpan gambar ke folder storage/app/public/products
        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        Product::create([
            'name' => $this->name,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'image_path' => $imagePath,
            'is_active' => true,
        ]);
        
        $this->reset(['name', 'price', 'category_id', 'image']);
        session()->flash('success_prod', 'Hidangan berhasil ditaruh ke etalase');
    }

    public function render()
    {
        return view('livewire.product-manager', [
            'categories' => Category::all(),
            'products' => Product::with('category')->latest()->get()
        ])->layout('components.layouts.app');
    }
}