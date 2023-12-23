<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // public function mutateFormDataBeforeSave(array $data){
    //     $data['content'] = str_replace(['<pre>','</pre>'], ['<code>' , '</code>'] , $data['content']);
    //     return $data;
    // }
}
