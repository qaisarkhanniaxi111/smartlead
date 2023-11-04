<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResponseTraining\UpdateRequest;
use App\Models\Link;
use App\Models\ResponseTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function editTraining()
    {
        $user = auth()->user();

        if (! $user) {
            return back()->withErrors('Unable to find the user, please refresh webpage and try again. If still problem persists contact with administrator');
        }

        $userDetail = $user->userDetail;
        $responseTrainings = $user->responseTrainings;
        $links = $user->links;

        return view('auth.trainings.edit', compact('userDetail', 'responseTrainings', 'links'));
    }

    public function updateTraining(UpdateRequest $request)
    {
        $request->validated();

        $user = auth()->user();

        if (! $user) {
            return back()->withErrors('Unable to find the user, please refresh webpage and try again. If still problem persists contact with administrator');
        }

        try {

            DB::beginTransaction();

            $this->updateUserDetail($user, $request);

            $this->updateResponseTrainings($user, $request);

            $this->updateLinks($user, $request);

            session()->flash('alert-success', 'Data saved successfully');

            DB::commit();

        }
        catch (\Exception $ex) {
            DB::rollBack();
            return back()->withErrors($ex->getMessage());
        }

        return back();

    }

    public function deleteResponseTraining($trainingId)
    {
        $training = ResponseTraining::find($trainingId);

        if (! $training) {
            return response()->json([
                'error' => 'Unable to find the records, please refresh the webpage and try again. If still problem persists contact with administrator'
            ], 404);
        }

        $training->delete();

        return response()->json([
            'message' => 'Response Training removed successfully'
        ], 201);
    }

    public function deleteLinks($linkId)
    {
        $link = Link::find($linkId);

        if (! $link) {
            return response()->json([
                'error' => 'Unable to find the records, please refresh the webpage and try again. If still problem persists contact with administrator'
            ], 404);
        }

        $link->delete();

        return response()->json([
            'message' => 'Link removed successfully'
        ], 201);
    }

    private function updateUserDetail($user, $request)
    {
        if ($user->userDetail) {
            $user->userDetail->update([
                'company_name' => $request->company_name,
                'company_description' => $request->company_description,
                'event_name' => $request->event_name,
                'event_duration_in_minutes' => $request->event_duration
            ]);
        }
        else {
            $user->userDetail()->create([
                'company_name' => $request->company_name,
                'company_description' => $request->company_description,
                'event_name' => $request->event_name,
                'event_duration_in_minutes' => $request->event_duration
            ]);
        }
    }

    private function updateResponseTrainings($user, $request)
    {
        if (count($user->responseTrainings) > 0) {


            $responseTrainingIds = $request->responseTrainingIds;

            foreach ($request->reply_from_lead as $index => $responseTraining) {

                $responseTrainingId = isset($responseTrainingIds[$index]) ? $responseTrainingIds[$index]: null;

                $responseTraining = ($responseTrainingId) ? $user->responseTrainings->find($responseTrainingId) : new ResponseTraining();

                $responseTraining->reply_from_lead = $request->reply_from_lead[$index];
                $responseTraining->ideal_sdr_response = $request->ideal_sdr_response[$index];

                $user->responseTrainings()->save($responseTraining);

            }

            // $userResponseTrainings = $user->responseTrainings->map( function($training) {
            //     return $training->id;
            // });

            // foreach ($request->reply_from_lead as $index => $training) {

            //     $responseId = isset($userResponseTrainings[$index]) ? $userResponseTrainings[$index]: $index + 1;
            //     $userResponseTraininingDetail = $user->responseTrainings()->findOrNew($responseId); // Use findOrNew to create or update as needed

            //     $userResponseTraininingDetail->reply_from_lead = $request->reply_from_lead[$index];
            //     $userResponseTraininingDetail->ideal_sdr_response = $request->ideal_sdr_response[$index];
            //     $userResponseTraininingDetail->save();

                // $training->update([
                //     'reply_from_lead' => $request->reply_from_lead[$i],
                //     'ideal_sdr_response' => $request->ideal_sdr_response[$i]
                // ]);

            // }

        }
        else {

            for ($i = 0; $i < count($request->reply_from_lead); $i++) {

                $user->responseTrainings()->create([
                    'reply_from_lead' => $request->reply_from_lead[$i],
                    'ideal_sdr_response' => $request->ideal_sdr_response[$i]
                ]);

            }

        }
    }

    private function updateLinks($user, $request)
    {
        if (count($user->links) > 0) {

            $linkIds = $request->link_ids;

            foreach ($request->links_key as $index => $link) {

                $linkId = isset($linkIds[$index]) ? $linkIds[$index]: null;

                $link = ($linkId) ? $user->links->find($linkId) : new Link();
                // dd($request->links_key[$index]);
                $link->key = $request->links_key[$index];
                $link->value = $request->links_value[$index];

                $user->links()->save($link);

            }

        }
        else {

            for ($i = 0; $i < count($request->links_key); $i++) {

                $user->links()->create([
                    'key' => $request->links_key[$i],
                    'value' => $request->links_value[$i]
                ]);

            }
        }
    }

}
