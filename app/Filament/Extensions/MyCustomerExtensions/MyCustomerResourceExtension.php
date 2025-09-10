<?php

namespace App\Filament\Extensions\MyCustomerExtensions;

use Closure;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Lunar\Models\Customer;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Lunar\Admin\Support\Extending\ResourceExtension;

class MyCustomerResourceExtension extends ResourceExtension
{
    public function extendForm(Form $form): Form
    {
        return $form
            ->schema([
                ...$form->getComponents(withHidden: true),
                
                Section::make()
                    ->columnSpan(4)
                    ->hidden(function (?Customer $record) {
                        if (!$record) return false;
                        
                        $customer = Customer::find($record->id);
                       
                        if (!$customer || !$customer->customerGroups) {
                            return false;
                        }
                        return $customer->customerGroups->first()->handle != 'wholesale';
                    })
                    ->schema([
                        Hidden::make('meta')
                            ->default(fn ($record) => (array) ($record?->meta ?? [])),
                        Toggle::make('meta.wholesale_approved')
                            ->label('Enable Access')
                ]),
                    
            ]);
               
    }


    public function extendTable(Table $table): Table
    {
        return $table
            ->columns([
                ...$table->getColumns(),
                TextColumn::make('addresses.postcode')
                    ->label(__('Postcodes'))
                    ->sortable()
                    ->searchable(),
            ]);
    }

    

    // protected static function isWholesaleCustomer(): bool
    // {
    //     if (!auth()->check()) {
    //         return false;
    //     }

    //     $customer = auth()->check() ? auth()->user()->customers->first() : null;
        
        
        
    //     if (!$customer) {
    //         return false;
    //     }
        
    //     return $customer->customerGroups
    //         ->where('handle', 'wholesale')
    //         ->isNotEmpty();
    // }

    // public function extendTable(Table $table): Table
    // {
    //     return $table->columns([
    //         ...$table->getColumns(),
    //         TextColumn::make('authentication_key')
    //             ->label('Key')
    //     ]);
    // }

}