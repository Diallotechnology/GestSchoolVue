<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanningRequest;
use App\Models\Planning;
use Illuminate\Http\Request;

final class PlanningController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanningRequest $request)
    {
        $validatedData = $request->validated();

        Planning::create($validatedData);

        flash('planning ajouter avec success!');

        return back();
    }

    public function export(Request $request)
    {
        $this->validate($request, [
            'classe_id' => 'required|exists:classes,id',
            'debut' => 'required|date',
            'fin' => 'required|date',
        ]);

        $planning = Planning::where('classe_id', $request->classe_id)
            ->whereBetween('debut', [$request->debut, $request->fin])
            ->get();

        $groupedPlanning = [];
        foreach ($planning as $plan) {
            $day = \Carbon\Carbon::parse($plan->debut)->format('l');
            $startTime = \Carbon\Carbon::parse($plan->debut);
            $endTime = \Carbon\Carbon::parse($plan->fin);

            while ($startTime < $endTime) {
                $nextTime = $startTime->copy()->addHours(2);
                $timeRange = $startTime->format('H:i') . ' - ' . $nextTime->format('H:i');
                $groupedPlanning[$day][$timeRange][] = $plan;
                $startTime = $nextTime;
            }
        }

        return view('planning.export_pdf', compact('groupedPlanning', 'planning'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Planning::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePlanningRequest $request, string $id)
    {
        $planning = Planning::findOrFail($id);

        $planning->update($request->validated());

        return response()->json($planning, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $planning = Planning::findOrFail($id);
        $planning->delete();

        return response()->json(null, 200);
    }
}
