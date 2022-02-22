<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Database;
use App\Models\DatabaseBackup;
use App\Models\DatabaseRestore;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DatabaseRestoreController extends Controller
{
    /**
     * Get all of the backups for the given database.
     *
     * @param  Request              $request
     * @param  \App\Models\Database $database
     *
     * @return Response
     */
    public function index(Request $request, Database $database)
    {
        $this->authorize('view', $database->project);

        $restores = $database->restores->load('backup');

        if ($request->database_name) {
            $restores = $restores->filter(function ($restore) use ($request) {
                return $restore->backup->database_name == $request->database_name;
            });
        }

        return $restores->groupBy(function ($restore) {
            return $restore->backup->database_name;
        });
    }

    /**
     * Restore the database from the given backup.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \App\Models\DatabaseBackup $backup
     *
     * @return Response
     */
    public function store(Request $request, DatabaseBackup $backup)
    {
        $this->authorize('create', [DatabaseRestore::class, $backup->database]);

        if (! $backup->database->isProvisioned()) {
            throw ValidationException::withMessages([
                'database' => ['This database has not finished provisioning.'],
            ]);
        }

        return response()->json(
            $backup->restore(), 201
        );
    }
}
