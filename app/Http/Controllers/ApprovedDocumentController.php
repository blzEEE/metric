<?php

namespace App\Http\Controllers;

use App\Http\Resources\InputDocumentResource;
use App\Models\InputDocument;
use App\Models\InputDocumentStatus;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApprovedDocumentRequest;

class ApprovedDocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  ApprovedDocumentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApprovedDocumentRequest $request)
    {
        $approvedDocumentValidated = $request->validated();
        $inputDocument = InputDocument::findOrFail($approvedDocumentValidated['id']);
        $inputDocument->input_document_status_id = InputDocumentStatus::STATUS_APPROVE;
        $inputDocument->save();
        return new InputDocumentResource($inputDocument);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inputDocument = InputDocument::findOrFail($id);

        if (Auth::user()->user_role_id === UserRole::ROLE_SYSADMIN) {
            $inputDocument->input_document_status_id = InputDocumentStatus::STATUS_DRAFT;
            $inputDocument->save();
            return new InputDocumentResource($inputDocument);
        } else {
            return response(null, 403);
        }

    }
}
