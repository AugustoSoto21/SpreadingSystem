<?php 
function search_permits($module,$permit)
{
	/*$search="No";
	$permit=App\Models\Permits::where('permit',$permit)->where('module',$module)->first();
    if(!is_null($permit)){
    	foreach ($permit->user as $key) {    		
    		if ($key->pivot->id_user==\Auth::User()->id) {
    			$search=$key->pivot->status;
    		}
    	}
    }
	return $search;*/
    return "Si";
}