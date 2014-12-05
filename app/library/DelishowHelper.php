<?php 
class DelishowHelper {

    public function calculateRating( $ratings )
    {
        $total = "";
        $count = count( $ratings );
        if( $count == 0 ) return $count;

        foreach ($ratings as $rating)
        {
            $total = $total + $rating->rating;
        }
        return $total / $count;
    }
}