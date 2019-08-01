<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => (strlen((string)$this->content) > 100)? substr($this->content, 0, 200) . '...': $this->content,
            'created_at' => date('d-m-Y', strtotime($this->created_at)),
            'author' =>$this->user,//UserResource::collection($this->authorId),
        ];
    }
}
