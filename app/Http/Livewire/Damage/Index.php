<?php

namespace App\Http\Livewire\Damage;

use Livewire\Component;
use App\Models\DamageProdInfo;

class Index extends Component
{
    public function render()
    {
        $damageProd = DamageProdInfo::get();

        return view('livewire.damage.index', compact('damageProd'));
    }
}
