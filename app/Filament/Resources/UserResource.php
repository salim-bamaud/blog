<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\PostsRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord:true),
                TextInput::make('password')->password()->required()->visibleOn('create'),
                Toggle::make('is_admin')
                ->onIcon('heroicon-m-check-circle')
                ->offIcon('heroicon-m-user')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('name')->sortable()->searchable(),

                TextColumn::make('is_admin')->sortable()->searchable()
                    ->badge()
                    ->color(function(string $state): string{
                    return $state == true ? 'success' : 'danger';
                }),

                TextColumn::make('email')->label('Email Address')->sortable()->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
