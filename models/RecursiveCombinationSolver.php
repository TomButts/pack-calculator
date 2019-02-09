<?php

namespace app\models;

class RecursiveCombinationSolver
{
    /**
     * Tracks the best sum found by combinations
     *
     * @var mixed
     */
    public $bestSum = false;
    
    /**
     * Tracks the combination of intergers with best sum
     *
     * @var mixed
     */
    private $bestCombo = false;
    
    /**
     * Alternate combinations just as good as best
     *
     * @var array
     */
    public $altCombos = [];
    
    /**
     * The sum that the solver will try to equal or find
     * closest greater than combination
     *
     * @var int
     */
    public $target;
    
    /**
     * The numbers allowed for the sum. Inifintely available in for each value. 
     *
     * @var array 
     */
    public $numbers;

    /**
     * Publicly consumable wrapper for RecursiveCombinationSolver::calculate
     * 
     * Sets up tracking props and returns the combo answer.
     *
     * @param int $target
     * @param array $numbers
     * @return array $bestCombo
     */
    public function calculateCombinations($target, $numbers)
    {
        $this->target = $target;
        $this->numbers = $numbers;

        // Eliminate combos quicker by starting with largest numbers
        rsort($numbers);

        $this->calculate($target, $numbers);

        return $this->bestCombo;
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
    private function calculate($target, $numbers, $currentCombo = [])
    {
        // This solution is greater than the target or exactly right
        if ($target <= 0) {
            // Because were subtracting towards the target
            // solutions greater than the total will become negative
            $total = (abs($target) + $this->target);
            
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