<?php

namespace App\Livewire\Student;

use App\Models\Proposals;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentProposals extends Component
{

    public $proj_name, $proj_description, $proj_domain, $user_name, $counter = 1, $show_table;

    public $proposals;



    public function Fetchproposals()
    {
        $this->proposals = Proposals::where("group_no", Auth::user()->group_no)->get();
    }

    public function submitProposal()
    {


        $this->validate([
            'proj_name' => 'required|string',
            'proj_description' => 'required|string',
            'proj_domain' => 'required|string',

        ]);

        $proposals = Proposals::where("group_no", Auth::user()->group_no)->where("is_accepted", null)->get();
        $proposal_accepted = Proposals::where("group_no", Auth::user()->group_no)->where("is_accepted", 1)->get();

        if ($proposals->count() != 5) {
            $new_proposal = new Proposals([
                "proposal_name" => $this->proj_name,
                'proposal_description' => $this->proj_description,
                'proposal_domain' => $this->proj_domain,
                'group_no' => Auth::user()->group_no,
                'student' => Auth::user()->name,
            ]);
            $new_proposal->save();
            $this->Fetchproposals();
            $this->dispatch("proposal", ["message" => "Proposal Submitted Successfully!!", "type" => "success", "title" => "Good Job"]);
            $this->Fetchproposals();
        }else{
            $this->dispatch("proposal", ["message" => "You have reached your limit", "type" => "error", "success", "title" => "Goshhhhh!!"]);
        }

        if (!$this->toggleTable()) {
            $this->dispatch("proposal", ["message" => "Max Numbers Of Proposals Submitted!", "type" => "error", "success", "title" => "Opss"]);
        }

        $this->Fetchproposals();

    }

  

    public function deleteProposal($id)
    {
        $proposal = Proposals::where("proposal_id", $id)->first();
        // dd($repo);
        if ($proposal) {
            $proposal->delete();
            $this->Fetchproposals();
            $this->dispatch("file_deleted");
        }
    }
    public function toggleTable()
    {
        $proposals = Proposals::where("group_no", Auth::user()->group_no)->where("is_accepted", null)->get();
        $proposals_2 = Proposals::where("group_no", Auth::user()->group_no)->where("is_accepted", 1)->get();

        if ($proposals->count() <= 5 && $proposals_2->count() == 0) {
            $this->show_table = true;
        } else {
            $this->show_table = false;
        }
        return $this->show_table;
    }

    public function mount()
    {
        $this->toggleTable();
        $this->Fetchproposals();
    }

    public function render()
    {
        return view('livewire.student.student-proposals');
    }
}
