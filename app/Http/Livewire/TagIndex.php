<?php

namespace App\Http\Livewire;

use App\Models\Tag;
use Livewire\Component;
use Illuminate\Support\Str;

class TagIndex extends Component
{
    public $showTagModal = false;
    public $tagName;
    public $tagId;
    public $tags;

    public function mount()
    {
        $this->tags = Tag::get();
    }

    public function toggleTagModal($resetForm = false)
    {
        $this->showTagModal = !$this->showTagModal;
        if ($resetForm) $this->reset(['tagName', 'tagId']);
    }

    public function createTag()
    {
        Tag::create([
            'tag_name' => $this->tagName,
            'slug' => Str::slug($this->tagName)
        ]);

        $this->reset();
        $this->tags = Tag::all();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag Created Successfully']);
    }

    public function updateTag()
    {
        Tag::findOrFail($this->tagId)->update([
            'tag_name' => $this->tagName,
            'slug' => Str::slug($this->tagName)
        ]);

        $this->reset();
        $this->tags = Tag::all();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag Updated Successfully']);
    }

    public function deleteTag($tagId)
    {
        Tag::findOrFail($tagId)->delete();
        $this->reset();
        $this->tags = Tag::all();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Tag Deleted Successfully']);
    }

    public function showEditTagModal($tagId)
    {
        $this->reset(['tagName']);

        $this->tagId = $tagId;
        $tag = Tag::find($tagId);
        $this->tagName = $tag->tag_name;

        $this->toggleTagModal();
    }

    public function render()
    {
        return view('livewire.tag-index');
    }
}
