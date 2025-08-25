<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AccountSettingsPage extends Component
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $company;
    public string $currentPassword = '';
    public string $password = '';
    public string $password_confirmation = '';

    public $customer;

    public $edit = [
        'name' => false,
        'email' => false,
        'phoneNumber' => false,
        'company' => false,
        'password' => false
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->firstName = $user->first_name;
        $this->lastName = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->company = $user->company_name;

        $this->customer = auth()->check() ? auth()->user()->customers->first() : null;
    }

    /**
     * Update Name
     */
    public function updateName()
    {
        $this->validate(['firstName' => 'required|min:2']);
        $this->validate(['lastName' => 'required|min:2']);

        if ($this->customer) {
            $this->customer->update([
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'meta' => array_merge((array) $this->customer->meta ?? [], [
                    'first_name' => $this->firstName,
                    'last_name' => $this->lastName,
                ]),
            ]);
        }

        Auth::user()->update(['first_name' => $this->firstName]);
        Auth::user()->update(['last_name' => $this->lastName]);

        $this->edit['name'] = false;
        session()->flash('message', 'Name updated successfully.');
    }

    public function updateEmail()
    {
        $this->validate(['email' => 'required|email|unique:users,email,' . Auth::id()]);

        // Auth::user()->update(['email' => $this->email]);

        // if ($this->customer) {
        //     $this->customer->update([
        //         'meta' => array_merge((array) $this->customer->meta ?? [], [
        //             'email' => $this->email,
        //         ]),
        //     ]);
        // }

        $this->edit['email'] = false;
        session()->flash('message', 'Email updated successfully.');
    }

    /**
     * Update Phone Number
     */
    public function updatePhone()
    {
        $this->validate(['phone' => 'required']);

        if ($this->customer) {
            $this->customer->update([
                'meta' => array_merge((array) $this->customer->meta ?? [], [
                    'phone' => $this->phone,
                ]),
            ]);
        }

        Auth::user()->update(['phone' => $this->phone]);
        $this->edit['phoneNumber'] = false;
        session()->flash('message', 'Phone number updated successfully.');
    }

    /**
     * Update Company Name
     */
    public function updateCompany()
    {
        $this->validate(['company' => 'required']);

        if ($this->customer) {
            $this->customer->update([
                'company_name' => $this->company,
                'meta' => array_merge((array) $this->customer->meta ?? [], [
                    'company_name' => $this->company,
                ]),
            ]);
        }

        Auth::user()->update(['company_name' => $this->company]);
        $this->edit['company'] = false;
        session()->flash('message', 'Company name updated successfully.');
    }

    /**
     * Update Password
     */
    public function updatePassword()
    {
        $this->validate([
            'currentPassword' => ['required'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'Your current password is incorrect.');
            return;
        }

        $hashPassword = Hash::make($this->password);    

        $user->forceFill([
            'password' => $hashPassword,
        ])->save();

        if ($this->customer) {
            $this->customer->update([
                'meta' => array_merge((array) $this->customer->meta ?? [], [
                    'password' => $hashPassword,
                ]),
            ]);
        }

        $this->reset(['currentPassword', 'password', 'password_confirmation']);
        $this->edit['password'] = false;

        session()->flash('message', 'Password updated successfully.');
    }

    public function render()
    {
        return view('livewire.account-settings-page');
    }
}
