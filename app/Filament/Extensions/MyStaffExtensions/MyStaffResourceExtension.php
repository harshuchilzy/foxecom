<?php

namespace App\Filament\Extensions\MyStaffExtensions;

use Closure;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
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

class MyStaffResourceExtension extends ResourceExtension
{
    public function extendForm(Form $form): Form
    {
        return $form
            ->schema([
                ...$form->getComponents(withHidden: true),
                
                TextInput::make('authentication_key')
                    ->label('Authentication Key')
            ]);
               
    }

    public function extendTable(Table $table): Table
    {
        return $table->columns([
            ...$table->getColumns(),
            TextColumn::make('authentication_key')
                ->label('Key')
        ]);
    }

}