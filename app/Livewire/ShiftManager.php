<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class ShiftManager extends Component
{
    public $start_cash = 0;

    public function mount()
    {
        if (Auth::user()->activeShift()->exists()) {
            return redirect()->route('pos.index');
        }
    }

    public function openShift()
    {
        $this->validate(['start_cash' => 'required|numeric|min:0']);

        Shift::create([
            'user_id' => Auth::id(),
            'start_time' => now(),
            'start_cash' => $this->start_cash,
            'expected_cash' => $this->start_cash,
            'status' => 'open'
        ]);

        return redirect()->route('pos.index');
    }

    public function render()
    {
        return view('livewire.shift-manager')->layout('components.layouts.app');
    }
}