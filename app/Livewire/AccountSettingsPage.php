<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class AccountSettingsPage extends Component
{
      public $name;
    public $email;
    public $phone;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateName()
    {
        $this->validate(['name' => 'required|min:2']);
        
        // Auth::user()->update(['name' => $this->name]);
        session()->flash('message', 'Name updated successfully.');
    }

    public function updateEmail()
    {
        $this->validate(['email' => 'required|email|unique:users,email,'.Auth::id()]);
        
        // Auth::user()->update(['email' => $this->email]);
        session()->flash('message', 'Email updated successfully.');
    }

    public function updatePhone()
    {
        $this->validate(['phone' => 'required']);
        
        // Auth::user()->update(['phone' => $this->phone]);
        session()->flash('message', 'Phone number updated successfully.');
    }

    public function render()
    {
        return view('livewire.account-settings-page');
    }
}
