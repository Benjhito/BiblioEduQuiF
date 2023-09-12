<?php

namespace App\Http\Livewire\Members;

use App\Models\Member;
use Livewire\Component;
use Livewire\WithPagination;

class MemberSearch extends Component
{
    use WithPagination;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public $search = '';

    public function selectMember(Member $member)
    {
        $this->search = '';
        $this->emit('memberSelected', $member);
    }

    public function render()
    {
        $members = null; //[];

        if (!empty($this->search)) {
            $members = Member::lastName($this->search)
                ->orWhere->code($this->search)
                ->orderBy('last_name')
                ->paginate(10);
        }

        return view('livewire.members.member-search', compact('members'));
    }
}
