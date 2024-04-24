<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $breadcrumb = '文章管理';

    protected static ?string $modelLabel = '文章';

    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = '功能參考';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = '文章管理';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->columns(3)
                    ->schema([
                        Grid::make()
                            ->columnSpan(2)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('標題')
                                            ->required(),
                                    ]),
                                Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('category_id')
                                            ->label('分類')
                                            ->relationship('category', 'name')
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('名稱')
                                                    ->required(),
                                            ])
                                            ->required(),
                                        Forms\Components\Select::make('tags')
                                            ->label('標籤')
                                            ->multiple()
                                            ->relationship('tags', 'name')
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->label('名稱')
                                                    ->required(),
                                            ]),
                                    ]),
                                Section::make()
                                    ->schema([
                                        Forms\Components\RichEditor::make('content')
                                            ->label('內容'),
                                    ]),
                            ]),
                        Grid::make()
                            ->columnSpan(1)
                            ->schema([
                                Section::make()
                                    ->schema([
                                        Forms\Components\Toggle::make('is_published')
                                            ->label('發表')
                                            ->default(false)
                                            ->inline()
                                            ->live()
                                            ->afterStateUpdated(function ($get, $set) {
                                                $set('published_at', $get('is_published') ? now()->toDateTimeString() : null);
                                            })
                                            ->required(),
                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('發表時間')
                                            ->required(fn ($get) => $get('is_published')),
                                        Forms\Components\DateTimePicker::make('expired_at')
                                            ->label('到期時間'),
                                    ]),
                                Section::make('選項')
                                    ->schema([
                                        Forms\Components\TextInput::make('priority')
                                            ->label('優先級')
                                            ->numeric()
                                            ->placeholder('預設')
                                            ->extraInputAttributes(['min' => 1, 'max' => 255]),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('自訂網址字段'),
                                        Forms\Components\Textarea::make('excerpt')
                                            ->label('摘要')
                                            ->autosize(),
                                        Forms\Components\FileUpload::make('thumbnail')
                                            ->label('縮圖')
                                            ->image()
                                            ->imageEditor(),
                                    ])
                                    ->collapsible(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('標題')
                    ->description(fn ($record) => str($record->excerpt)->limit(60))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('author.avatar')
                    ->label('作者')
                    ->circular()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_published')
                    ->label('發表'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('發表時間')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('建立時間')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('更新時間')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
