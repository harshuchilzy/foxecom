<?php

namespace App\Filament\Extensions\MyOrderExtensions;

use Closure;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;
use Lunar\Admin\Support\Extending\ResourceExtension;
use Lunar\Admin\Support\Actions\Orders\UpdateStatusBulkAction;

class MyOrderResourceExtension extends ResourceExtension
{

    public function extendTable(Table $table): Table
    {
        return $table
            ->columns([
                ...$table->getColumns(),
                TextColumn::make('billingAddress.postcode')
                    ->label(__('lunarpanel::order.table.postcode.label'))
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('meta.Payment Method')
                    ->label('Payment Method')
                    ->formatStateUsing(function ($state) {
                        return match($state) {
                            'cash-in-hand' => 'Pay with Cash',
                            'pay-via-bank' => 'Pay via Bank',
                            'ngenius' => 'Pay via Card',
                            default => $state,
                        };
                    }),
            ])
            ->actions([
                ...$table->getActions(), // Keep existing actions
                DeleteAction::make()
                    ->action(function (Model $record) {
                        if (method_exists($record, 'addresses') && $record->addresses()->exists()) {
                            $record->addresses()->delete();
                        }

                        if (method_exists($record, 'lines') && $record->lines()->exists()) {
                            $record->lines()->delete();
                        }

                        $record->shippingZone()->detach();
                        
                        if (method_exists($record, 'transactions') && $record->transactions()->exists()) {
                            $record->transactions()->delete();
                        }
                        
                        $record->delete();
                    }),
                ])
            ->bulkActions([
                BulkActionGroup::make([
                    UpdateStatusBulkAction::make('update_status')
                        ->deselectRecordsAfterCompletion(),
                DeleteBulkAction::make()
                        ->icon('')
                        ->action(function (Collection $records) {
                            $records->each(function (Model $record) {

                                if (method_exists($record, 'addresses') && $record->addresses()->exists()) {
                                    $record->addresses()->delete();
                                }

                                if (method_exists($record, 'lines') && $record->lines()->exists()) {
                                    $record->lines()->delete();
                                }

                                $record->shippingZone()->detach();

                                if (method_exists($record, 'transactions') && $record->transactions()->exists()) {
                                    $record->transactions()->delete();
                                }

                                $record->delete();
                            });
                        }),
                ]),
            ]);
    }

}