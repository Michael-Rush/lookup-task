<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LookupRequest;
use App\Services\LookupSelectionService;
use App\Services\LookupService;

/**
 * Class LookupController
 *
 * @package App\Http\Controllers
 */
class LookupController extends Controller
{
    public function __construct(LookupService $lookupService)
    {
        $this->lookupService = $lookupService;
    }

    public function lookup(LookupRequest $request): array
    {
        //Set to variable whether we are using username or id
        if($request->has('username')) {
            $identifier_type = 'username';
        } else {
            $identifier_type = 'id';
        }

        //Set to a single named variable the id/username
        $identifier = $request->input($identifier_type);

        //Get the instance of LookupUser based on which platform is requested
        try {
            $lookupMethod = LookupSelectionService::getLookupPlatform(
                strtolower($request->input('type'))
            );
        } catch (\Exception $e) {
            return [
                'success' => false,
                'errors' => $e->getMessage()
            ];
        }
        $this->lookupService->setPlatform($lookupMethod);

        return $this->lookupService->getUser($identifier_type, $identifier);
    }
}
