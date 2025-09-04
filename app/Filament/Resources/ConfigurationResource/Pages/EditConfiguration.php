<?php

namespace App\Filament\Resources\ConfigurationResource\Pages;

use App\Filament\Resources\ConfigurationResource;
use Filament\Actions;
use App\Models\Configuration;
use Illuminate\Support\Facades\Cache;
use Filament\Resources\Pages\EditRecord;

class EditConfiguration extends EditRecord
{
    protected static string $resource = ConfigurationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // We'll handle saving in the afterSave method
        return [];
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        
        // Save admin new order email settings
        Configuration::setValue('admin_new_order_email', $data['admin_new_order_email']);
        Configuration::setValue('admin_new_order_email_enabled', $data['admin_new_order_email_enabled'], 'boolean');
        
        // Save wholesale new customer email settings
        Configuration::setValue('wholesale_new_customer_email', $data['wholesale_new_customer_email']);
        Configuration::setValue('wholesale_new_customer_email_enabled', $data['wholesale_new_customer_email_enabled'], 'boolean');
        
        // Save store notice settings
        Configuration::setValue('store_notice', $data['store_notice']);
        Configuration::setValue('store_notice_enabled', $data['store_notice_enabled'], 'boolean');
        
        // Clear any cached configurations
        Cache::forget('app-configurations');
    }
    
    protected function resolveRecord($key): \Illuminate\Database\Eloquent\Model
    {
        // Return a dummy model since we're not editing a specific record
        return new Configuration();
    }
    
    protected function fillForm(): void
    {
        // Pre-fill the form with existing values
        $this->form->fill([
            'admin_new_order_email' => Configuration::getValue('admin_new_order_email', ''),
            'admin_new_order_email_enabled' => Configuration::getValue('admin_new_order_email_enabled', false),
            'wholesale_new_customer_email' => Configuration::getValue('wholesale_new_customer_email', ''),
            'wholesale_new_customer_email_enabled' => Configuration::getValue('wholesale_new_customer_email_enabled', false),
            'store_notice' => Configuration::getValue('store_notice', ''),
            'store_notice_enabled' => Configuration::getValue('store_notice_enabled', false),
        ]);
    }
}
