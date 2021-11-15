<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $content = $this->content()->first() ? $this->content()->first()->content : null;

        return [
          'name' => $this->name,
            'file_name' => $this->file_name,
            'uuid' => $this->uuid,
            'preview_url' => $this->preview_url,
            'original_url' => $this->original_url,
            'extension' => $this->extension,
            'size' => $this->size,
            'content' => $content,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
