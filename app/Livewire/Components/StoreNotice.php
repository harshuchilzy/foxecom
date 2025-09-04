<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Configuration;

class StoreNotice extends Component
{
    public string $storeNotice;
    public bool $storeNoticeStatus;

    public function mount() 
    {
        $this->storeNotice = Configuration::getValue('store_notice', '');
        $this->storeNoticeStatus = Configuration::getValue('store_notice_enabled', false);
    }

    public function render()
    {
        return view('livewire.components.store-notice');
    }
}
