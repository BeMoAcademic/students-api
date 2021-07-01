<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GlobalPopup;
use App\Models\GlobalText;
use Illuminate\Http\Request;

class PageController extends Controller {

    public function welcome(Request $request) {
        $studentWelcome = GlobalText::where('type', 'studentWelcome')->first() ?? "Welcome to your BeMo's Members Area!";

        $popups = $this->getPopups($request)->flatten();

        return $this->success([
            'text' => $studentWelcome,
            'popups' =>  $popups
        ]);
    }

    public function getPopups(Request $request) {
        // TODO Add login when Student, and other roles are in place
        return GlobalPopup::all();
    }
}
