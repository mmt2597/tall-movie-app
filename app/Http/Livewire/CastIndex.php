<?php

namespace App\Http\Livewire;

use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Cast;
use App\Services\TMDB\PersonService;

class CastIndex extends Component
{
    public $castTMDBId;
    public $castName;
    public $castPosterPath;
    public $castId;

    public $showCastModal = false;
    protected $rules = [
        'castName' => 'required',
        'castPosterPath' => 'required'
    ];

    public function toggleCastModal($resetForm = false)
    {
        $this->showCastModal = !$this->showCastModal;
        if ($resetForm) {
            $this->reset();
            $this->resetValidation();
        };
    }

    public function generateCast(PersonService $personService)
    {
        $newCast = $personService->getPerson($this->castTMDBId);
        if(isset($newCast->success) && !$newCast->success) {
            $this->dispatchBrowserEvent('banner-message', ['style' => 'warning', 'message' => 'Cast doesn\'t exists']);
            return;
        }

        $cast = Cast::where('tmdb_id', $newCast->id);
        if(!$cast->exists()){
            Cast::create([
                'tmdb_id' => $newCast->id,
                'name' => $newCast->name,
                'slug' => Str::slug($newCast->name),
                'poster_path' => $newCast->profile_path
            ]);
        } else {
            $this->dispatchBrowserEvent('banner-message', ['style' => 'warning', 'message' => 'Cast exists']);
        }
    }

    public function showEditCastModal($id)
    {
        $this->castId = $id;
        $this->loadCast();
        $this->toggleCastModal();

    }

    public function loadCast()
    {
        $cast = Cast::findOrFail($this->castId);

        $this->castName = $cast->name;
        $this->castPosterPath = $cast->poster_path;
    }

    public function updateCast()
    {
        $this->validate();
        $cast = Cast::findOrFail($this->castId);
        $cast->update([
            'name' => $this->castName,
            'poster_path' => $this->castPosterPath
        ]);

        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Cast updated']);
        $this->reset();
    }

    public function deleteCast($id)
    {
        Cast::findOrFail($id)->delete();
        $this->dispatchBrowserEvent('banner-message', ['style' => 'success', 'message' => 'Cast deleted']);
        $this->reset();
    }

    public function render()
    {
        $casts = Cast::paginate(5);
        return view('livewire.cast-index', compact('casts'));
    }
}
