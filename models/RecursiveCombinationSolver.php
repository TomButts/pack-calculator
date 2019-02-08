<?php

namespace app\models;

class RecursiveCombinationSolver
{
    public $bestSum = false;
    
    public $bestCombo = false;
    
    public $altCombos = [];
    
    public $amount;
    
    public $numbers;
    
    public function __construct($amount)
    {
        $this->amount = $amount;
    }
    
    /**
     * Calculates the combination of numbers which when summed produce a value equal to 
     * or as close to the target as possible whilst also being greater than the target.
     * 
     * The calculation also considers the total numbers required for the minimum solution and
     * optimises to find the least required numbers for best total sum. 
     *
     * @param integer $target The target that the sum of the numbers must be equal to or greater than.
     * @param array $numbers An array of positive integers
     * @param array $currentCombo Array keeping track of the values in a combo during recursion.
     * @return void
     */
    public function calculate($target, $numbers, $currentCombo = [])
    {
        // This solution is greater than the target or exactly right
        if ($target <= 0) {
            $total = (abs($target) + $this->amount);
            
            // Set first answer as benchmark solution
            if ($this->bestSum === false) {
                $this->bestSum = $total;
                $this->bestCombo = $currentCombo;
                $currentCombo = [];
                return;
            }
            
            // Quit if solution is bigger than current best
            if ($total > $this->bestSum) {
                $currentCombo = [];
                return;
            }
            
            // If the solution is less than current best replace
            if ($total < $this->bestSum) {
                $this->bestSum = $total;
                $this->bestCombo = $currentCombo;
                
                // Reset alts
                $this->altCombo = [];
                
                $currentCombo = [];
                return;
            }
            
            // Alternative solution found at current best sum
            if ($total == $this->bestSum) {
                // If the solution has more numbers in it than current best quit
                if (count($currentCombo) > count($this->bestCombo)) {
                    $currentCombo = [];
                    return;
                }
                
                // Alternative has less numbers used
                if (count($currentCombo) < count($this->bestCombo)) {
                    // Replace current best combo
                    $this->bestCombo = $currentCombo;
                    
                } else if (count($currentCombo) == count($this->bestCombo)) {
                    // Add to alternate combos
                    $this->altCombos[] = $currentCombo;
                }
            }
            
            $currentCombo = [];
            return;
        }
        
        // The target has not been reached keep building combination
        foreach ($numbers as $index => $number) {
            $this->calculate($target - $number, $numbers, array_merge($currentCombo, [$number]));
        } 
    }
}