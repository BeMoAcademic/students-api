<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\GlobalPopup;
use App\Models\GlobalText;
use Illuminate\Http\Request;

class PageController extends Controller {


    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Student API",
     *      description="Student api information",
     *      @OA\Contact(
     *          email="info@bemoacademicconsulting.com"
     *      )
     * )
     */


    /**
     * @OA\Get(
     *      path="/api/student/welcome",
     *      operationId="getProjectsList",
     *      tags={"Users"},
     *      summary="Get welcome screen contents",
     *      description="Returns global text and popup content",
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *     security={ * {"sanctum": {}}, * },
     *     )
     */

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
