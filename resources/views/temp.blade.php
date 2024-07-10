public function generateBills()
    {
        foreach ($this->members as $member) {
            MaintenanceBill::create([
                'member_id' => $member->member_id,
                'amount' => $this->amount,
                'status' => 0, // Default to unpaid
                'due_date' => $this->due_date,
                'billing_month' => $this->selected_month,
                'billing_year' => $this->selected_year,
            ]);
        }


        $this->fetchMembers();
    }