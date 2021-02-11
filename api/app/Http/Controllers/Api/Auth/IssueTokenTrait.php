<?php 

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait{

    public function issueToken(Request $request, $grantType, $scope = ""){

        $params = [
            'grant_type' => $request->grant_type,
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'scope' => $request->scope
        ];

        if($grantType !== 'social'){
            $params['username'] = $request->username ?: $request->email;
        }

        $request->request->add($params);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }
}