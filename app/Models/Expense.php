<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural of the model name
    protected $table = 'expenses';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'society_id',
        'amount',
        'expense_type_id',
        'remark',
        'reference_number',
        'bill_month',
        'bill_year',
    ];

    // Define the relationship to the Society model
    public function society()
    {
        return $this->belongsTo(Societies::class);
    }

    public function loadExpenseTypes()
    {
        $this->expenseTypes = ExpenseType::all();
    }

    // Define the relationship to the ExpenseType model
    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class, 'expense_type_id');
    }

    
}
