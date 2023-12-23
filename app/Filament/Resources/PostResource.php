<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\ColorPicker;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    //protected static ?string $modelLabel = 'Post';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Write a Post')
                ->description('write your new post.')
                ->collapsible()
                ->schema([
                        TextInput::make('title')->minLength(3)->maxLength(50)->required(),
                        RichEditor::make('content')->required()->columnSpanFull(),
                ])->columnSpan(2)->columns(2),

                Section::make('Meta')->schema([
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails'),

                        TagsInput::make('tags'),
                ])->columnSpan(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                ->toggleable(),
                //NumberColumn::make('reports'),
                TextColumn::make('content')
                ->html()
                ->limit(30),
                TextColumn::make('title')
                ->limit(30)
                ->tooltip(function (TextColumn $column): ?string {
                    $state = $column->getState();

                    if (strlen($state) <= $column->getCharacterLimit()) {
                        return null;
                    }

                    // Only render the tooltip if the column content exceeds the length limit.
                    return $state;
                })
                ->sortable()
                ->searchable()
                ->toggleable(),
                //TextColumn::make('comments'),
                //TextColumn::make('reports'),
                TextColumn::make('tags')->toggleable(),
                TextColumn::make('created_at')->label('Published on')
                ->date()
                ->sortable()
                ->searchable()
                ->toggleable(),
            ])
            ->filters([
                Filter::make('Reported Posts')->query(
                    function(Builder $query){
                        return $query->whereHas('reports')->get();
                    }
                )
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
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        if(auth()->user()->is_admin)
        return parent::getEloquentQuery();
        return parent::getEloquentQuery()->whereBelongsTo(auth()->user());
    }
}
