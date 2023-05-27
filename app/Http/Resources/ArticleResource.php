<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request) : array
    {
        // Se omite la lleve data ya que el metodo encierra todo dentro de dicha llave
        return [
            'type' => 'articles',
            'id' => (string) $this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->resource->title,
                'slug' => $this->resource->slug,
                'content' => $this->resource->content,
            ],
            'links' => [
                'self' => url('api/v1/articles/' . $this->resource->getRouteKey())
            ]
        ];
    }
}