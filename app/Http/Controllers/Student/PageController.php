<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\GlobalPopup;
use App\Models\GlobalText;
use App\Models\Plan;
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

    public function tests(Request $request) {
        list($simulationsTexts, $simulationsCompletedTexts) = $this->getSimulationGlobalTexts();

        $doneTakes = $request->user()->user->testTakesWithTrashed->where('finished', true)->mapToGroups(function($take) {
            $name = $take->plan_id ? Plan::withTrashed()->find($take->plan_id)->program_name : 'Individual Simulations';
            return [$name => $take];
        });

        $accessibleTests = $request->user()->user->accessibleTests->mapToGroups(function($item) {
            $name = $item->pivot->plan_id ? Plan::withTrashed()->find($item->pivot->plan_id)->program_name : 'Individual Simulations';
            return [$name => $item];
        });

        return $this->success([
            'text' => [
                'simulation' => $simulationsTexts,
                'completed' => $simulationsCompletedTexts,
            ],
            'tests' =>  [
                'done' => $doneTakes,
                'active' => $accessibleTests,
            ]
        ]);
    }

    public function programs(Request $request) {

        $plans = $request->user()->user->plans;

        return $this->success(PlanResource::collection($plans));
    }

    private function getPopups(Request $request) {
        // TODO Add login when Student, and other roles are in place
        return GlobalPopup::all();
    }

    /**
     * @return array
     */
    public function getSimulationGlobalTexts(): array
    {
        $globalText = GlobalText::whereIn('type', ['studentSimulations', 'studentCompletedSimulations'])->get();
        $simulationsTexts = $globalText->where('type', 'studentSimulations')->first();
        $simulationsCompletedTexts = $globalText->where('type', 'studentCompletedSimulations')->first();
        return array($simulationsTexts, $simulationsCompletedTexts);
    }
}
