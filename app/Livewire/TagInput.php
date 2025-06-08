<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TagInput extends Component
{
    public $tags = [];
    public $tagInput = '';

    public function addTag()
    {
        $tag = trim($this->tagInput);

        if ($tag && !in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }

        $this->tagInput = '';
    }

    public function removeTag($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags); // Reindex array
    }

    public function render()
    {
        return view('livewire.tag-input');
    }
}
