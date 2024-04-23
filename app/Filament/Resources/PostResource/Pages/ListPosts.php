<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            '全部' => Tab::make(),
            '已發表' => Tab::make()->modifyQueryUsing(fn ($query) => $query->published()),
            '未發表' => Tab::make()->modifyQueryUsing(fn ($query) => $query->draft()),
        ];
    }
}
